#!/usr/bin/python

from threading import Thread
from scapy.all import *
import sys
import subprocess

filter_conf = "tcp and port 80"
interface = "eth0"
arachni = '/opt/arachni-1.2.1-0.5.7.1/bin/arachni'

def log_testcase(output_filename, num_packets):
  print 'Logging test case to', output_filename
  requests = sniff(iface=interface, filter=filter_conf, count=num_packets)
  wrpcap(output_filename, requests)

for i in range(0, 10):
  print 'Test case', i
  test_filename = "test_" + str(i)
  Thread(target = log_testcase, args = (test_filename, 100))
  
  cmd = arachni + " http://bellog.org/cuteflow/index.php --checks=* --plugin=autologin:url=http://bellog.org/cuteflow/index.php,parameters='UserId=admin&Password=admin',check='.' --scope-exclude-pattern logout"
  #cmd = "sleep 2" 
  print cmd
  process = subprocess.Popen(cmd.split(' '))
  output = process.communicate()
