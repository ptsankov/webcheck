PACKET_FILE_EXTENSION = 'pcap'
HTTP_FILTER = 'tcp and port 80'
NET_IFACE = 'eth0'
W3AF = '/home/mguarnieri/testing/w3af/w3af/w3af_console'

def msg(msg):
    print "SCRIPT --> {}".format(msg)