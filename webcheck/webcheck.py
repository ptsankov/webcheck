#!/usr/bin/python
import sys
from static import TESTS_SECTION, EXECUTION_SECTION, APPLICATION_SECTION
import ConfigParser
import glob
from os import path
from scipy.weave.ast_tools import remove_duplicates
import socket

def parse_test_file(file):
    requests = []
    with open(file) as f:
        content = f.readlines()
        request = None
        in_request = False
        for line in content:
            if line.startswith('========================================Response'):
                in_request = False    
                if request.startswith('GET'):
                    request = request[:-12] + '\\r\\n\\r\\n'
                print request
                requests.append(request)
            if in_request:
                request += line.strip() + '\\r\\n'
            if line.startswith('========================================Request'):
                in_request = True
                request = ''            
                  
    return requests

def white_list(log_file):
    list = []    
    with open(log_file) as f:
        content = f.readlines()
        read = False
        for log_line in content:
            log_line = log_line.strip()
            if 'The following is a list of broken links that were found' in log_line:
                read = True
            elif 'The list of fuzzable requests is' in log_line:
                read = False
            elif 'information' not in log_line:
                continue
            elif 'different injections points' in log_line:
                continue
            elif 'The URL list is' in log_line:
                read = True
                continue
            elif read:
                request = log_line.split('] - ')[1].split(' ')[0]
                list.append(request)
            else:
                pass
    return list

def filter_test(test, filter_extensions, remove_dupicates, allowed_urls):
    filtered_requests = []
    for request in test:
        url = request.split(' ')[1]
        if url.split('.')[-1] in filter_extensions:
            continue
        if remove_duplicates and request in filtered_requests:
            continue
        if url not in allowed_urls:
            continue
        filtered_requests.append(request)
    return filtered_requests

def read_tests(path_to_tests):
    tests = []
    for test_file in glob.glob(path.join(path_to_tests, '*_http.txt')):
        print test_file        
        test = parse_test_file(test_file)
        allowed_urls = white_list(test_file.replace('http', 'log')) 
        filtered_test = filter_test(test, filter_extensions, remove_dupicates, allowed_urls)[:test_length]
        tests.append(filtered_test)
    return tests
        
        
def make_trie(tests):
    trie = {}
    for test in tests:
        cur_node = trie
        for request in test:
            if request not in cur_node.keys():
                cur_node[request] = {}
            cur_node = cur_node[request]
    return trie


def checkpoint(label):
    print 'checkpoint', label
    
def restore(label):
    print 'restore', label

def execute_request(request):
    sock = socket.socket()
    sock.connect((application_ip, application_port))
    sock.send(request)
    print sock.recv(100)

def transform_tests(tests):
    trie = make_trie(tests)
    T = []    
    S = [(trie, [])]
    c = 0
    while len(S) != 0:
        (n, t) = S.pop()
        O = n.keys()
        if len(O) > 1:
            q = O[0]
            c += 1
            t.append('checkpoint:l{}'.format(c))
            t.append(q)
            S.append((n[q], t))
            for q1 in O:
                if q1 == q:
                    continue
                S.append( (n[q1], ['restore:l{}'.format(c), q1]) )
        elif len(O) == 1:
            q = O[0]
            t.append(q)
            S.append((n[q], t))
        else:
            T = [t] + T
            
    return T

def isolate_tests(tests):
    return [ ['checkpoint:init'] + tests[0]] + [ ['restore:init'] + t for t in tests[1:] ]

def run_tests(tests):
    for test in tests:
        for request in test:
            if request.startswith('checkpoint'):
                label = request.split(':')[1]
                checkpoint(label)
            elif request.startswith('restore'):
                label = request.split(':')[1]
                restore(label)
            else:
                execute_request(request)

if __name__ == "__main__":
    global remove_dupicates, test_length, filter_extensions, checkpointing, application_ip, application_port  
    
    if len(sys.argv) != 2:
        print 'Usage:', sys.argv[0], '<config file>'
        sys.exit(-1)
        
        
    config_file = sys.argv[1]        
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    path_to_tests = config.get(TESTS_SECTION, 'PATH')
    remove_dupicates = config.getboolean(TESTS_SECTION, 'REMOVE_DUPLICATES')
    test_length = config.getint(TESTS_SECTION, 'TEST_LENGTH')
    filter_extensions  = config.get(TESTS_SECTION, 'FILTER_EXTENSIONS').split(',')
    
    isolation = config.getboolean(EXECUTION_SECTION, 'ISOLATION')
    optimize_tests = config.getboolean(EXECUTION_SECTION, 'OPTIMIZE_TESTS')
    checkpointing = config.getboolean(EXECUTION_SECTION, 'CHECKPOINTING')
    
    application_ip = config.get(APPLICATION_SECTION, 'IP')
    application_port = config.getint(APPLICATION_SECTION, 'PORT')
    
    tests = read_tests(path_to_tests)
    #tests = [['a', 'b', 'c', 'd'], ['a', 'b', 'c', 'e'], ['a', 'f'] ]
    
    if isolation:
        if optimize_tests:
            tests = transform_tests(tests)
        else:
            tests = isolate_tests(tests)
    run_tests(tests)   
    #trie = make_trie(tests)
