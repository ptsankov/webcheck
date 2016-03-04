#!/usr/bin/python
import os
import sys
import ConfigParser
from static import INSTRUMENTATION_SECTION, PROXY_SECTION


def php_instrumentation():
    sql_instrumentation = instrument_sql_api()
    file_instrumentation = instrument_file_api()     
    random_instrumentation = instrument_random_api()
    time_instrumentation = instrument_time_api()
    return sql_instrumentation + file_instrumentation + random_instrumentation + time_instrumentation
  
  
def instrument_file_api():  
    return '''              
            if (!function_exists('fopen_old')) {
              runkit_function_copy ( 'fopen', 'fopen_old' );
              
              runkit_function_redefine('fopen', '$filename , $mode , $use_include_path = false', '// Modified fopen()                            
		  $log = fopen_old ("''' + fileLogPath + '''", "a");
		  fwrite($log, $filename . "\\r\\n");
		  fclose($log);
		  $result = fopen_old ($filename, $mode, $use_include_path);
		  return $result;
                '); 
            }            
            // -------------
            '''  
  
  
def instrument_random_api():  
    return '''              
            if (!function_exists('rand_old')) {
              runkit_function_copy ( 'rand', 'rand_old' );
              
              runkit_function_redefine('rand', '$min = 0, $max = 0', '// Modified rand()
		  // read seed
		  $seedFile = fopen_old("''' + randomSeedPath + '''", "r");
		  $seed = (int) fgets($seedFile);
		  fclose($seedFile);
		  // read currentValue
		  $currentValPath = fopen_old("''' + randomSnapshotPath + '''", "r");
		  $currentVal= (int) fgets($currentValPath);
		  fclose($currentValPath);
		  // compute new value
		  $newRandomVal =(($seed + 2) * $currentVal + ($seed+1)) % ($seed + 3);
		  // update currentValue
		  $currentValPath = fopen_old("''' + randomSnapshotPath + '''", "w");
		  fwrite($currentValPath, $newRandomVal);
		  fclose($currentValPath);
		  if($min == 0 && $max == 0)
		  {
		    return $newRandomVal;
		  }
		  else {
		    return $newRandomVal % $max;
		  }
                '); 
            }            
            // -------------
            if (!function_exists('mt_rand_old')) {
              runkit_function_copy ( 'mt_rand', 'mt_rand_old' );
              
              runkit_function_redefine('mt_rand', '$min = 0, $max = 0', '// Modified mt_rand()
		  return rand($min, $max);
                '); 
            }             
            // -------------
            if (!function_exists('uniqid_old')) {
              runkit_function_copy ( 'uniqid', 'uniqid_old' );
              
              runkit_function_redefine('uniqid', '$prefix = "", $more_entropy = false', '// Modified uniqid()
		  return  $prefix."AAAA";
                '); 
            }            
            // ------------- 
            if (!function_exists('session_id_old')) {
              runkit_function_copy ( 'session_id', 'session_id_old' );
              
              runkit_function_redefine('session_id', '$id = ""', '// Modified session_id()              
		  // read currentValue
		  $sessionValuePath = fopen_old("''' + sessionSnapshotPath + '''", "r");
		  $session_id= (int) fgets($sessionValuePath);
		  fclose($sessionValuePath);
		  if ($id != "")
                        session_id_old($id);
		  return md5($session_id);
                '); 
            }            
            // ------------- 
	    if (!function_exists('session_regenerate_id_old')) {
              runkit_function_copy ( 'session_regenerate_id', 'session_regenerate_id_old' );
              
              runkit_function_redefine('session_regenerate_id', '$delete_old_session = false', '// Modified session_regenerate_id()              
		  // read currentValue
		  $sessionValuePath = fopen_old("''' + sessionSnapshotPath + '''", "r");
		  $session_id= (int) fgets($sessionValuePath);
		  fclose($sessionValuePath);
		  // compute new value
		  $new_session_id = $session_id+1;
		  // delete old value if needed
          session_regenerate_id_old($delete_old_session);
          // set new value in the cookie
          session_id_old($new_session_id);
		  // update currentValue
		  $sessionValuePath = fopen_old("''' + sessionSnapshotPath + '''", "w");
		  fwrite($sessionValuePath, $new_session_id);
		  fclose($sessionValuePath);
		  return  true;
                '); 
            }            
            // -------------  
            if (!function_exists('session_start_old')) {
              runkit_function_copy ( 'session_start', 'session_start_old' );

              runkit_function_redefine('session_start', ' $options = [] ', '// Modified session_start()              
                  $newId = session_id(); // get new link_identifier
                  session_id_old($newId); // set new identifier before the start
                  session_start_old($options); // actually start the session         
                ');
            }
            // ------------- 
            '''  
    
