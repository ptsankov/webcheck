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
import MySQLdb
import time

def output(line):
    print 'OUTPUT: {}'.format(line)
    output_file.write(line + '\n')

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
            if in_request and not line.startswith('Cookie'):
                request += line.strip() + '\r\n'
            if in_request and line.startswith('Cookie'):
                request += 'Cookie: {}\r\n'.format(cookie)
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
        #if url.split('.')[-1] in filter_extensions:
        if True in [x in url for x in filter_extensions]:
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

def runcmd(cmd, input=PIPE, output=PIPE, cwd=None):
    print cmd, input
    args = shlex.split(cmd)
    p = Popen(args, stdin=PIPE, stdout=output, stderr=PIPE, cwd=cwd)
    if input != PIPE:
        p.stdin.write(input + '\n')
    out, err = p.communicate()
    return out

def checkpoint(label):
    start_time = time.time()
    if checkpointing:
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((proxy_ip, proxy_port))
        sock.sendall('checkpoint:{}'.format(label))
        print 'Checkpointing', label, sock.recv(2)
    else:
        dump_file = 'checkpoint_{}'.format(label)
        #runcmd('mysqldump -u {} -p{} {} {}'.format(db_username, db_password, db_database, ' '.join(table_names)), output=open(dump_file, 'w'))
        runcmd('mysqldump -u {} -p{} {}'.format(db_username, db_password, db_database), output=open(dump_file, 'w'))
    end_time = time.time()
    print 'Checkpoint time:', end_time - start_time    

'''        
def get_table_names():
    db_connection = MySQLdb.connect(host=db_host, user=db_username, passwd=db_password, db=db_database)
    cursor = db_connection.cursor()    
    
    query_table_names = 'show tables like "{}%"'.format(db_tables_prefix)    
    cursor.execute(query_table_names)
    table_names_result = cursor.fetchall()
    table_names = [x[0] for x in table_names_result]
    return table_names
'''

    
def restore(label):
    start_time = time.time()
    print 'restoring'
    if checkpointing:
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((proxy_ip, proxy_port))
        sock.sendall('restore:{}'.format(label))
        print 'Restoring', label, sock.recv(2)
    else:
        dump_file = 'checkpoint_{}'.format(label)
        runcmd('mysql -u {} -p{} {}'.format(db_username, db_password, db_database, dump_file), input='source {}'.format(dump_file))
    print 'done restoring'
    end_time = time.time()
    print 'Restore time:', end_time - start_time

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
        print response.status_code
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
        print response.status_code
#    sock = socket.socket()
#    sock.connect((application_ip, application_port))    
#    sock.send(request)    
#    sock.recv(4096)


def num_edges(trie):
    if len(trie.keys()) == 0:
        return 0
    N = 0
    for child in trie.keys():
        N += 1 + num_edges(trie[child])
    return N

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
    i = 1
    for test in tests:
        print ('Test {} out of {}'.format(i, len(tests)))
        i += 1
        
        runcmd('mysql -u {} -p{} {}'.format(db_username, db_password, db_database), input='reset query cache; flush tables;')
        
        start_test = time.time()
        checkpoint_time = 0
        restore_time = 0
        http_time = 0
        for request in test:
            if request.startswith('checkpoint'):
                label = request.split(':')[1]
                start_checkpoint = time.time()
                checkpoint(label)
                end_checkpoint = time.time()
                checkpoint_time += (end_checkpoint - start_checkpoint)
            elif request.startswith('restore'):
                label = request.split(':')[1]
                start_restore = time.time()
                restore(label)
                end_restore = time.time()
                restore_time += (end_restore - start_restore)
            else:
                start_http = time.time()
                execute_request(request)
                end_http = time.time()
                http_time += (end_http - start_http)
        end_test = time.time()
        test_time = end_test - start_test
        output('time:{},checkpoint:{},restore:{},http:{}'.format(test_time, checkpoint_time, restore_time, http_time))

def print_tests(tests):
    i = 1
    for test in tests:
        print 'Test', i
        for request in test:
            print request
        print '------------------------------------'

def measure_test_suites(tests):
    optimized_tests = transform_tests(tests)
    
    print 'Test suite size', sum([len(test) for test in tests])
    output('Test suite size' + str(sum([len(test) for test in tests])))
    print 'Optimized test suite size', sum([len([q for q in test if not (q.startswith('checkpoint') or q.startswith('restore'))]) for test in optimized_tests])
    output('Optimized test suite size' + str(sum([len([q for q in test if not (q.startswith('checkpoint') or q.startswith('restore'))]) for test in optimized_tests])))
    print 'Number of checkpoints', sum([len([q for q in test if q.startswith('checkpoint')]) for test in optimized_tests])
    output('Number of checkpoints' + str(sum([len([q for q in test if q.startswith('checkpoint')]) for test in optimized_tests])))

if __name__ == "__main__":
    global remove_duplicates, test_length, filter_extensions, \
        checkpointing, application_ip, application_port, proxy_ip, proxy_port, \
        db_host, db_username, db_password, db_database, number_of_result_tables, \
        output_file, cookie
        
    
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
    cookie  = config.get(TESTS_SECTION, 'COOKIE')
    
    isolation = config.getboolean(EXECUTION_SECTION, 'ISOLATION')
    optimize_tests = config.getboolean(EXECUTION_SECTION, 'OPTIMIZE_TESTS')
    checkpointing = config.getboolean(EXECUTION_SECTION, 'CHECKPOINTING')
    output_filename = config.get(EXECUTION_SECTION, 'OUTPUT')    
    
    application_ip = config.get(APPLICATION_SECTION, 'IP')
    application_port = config.getint(APPLICATION_SECTION, 'PORT')
    
    proxy_ip = config.get(PROXY_SECTION, 'IP')
    proxy_port = config.getint(PROXY_SECTION, 'PORT')
    
    db_host = config.get(DATABASE_SECTION, 'HOST')
    db_username = config.get(DATABASE_SECTION, 'USERNAME')
    db_password = config.get(DATABASE_SECTION, 'PASSWORD')
    db_database = config.get(DATABASE_SECTION, 'DATABASE')    
#    db_tables_prefix = config.get(DATABASE_SECTION, 'TABLES_PREFIX')
    
    #table_names = get_table_names()
    output_file = open(output_filename, 'a')
    

    tests = read_tests(path_to_tests)
    #tests = [['a', 'b', 'c', 'd'], ['a', 'b', 'c', 'e'], ['a', 'f'] ]

    measure_test_suites(tests)
    
    if isolation:
        if optimize_tests:
            tests = transform_tests(tests)
            print 'Optimized tests size', sum([len(test) for test in tests])
        else:            
            tests = isolate_tests(tests)
            print 'Isolated tests size', sum([len(test) for test in tests])
    
    run_tests(tests)   
    