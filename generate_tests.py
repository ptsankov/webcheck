#!/usr/bin/python

from scapy.utils import wrpcap
from scapy.sendrecv import sniff
import subprocess
import sys
import os
from threading import Thread

http_filter = 'tcp and port 80'
interface = 'eth0'
w3af = '/home/mguarnieri/testing/w3af/w3af/w3af_console'

def msg(msg):
    print "SCRIPT --> {}".format(msg)

def generate_test(output_filename, test_length):
    assert os.path.isfile(w3af_script)
    
    msg('Logging test to: ' + output_filename)
    requests = sniff(iface=interface, filter=http_filter, count=test_length)   
    wrpcap(output_filename, requests) 

if __name__ == "__main__":
    global w3af_script, num_tests, test_length
    if len(sys.argv) != 4:
        msg('Usage: ' + sys.argv[0] + ' <w3af script> <num_tests> <test case length>')
        sys.exit(-1)
    
    w3af_script = sys.argv[1]    
    try: 
        num_tests = int(sys.argv[2])
        test_length = int(sys.argv[3])
    except ValueError:
        msg('Check your arguments')
        sys.exit(-1)
            
    for i in range(0, num_tests):
        msg('Generating test case '  + str(i))
        test_filename = "test_" + str(i)
        cmd = '{} --script={}'.format(w3af, w3af_script)
        #cmd = "sleep 2"
        
        Thread(target=generate_test, args=(test_filename, test_length)).start()
        msg('Executing bash command: ' + cmd)        
        process = subprocess.Popen(cmd.split(' '))
        output = process.communicate()