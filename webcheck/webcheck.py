#!/usr/bin/python
import sys
import static
import ConfigParser
import glob
from os import path
import socket
import requests
import shlex
from subprocess import PIPE, Popen
from symbol import parameters
import random
import time

def output(line):
    print 'OUTPUT: {}'.format(line)
    output_file.write(line + '\n')

def parse_test_file(file):
    requests = []
    with open(file) as f:
        request = None
        for line in f.readlines():
            if line.startswith('GET http://') or line.startswith('POST http://'):
                if request is not None:
                    if request.startswith('GET'):
                        request = request.strip() + '\r\n\r\n'
                    requests.append(request)
                request = line.strip() + '\r\n'
            else:
                request += line.strip() + '\r\n'         
    return requests

def read_tests(path_to_tests):
    tests = []
    for test_file in glob.glob(path.join(path_to_tests, '*.http')):
        test = parse_test_file(test_file)
        tests.append(test)
    print 'read', len(tests), 'tests'
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
    global current_cookie
    start_time = time.time()
        
    cookies[label] = current_cookie        
    print 'Checkpointing cookie:', current_cookie, 'for label', label
    labels_to_files[label] = {}
    labels_to_files[label][randomSnapshotPath] = open(randomSnapshotPath, 'r').readlines()[0]
    labels_to_files[label][randomSeedPath] = open(randomSeedPath, 'r').readlines()[0]
    labels_to_files[label][timeSnapshotPath] = open(timeSnapshotPath, 'r').readlines()[0]
    labels_to_files[label][timeSeedPath] = open(timeSeedPath, 'r').readlines()[0]
    labels_to_files[label][sessionSnapshotPath] = open(sessionSnapshotPath, 'r').readlines()[0]
    
    labels_to_files[label][fileLogPath] = ''.join(open(fileLogPath, 'r').readlines())
    
    for f in open(fileLogPath, 'r').readlines():
        labels_to_files[label][f] = ''.join(open(f, 'r').readlines())
    
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect((proxy_ip, proxy_port))
    sock.sendall('checkpoint:{}'.format(label))
    print 'Checkpointing', label, sock.recv(2)        

    end_time = time.time()
    print 'Checkpoint time:', end_time - start_time    
    
def restore(label):
    global current_cookie
    start_time = time.time()
    current_cookie = cookies[label]
    print 'Restored cookie', current_cookie
    print 'restoring'
        
    for f in labels_to_files[label].keys():
        fd = open(f, 'w')
        fd.write(labels_to_files[label][f])
        fd.close()
    
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect((proxy_ip, proxy_port))
    sock.sendall('restore:{}'.format(label))
    print 'Restoring', label, sock.recv(2)

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

