#!/usr/bin/python
import sys
from static import TESTS_SECTION, EXECUTION_SECTION, APPLICATION_SECTION, PROXY_SECTION, DATABASE_SECTION
import ConfigParser
import glob
from os import path
import socket
import requests
import shlex
from subprocess import PIPE, Popen

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
                    request = request.strip() + '\r\n\r\n'
                requests.append(request)
            if in_request:
                request += line.strip() + '\r\n'
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

def filter_test(test, filter_extensions, allowed_urls):
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
        filtered_test = filter_test(test, filter_extensions, allowed_urls)[:test_length]
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

def runcmd(cmd, cwd=None):
    args = shlex.split(cmd)
    p = Popen(args, stdout=PIPE, stderr=PIPE, cwd=cwd)
    out, err = p.communicate()
    if out:
        print out
    else:
        print err
    return out

def checkpoint(label):
    if checkpointing:
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((proxy_ip, proxy_port))
        sock.sendall('checkpoint:{}'.format(label))
        print 'Checkpointing', label, sock.recv(2)
    else:
        dump_file = 'checkpoint_{}'.format(label)
        runcmd('mysqldump -u {} -p{} {} > {}'.format(db_username, db_password, db_database, dump_file))
        
    
def restore(label):
    if checkpointing:
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((proxy_ip, proxy_port))
        sock.sendall('restore:{}'.format(label))
        print 'Restoring', label, sock.recv(2)
    else:
        dump_file = 'checkpoint_{}'.format(label)
        runcmd('mysql -u {} -p{} {} < {}'.format(db_username, db_password, db_database, dump_file))

def parse_request(request):
    url = request.split('\r\n')[0].split(' ')[1]
    key_value_pairs = request.split('\r\n')[1:-2]
    headers = {}
    for key_value in key_value_pairs:
        key = key_value.split(': ')[0]
        value = key_value.split(': ')[1]
        headers[key] = value
    return (url, headers)

def execute_request(request):
    print request
    if request.startswith('GET'):
        (url, headers) = parse_request(request)
        response = requests.get(url, headers=headers)
        print response
        print response.text
    else:
        (url, headers) = parse_request(request.split('\r\n\r\n')[0])
        if (request.split('\r\n\r\n')) > 0:
            key_value_pairs = request.split('\r\n\r\n')[1].strip()
            parameters = {}
            for key_value in key_value_pairs.split('&'):
                key = key_value.split('=')[0]
                value = key_value.split('=')[1]
                parameters[key] = value
        response = requests.post(url, headers=headers, data=parameters)
        print response
        print response.text
#    sock = socket.socket()
#    sock.connect((application_ip, application_port))    
#    sock.send(request)    
#    sock.recv(4096)

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
    global remove_duplicates, test_length, filter_extensions, \
        checkpointing, application_ip, application_port, proxy_ip, proxy_port, \
        db_username, db_password, db_database
    
    if len(sys.argv) != 2:
        print 'Usage:', sys.argv[0], '<config file>'
        sys.exit(-1)
        
        
    config_file = sys.argv[1]        
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    path_to_tests = config.get(TESTS_SECTION, 'PATH')
    remove_duplicates = config.getboolean(TESTS_SECTION, 'REMOVE_DUPLICATES')
    test_length = config.getint(TESTS_SECTION, 'TEST_LENGTH')
    filter_extensions  = config.get(TESTS_SECTION, 'FILTER_EXTENSIONS').split(',')
    
    isolation = config.getboolean(EXECUTION_SECTION, 'ISOLATION')
    optimize_tests = config.getboolean(EXECUTION_SECTION, 'OPTIMIZE_TESTS')
    checkpointing = config.getboolean(EXECUTION_SECTION, 'CHECKPOINTING')
    
    application_ip = config.get(APPLICATION_SECTION, 'IP')
    application_port = config.getint(APPLICATION_SECTION, 'PORT')
    
    proxy_ip = config.get(PROXY_SECTION, 'IP')
    proxy_port = config.getint(PROXY_SECTION, 'PORT')
    
    db_username = config.get(DATABASE_SECTION, 'USERNAME')
    db_password = config.get(DATABASE_SECTION, 'PASSWORD')
    db_database = config.get(DATABASE_SECTION, 'DATABASE')
    
    tests = read_tests(path_to_tests)
    #tests = [['a', 'b', 'c', 'd'], ['a', 'b', 'c', 'e'], ['a', 'f'] ]
    
    if isolation:
        if optimize_tests:
            tests = transform_tests(tests)
        else:
            tests = isolate_tests(tests)
    run_tests(tests)   
    #trie = make_trie(tests)
