#!/usr/bin/python
from scapy.utils import rdpcap
import sys
from scapy.layers.inet import IP, TCP, Ether
from utils import msg, PACKET_FILE_EXTENSION
import os
import glob
from scapy_http.http import HTTP, HTTPRequest
from os.path import commonprefix

def packet_filter(packet):
    return False
    if not isinstance(packet[Ether].payload, IP):
        return True
    if not isinstance(packet[IP].payload, TCP):
        return True
    if not isinstance(packet[TCP].payload, HTTP):
        return True
    if not isinstance(packet[HTTP].payload, HTTPRequest):
        return True
    return False

def read_packets(test_file):        
    packets = []    
    test_packets = rdpcap(test_file)
    for packet in test_packets:
        if not packet_filter(packet):
            packets.append(packet)                        
    return packets

def read_requests(test_file):
    requests = []
    with open(test_file) as f:
        content = f.readlines()
        for log_line in content:
            if log_line.startswith('POST') or log_line.startswith('GET'):
                requests.append(log_line) 
    return requests

if __name__ == "__main__":
    if len(sys.argv) != 2:
        msg('Usage: ' + sys.argv[0] + ' <folder with tests>')
        sys.exit(-1)
    
    tests_folder = sys.argv[1]
    assert os.path.isdir(tests_folder)
    os.chdir(tests_folder)
    
    tests = {}
    
    for test_file in glob.glob('*_http.txt'):
        tests[test_file] = read_requests(test_file)
                  
    
    for test in tests.keys():
        longest_prefix = 0
        for other_test in tests.keys():
            if test == other_test:
                continue
            prefix_length = len(commonprefix([tests[test], tests[other_test]]))
            if prefix_length > longest_prefix:
                longest_prefix = prefix_length
        print test, len(tests[test]), longest_prefix