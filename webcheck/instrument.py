#!/usr/bin/python
import os
import sys
import ConfigParser
from static import INSTRUMENTATION_SECTION, PROXY_SECTION


def php_instrumentation(proxy):
    return '''<?php  
            
            runkit_function_copy ( 'mysql_query', 'mysql_query_old' );
            
            runkit_function_redefine('mysql_query', '$query , $link_identifier=null', '// Modified mysql_query()
            
               //--------------- Connect to proxy ----------------
               $client = stream_socket_client("tcp://''' + proxy + '''", $errno, $errorMessage);
            
               if ($client === false) {
                throw new UnexpectedValueException("Failed to connect: $errorMessage");
               }
            
               fwrite($client, $query);
            
               // Get response from proxy.
               $response = stream_get_contents($client);
            
               if ($response == "true" or $response == "false") {
                if ($response == "true") {
                    $result = TRUE;
                } else {
                    $result = FALSE;
                }
               } else {
                $newQuery = $response;
                if (is_null($link_identifier)) {
                  $result = mysql_query_old ( $newQuery);
                } else {
                  $result = mysql_query_old ( $newQuery, $link_identifier);
                }
               }
            
               // Close connection to proxy.
               fclose($client);
               return $result;');
            
            // -------------
            '''


if __name__ == "__main__":
    
    if len(sys.argv) != 2:
        print ('Usage: ' + sys.argv[0] + ' <config file>')
        sys.exit(-1)
              
    config_file = sys.argv[1]        
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    app_path = config.get(INSTRUMENTATION_SECTION, 'PATH')
    
    proxy_ip = config.get(PROXY_SECTION, 'IP')
    proxy_port = config.getint(PROXY_SECTION, 'PORT')
    proxy = '{}:{}'.format(proxy_ip, proxy_port)

    
        
    phpFiles = [os.path.join(dp, f) for dp, dn, filenames in os.walk(app_path) for f in filenames if os.path.splitext(f)[1] == '.php']
    
    
    for phpFile in phpFiles:
        print phpFile
        content = None
        with open(phpFile) as f:
            content = f.readlines()
    
        with open(phpFile, "wt") as fout:
            for line in content:
                if line[0:5] == '<?php':
                    fout.write(line.replace('<?php', php_instrumentation(proxy)))
                else:
                    fout.write(line)