def execute_request(request, test_id, counter):
    global current_cookie    
    if request.startswith('GET'):
        (url, headers) = parse_request(request)
        if current_cookie is not None:
            headers['Cookie'] = current_cookie
        print 'GET', url
        print '\n'.join([str(k) + ':' + headers[k] for k in headers.keys()])
        print '\n'
        response = requests.get(url, headers=headers, allow_redirects=False)
        if 'set-cookie' in response.headers.keys():
            cookies = response.headers['set-cookie']
            current_cookie = '; '.join([cookie.split(';')[0] for cookie in cookies.split('\n')])
            print 'current_cookie', current_cookie            
        print response.status_code
    else:
        (url, headers) = parse_request(request.split('\r\n\r\n')[0])
        if current_cookie is not None:
            headers['Cookie'] = current_cookie            
        if (request.split('\r\n\r\n')) > 0:
            key_value_pairs = request.split('\r\n\r\n')[1].strip()
            parameters = key_value_pairs
        print 'POST', url
        print '\n'.join([str(k) + ':' + headers[k] for k in headers.keys()])
        print parameters
        print '\n'
        response = requests.post(url, headers=headers, data=parameters, allow_redirects=False)
        if 'set-cookie' in response.headers.keys():
            cookies = response.headers['set-cookie']
            current_cookie = '; '.join([cookie.split(';')[0] for cookie in cookies.split('\n')])
            print 'current_cookie', current_cookie        
        print response.status_code
    if log:
        out = open(response_log + '_' + str(test_id) + '_' + str(counter) + '.log', 'w')
        out.write('\n'.join([str(k) + ':' + response.headers[k] for k in response.headers.keys()]))
        out.write(response.content)
        out.close()
        cmd = 'mysqldump -u {} -p{} {} --result-file={}'.format(db_username, db_password, db_database, database_log + '_' + str(test_id) + '_' + str(counter) + '.sql')
        runcmd(cmd)

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
        print test[0]
        i += 1
        
        runcmd('mysql -u {} -p{} {}'.format(db_username, db_password, db_database), input='reset query cache; flush tables;')
        
        start_test = time.time()
        checkpoint_time = 0
        restore_time = 0
        http_time = 0
        counter = 1
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
                execute_request(request, i, counter)
                end_http = time.time()
                http_time += (end_http - start_http)
                counter = counter + 1
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
    global proxy_ip, proxy_port, db_host, db_username, db_password, db_database, number_of_result_tables, \
        output_file, response_log, database_log, log, cookies, current_cookie, \
        labels_to_files, sessionSnapshotPath, timestamp, fileLogPath, randomSnapshotPath, randomSeedPath, \
        timeSnapshotPath, timeSeedPath
        
        
    timestamp = str(random.randint(1,10000000000))
        
    
    if len(sys.argv) != 2:
        print 'Usage:', sys.argv[0], '<config file>'
        sys.exit(-1)
        
    
    cookies = {}
    cookies['init'] = None
    current_cookie = None
    
    labels_to_files = {}

    config_file = sys.argv[1]        
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    path_to_tests = config.get(static.TESTS_SECTION, 'PATH')
    
    fileLogPath = config.get(static.INSTRUMENTATION_SECTION, 'ACCESSED_FILES_LOG_PATH')
    
    randomSnapshotPath = config.get(static.INSTRUMENTATION_SECTION, 'RANDOM_SNAPSHOT_PATH')
    randomSeedPath = config.get(static.INSTRUMENTATION_SECTION, 'RANDOM_SEED_PATH')
    
    timeSnapshotPath = config.get(static.INSTRUMENTATION_SECTION, 'TIME_SNAPSHOT_PATH')  
    timeSeedPath = config.get(static.INSTRUMENTATION_SECTION, 'TIME_SEED_PATH')
    sessionSnapshotPath = config.get(static.INSTRUMENTATION_SECTION, 'RANDOM_SESSION_SNAPSHOT_PATH')
        
    output_filename = config.get(static.EXECUTION_SECTION, 'OUTPUT')
    response_log = config.get(static.EXECUTION_SECTION, 'RESPONSE_LOG')
    database_log = config.get(static.EXECUTION_SECTION, 'DATABASE_LOG')
    log = config.getboolean(static.EXECUTION_SECTION, 'LOG')    
    
    proxy_ip = config.get(static.PROXY_SECTION, 'IP')
    proxy_port = config.getint(static.PROXY_SECTION, 'PORT')
    
    db_host = config.get(static.DATABASE_SECTION, 'HOST')
    db_username = config.get(static.DATABASE_SECTION, 'USERNAME')
    db_password = config.get(static.DATABASE_SECTION, 'PASSWORD')
    db_database = config.get(static.DATABASE_SECTION, 'DATABASE')    
    
    output_file = open(output_filename, 'a')
    
    tests = read_tests(path_to_tests)
    
    measure_test_suites(tests)
    
    tests = transform_tests(tests)
    print 'Optimized tests size', sum([len(test) for test in tests])
    
    # set isolation level to read uncommitted (for proxy)
    runcmd('mysql -u {} -p{} {}'.format(db_username, db_password, db_database), input='set global transaction isolation level read uncommitted;')    

    checkpoint('start')            
    run_tests(tests)        
    restore('start')