#!/usr/bin/python

from scapy.utils import wrpcap
from scapy.sendrecv import sniff
import subprocess
import sys
import os
from threading import Thread
from utils import msg, NET_IFACE, HTTP_FILTER, W3AF, PACKET_FILE_EXTENSION


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
        test_filename = 'test{}.{}'.format(i, PACKET_FILE_EXTENSION)
        cmd = 'sudo {} --script={}'.format(W3AF, w3af_script)
        #cmd = "sleep 2"
        
        Thread(target=generate_test, args=(test_filename, test_length)).start()
        msg('Executing bash command: ' + cmd)        
        process = subprocess.Popen(cmd.split(' '))
        output = process.communicate()
