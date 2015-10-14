#!/usr/bin/python

# Change log level to suppress annoying IPv6 error
import logging
logging.getLogger("scapy.runtime").setLevel(logging.ERROR)

# Import scapy
from scapy.all import *

# Print info header
print "[*] ACK-GET example -- Thijs 'Thice' Bosschert, 06-06-2011"

# Prepare GET statement
get='GET http://bellog.org/bamboo/index.php/login  HTTP/1.0\n\n'
get='GET http://bellog.org/index.php  HTTP/1.0\n\n'

# Set up target IP
ip=IP(dst="bellog.org")

# Generate random source port number
port=RandNum(1024,65535)

# Create SYN packet
SYN=ip/TCP(sport=port, dport=80, flags="S")

# Send SYN and receive SYN,ACK
print "\n[*] Sending SYN packet"
SYNACK=sr1(SYN)

# Create ACK with GET request

ACK=ip/TCP(sport=SYNACK.dport, dport=80, flags="A", seq=SYNACK[TCP].ack, ack=SYNACK[TCP].seq + 1) / get
ACK=sr1(ACK)
print ACK.show()
#PSHACK=ip/TCP(sport=ACK.dport, dport=80, flags="PA", seq=ACK[TCP].ack, ack=ACK[TCP].seq + 1) / get
#print "\n[*] Sending ACK-GET packet"
#reply,error=sr(PSHACK) # FIN/ACK can be discarded without big consequence, the server will close the connection anyway
#
## SEND our ACK-GET request
#print "\n[*] Sending ACK-GET packet"
##reply,error=sr(ACK)
#
## print reply from server
#print "\n[*] Reply from server:"
#print reply.show()
#
#print '\n[*] Done!'
