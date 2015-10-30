#!/usr/bin/python

import sys
import shutil
from webcheck import runcmd
import random

PACKET_FILE_EXTENSION = 'pcap'
HTTP_FILTER = 'tcp and port 80'
NET_IFACE = 'eth0'
W3AF = '/home/mguarnieri/testing/w3af/w3af/w3af_console'

W3AF_HTTP_OUPUT = 'output-w3af-http.txt'
W3AF_LOG_OUPUT = 'output-w3af.txt'

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
    if len(sys.argv) != 3:
        print('Usage: ' + sys.argv[0] + ' <w3af script> <number of test cases>')
        sys.exit(-1)
    
    w3af_script = sys.argv[1]    
    try: 
        num_tests = int(sys.argv[2])
    except ValueError:
        print('Check your arguments')
        sys.exit(-1)
            
    for i in range(0, num_tests):
        test_id = random.randint(0,1000000)
        print('Generating test case {}'.format(test_id))
        
        print('Run w3af')        
        cmd = 'sudo {} --script={}'.format(W3AF, w3af_script)
        runcmd(cmd)
    
        print('Copy files')        
        shutil.copyfile(W3AF_HTTP_OUPUT, 'test{}_http.txt'.format(test_id))
        shutil.copyfile(W3AF_LOG_OUPUT, 'test{}_log.txt'.format(test_id))