def instrument_time_api():  
    return '''              
            if (!function_exists('time_old')) {
              runkit_function_copy ( 'time', 'time_old' );
              
              runkit_function_redefine('time', '', '// Modified time()
		  // read seed
		  $seedFile = fopen_old("''' + timeSeedPath + '''", "r");
		  $seed = (int) fgets($seedFile);
		  fclose($seedFile);
		  // read counter
		  $counterFile = fopen_old("''' + timeSnapshotPath + '''", "r");
		  $counter= (int) fgets($counterFile);
		  fclose($counterFile);
		  // update counter
		  $counterFile = fopen_old("''' + timeSnapshotPath + '''", "w");
		  fwrite($counterFile, $counter+1);  
		  fclose($counterFile);
		  $result = $seed + $counter;
		  return $result;
                '); 
            }            
            // -------------
            if (!function_exists('microtime_old')) {
              runkit_function_copy ( 'microtime', 'microtime_old' );
              
              runkit_function_redefine('microtime', '$get_as_float = false', '// Modified microtime()
		  // read seed
		  $seedFile = fopen_old("''' + timeSeedPath + '''", "r");
		  $seed = (int) fgets($seedFile);
		  fclose($seedFile);
		  // read counter
		  $counterFile = fopen_old("''' + timeSnapshotPath + '''", "r");
		  $counter= (int) fgets($counterFile);
		  fclose($counterFile);
		  // update counter
		  $counterFile = fopen_old("''' + timeSnapshotPath + '''", "w");
		  fwrite($counterFile, $counter+1);  
		  fclose($counterFile);
		  if ($get_as_float) {
		    $result = (float) $seed + $counter;
		  }
		  else {
		    $result = strval($seed) . " " . strval($counter);
		  }
		  return $result;
                '); 
            }
            // -------------
            ''' 
    
  
def instrument_sql_api(): 
    return '''              
            if (!function_exists('mysql_query_old')) {
              runkit_function_copy ( 'mysql_query', 'mysql_query_old' );
              
              runkit_function_redefine('mysql_query', '$query , $link_identifier=null', '// Modified mysql_query()                
                if (stripos($query, "UPDATE") === 0 || stripos($query, "INSERT") === 0 || stripos($query, "DELETE") === 0) {
                    print("an update query");
                 //--------------- Connect to proxy ----------------
                 $client = stream_socket_client("tcp://''' + proxy + '''", $errno, $errorMessage);
                 if ($client === false) {
                  throw new UnexpectedValueException("Failed to connect: $errorMessage");
                 }
                 fwrite($client, $query);
                 // Get response from proxy.
                 $response = stream_get_contents($client);
                  if ($response == "true") {
                      $result = TRUE;
                  } else {
                      $result = FALSE;
                  }
                 // Close connection to proxy.
                 fclose($client);
                } else {
                  $result = mysql_query_old ($query);
                }
                 return $result;
                '); 
            }            
            // -------------
            if (!function_exists('mysqli_query_old')) {
              runkit_function_copy ( 'mysqli_query', 'mysqli_query_old' );
              
              runkit_function_redefine('mysqli_query', ' $link_identifier, $query', '// Modified mysql_query()                
                if (stripos($query, "UPDATE") === 0 || stripos($query, "INSERT") === 0 || stripos($query, "DELETE") === 0) {
                    print("an update query");
                 //--------------- Connect to proxy ----------------
                 $client = stream_socket_client("tcp://''' + proxy + '''", $errno, $errorMessage);
                 if ($client === false) {
                  throw new UnexpectedValueException("Failed to connect: $errorMessage");
                 }
                 fwrite($client, $query);
                 // Get response from proxy.
                 $response = stream_get_contents($client);
                  if ($response == "true") {
                      $result = TRUE;
                  } else {
                      $result = FALSE;
                  }
                 // Close connection to proxy.
                 fclose($client);
                } else {
                  $result = mysqli_query_old ($link_identifier, $query);
                }
                 return $result;
                '); 
            }            
            // -------------
            '''


if __name__ == "__main__":
  
    global proxy, fileLogPath, randomSnapshotPath, timeSnapshotPath, randomSeedPath, timeSeedPath, sessionSnapshotPath
    
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
    
    fileLogPath = config.get(INSTRUMENTATION_SECTION, 'ACCESSED_FILES_LOG_PATH')
    
    randomSnapshotPath = config.get(INSTRUMENTATION_SECTION, 'RANDOM_SNAPSHOT_PATH')
    randomSeedPath = config.get(INSTRUMENTATION_SECTION, 'RANDOM_SEED_PATH')
    sessionSnapshotPath = config.get(INSTRUMENTATION_SECTION, 'RANDOM_SESSION_SNAPSHOT_PATH')
    
    timeSnapshotPath = config.get(INSTRUMENTATION_SECTION, 'TIME_SNAPSHOT_PATH')  
    timeSeedPath = config.get(INSTRUMENTATION_SECTION, 'TIME_SEED_PATH')
        
    phpFiles = [os.path.join(dp, f) for dp, dn, filenames in os.walk(app_path) for f in filenames if os.path.splitext(f)[1] == '.php']
    
  
    for phpFile in phpFiles:
        print phpFile
        content = None
        with open(phpFile) as f:
            content = f.readlines()
    
        has_namespace = True in [line.startswith('namespace') for line in content]
        with open(phpFile, "wt") as fout:
            instrumented = False
            for line in content:
                if not instrumented and (not has_namespace) and line.strip().startswith('<?php'):
                    fout.write(line.replace('<?php', '<?php\n' + php_instrumentation()))
                    instrumented = True
                elif not instrumented and has_namespace and line.strip().startswith('namespace'):
                    fout.write(line)
                    fout.write(php_instrumentation())
                    instrumented = True
                else:
                    fout.write(line)
