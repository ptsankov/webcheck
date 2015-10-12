#!/usr/bin/python
from scapy.utils import rdpcap, wrpcap
import sys
import scapy.layers
from scapy_http import http
from scapy.layers.inet import IP, TCP, Ether
from utils import msg, PACKET_FILE_EXTENSION
import os
import glob
from scapy_http.http import HTTP, HTTPRequest

def packet_filter(packet):
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

if __name__ == "__main__":
    if len(sys.argv) != 2:
        msg('Usage: ' + sys.argv[0] + ' <folder with tests>')
        sys.exit(-1)
    
    tests_folder = sys.argv[1]
    assert os.path.isdir(tests_folder)
    os.chdir(tests_folder)
    
    tests = {}
    
    for test_file in glob.glob('*.{}'.format(PACKET_FILE_EXTENSION)):
        tests[test_file] = read_packets(test_file)
                  
    
    for test in tests.keys():
        print test
        for packet in tests[test]:
            packet.show()