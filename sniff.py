#!/usr/bin/python

from scapy.all import *
import sys

requests = sniff(iface="eth0", filter="tcp and port 80 and src 192.33.93.236", count=20000)
wrpcap(sys.argv[1], requests)
