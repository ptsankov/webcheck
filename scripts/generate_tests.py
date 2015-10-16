#!/usr/bin/python

import sys
from utils import msg, W3AF_HTTP_OUPUT, W3AF_LOG_OUPUT, runcmd, BAMBOO_DB_DUMP,\
    W3AF
import shutil

'''
def generate_test(output_filename, test_length):
    assert os.path.isfile(w3af_script)
    if os.path.isfile(output_filename):
        msg('The output file {} exists, remove it.'.format(output_filename))
        sys.exit(-1)
    msg('Logging test to: {}'.format(output_filename))
    msg('Test case length: {} {} {}'.format(test_length, NET_IFACE, HTTP_FILTER))
    requests = sniff(iface=NET_IFACE, filter=HTTP_FILTER, count=test_length)   
    msg('Done sniffing')
    wrpcap(output_filename, requests)
''' 

if __name__ == "__main__":
    global w3af_script, num_tests, test_length
    if len(sys.argv) != 4:
        msg('Usage: ' + sys.argv[0] + ' <w3af script> <number of test cases> <test case length>')
        sys.exit(-1)
    
    w3af_script = sys.argv[1]    
    try: 
        num_tests = int(sys.argv[2])
        test_length = int(sys.argv[3])
    except ValueError:
        msg('Check your arguments')
        sys.exit(-1)
            
    for i in range(0, num_tests):
        msg('Generating test case {}'.format(i))
        
        #msg('Reset the database')
        #cmd = 'mysql -u root -pasdLweMC0 bambooinvoice < {}'.format(BAMBOO_DB_DUMP)
        #runcmd(cmd)
        
        msg('Run w3af')        
        cmd = 'sudo {} --script={}'.format(W3AF, w3af_script)
        runcmd(cmd)
        
        
        #test_filename = 'test{}.{}'.format(i, PACKET_FILE_EXTENSION)
        #Thread(target=generate_test, args=(test_filename, test_length)).start()
        msg('Copy files')        
        shutil.copyfile(W3AF_HTTP_OUPUT, 'test{}_http.txt'.format(i))
        shutil.copyfile(W3AF_LOG_OUPUT, 'test{}_log.txt'.format(i))
