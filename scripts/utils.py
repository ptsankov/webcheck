import shlex
from subprocess import PIPE, Popen
PACKET_FILE_EXTENSION = 'pcap'
HTTP_FILTER = 'tcp and port 80'
NET_IFACE = 'eth0'
W3AF = '/home/mguarnieri/testing/w3af/w3af/w3af_console'

W3AF_HTTP_OUPUT = 'output-w3af-http.txt'
W3AF_LOG_OUPUT = 'output-w3af.txt'


BAMBOO_DB_DUMP = '/home/ptsankov/webcheck/bamboo.sql'

def msg(msg):
    print "SCRIPT --> {}".format(msg)
    
def runcmd(cmd, cwd=None):
    msg("cmd: {}\n".format(cmd))
    args = shlex.split(cmd)
    p = Popen(args, stdout=PIPE, stderr=PIPE, cwd=cwd)
    out, err = p.communicate()
    if out:
        msg("cmd output: {}\n".format(out))
    else:
        msg("cmd output: {}\n".format(err))
    return out