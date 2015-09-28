#!/usr/bin/python

from scapy.all import *
from scapy.layers import http
import sys

assert len(sys.argv) == 3

pkts=rdpcap(sys.argv[1])

pkts_filtered = []

for pkt in pkts:
  if isinstance(pkt[Ether].payload, IP) and isinstance(pkt[IP].payload, TCP) and isinstance(pkt[TCP].payload, scapy.layers.http.HTTP):
    pkts_filtered.append(pkt)

wrpcap(sys.argv[2], pkts_filtered)
