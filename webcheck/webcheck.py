#!/usr/bin/python
import sys
from static import TESTS_SECTION, EXECUTION_SECTION, APPLICATION_SECTION, PROXY_SECTION, DATABASE_SECTION, INSTRUMENTATION_SECTION
import ConfigParser
import glob
from os import path
import socket
import requests
import shlex
from subprocess import PIPE, Popen
#import MySQLdb
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
    if checkpointing:
        labels_to_files[label] = {}
        labels_to_files[label][randomSnapshotPath] = open(randomSnapshotPath, 'r').readlines()[0]
        labels_to_files[label][randomSeedPath] = open(randomSeedPath, 'r').readlines()[0]
        labels_to_files[label][timeSnapshotPath] = open(timeSnapshotPath, 'r').readlines()[0]
        labels_to_files[label][timeSeedPath] = open(timeSeedPath, 'r').readlines()[0]
        labels_to_files[label][sessionSnapshotPath] = open(sessionSnapshotPath, 'r').readlines()[0]
        
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((proxy_ip, proxy_port))
        sock.sendall('checkpoint:{}'.format(label))
        print 'Checkpointing', label, sock.recv(2)        
    elif vm:
        runcmd('VBoxManage snapshot webcheck take {} --live'.format(label + '_' + timestamp))
        runcmd('ssh guestserver.com cat /var/www/html/oscommerce/random_snapshot.txt')
        runcmd('ssh guestserver.com cat /var/www/html/oscommerce/time_snapshot.txt')
        print "Sleep for 5 seconds"
        time.sleep(5)
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
    global current_cookie
    start_time = time.time()
    current_cookie = cookies[label]
    print 'Restored cookie', current_cookie
    print 'restoring'
    
    
    if checkpointing:
        
        
        for f in labels_to_files[label].keys():
            fd = open(f, 'w')
            fd.write(labels_to_files[label][f])
            fd.close()
        
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((proxy_ip, proxy_port))
        sock.sendall('restore:{}'.format(label))
        print 'Restoring', label, sock.recv(2)
    elif vm:
        runcmd('VBoxManage controlvm webcheck poweroff')
        runcmd('VBoxManage snapshot webcheck restore {}'.format(label + '_' + timestamp))
        runcmd('VBoxManage startvm webcheck --type headless')
        print "Sleep for 30 seconds"
        time.sleep(30)
        runcmd('ssh guestserver.com cat /var/www/html/oscommerce/random_snapshot.txt')
        runcmd('ssh guestserver.com cat /var/www/html/oscommerce/time_snapshot.txt')
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
            #print 'reexecute the request'
            #execute_request(request, test_id, counter)             
        print response.status_code
    else:
        (url, headers) = parse_request(request.split('\r\n\r\n')[0])
        if current_cookie is not None:
            headers['Cookie'] = current_cookie            
        if (request.split('\r\n\r\n')) > 0:
            key_value_pairs = request.split('\r\n\r\n')[1].strip()
            #parameters = OrderedDict()
            parameters = key_value_pairs
            #for key_value in key_value_pairs.split('&'):
            #    key = key_value.split('=')[0]
            #    value = key_value.split('=')[1]
            #    parameters[key] = value
        print 'POST', url
        print '\n'.join([str(k) + ':' + headers[k] for k in headers.keys()])
        print parameters
        print '\n'
        response = requests.post(url, headers=headers, data=parameters, allow_redirects=False)
        if 'set-cookie' in response.headers.keys():
            cookies = response.headers['set-cookie']
            current_cookie = '; '.join([cookie.split(';')[0] for cookie in cookies.split('\n')])
            print 'current_cookie', current_cookie
            #print 'reexecute the request'
            #execute_request(request, test_id, counter)             
        print response.status_code
    if log:
        out = open(response_log + '_' + str(test_id) + '_' + str(counter) + '.log', 'w')
        out.write('\n'.join([str(k) + ':' + response.headers[k] for k in response.headers.keys()]))
        out.write(response.content)
        out.close()
        if vm:
            cmd = 'ssh {} mysqldump -u {} -p{} {} --result-file=/tmp/dump.sql'.format(db_host, db_username, db_password, db_database)
            runcmd(cmd)
            cmd = 'scp {}:/tmp/dump.sql {}'.format(db_host, database_log + '_' + str(test_id) + '_' + str(counter) + '.sql')
            runcmd(cmd)
        else:
            cmd = 'mysqldump -u {} -p{} {} --result-file={}'.format(db_username, db_password, db_database, database_log + '_' + str(test_id) + '_' + str(counter) + '.sql')
            runcmd(cmd)

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
    global remove_duplicates, test_length, filter_extensions, \
        checkpointing, application_ip, application_port, proxy_ip, proxy_port, \
        db_host, db_username, db_password, db_database, number_of_result_tables, \
        output_file, cookie, response_log, database_log, log, vm, cookies, current_cookie, \
        labels_to_files, sessionSnapshotPath, timestamp
        
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
    path_to_tests = config.get(TESTS_SECTION, 'PATH')
    remove_duplicates = config.getboolean(TESTS_SECTION, 'REMOVE_DUPLICATES')
    test_length = config.getint(TESTS_SECTION, 'TEST_LENGTH')
    filter_extensions  = config.get(TESTS_SECTION, 'FILTER_EXTENSIONS').split(',')
    cookie  = config.get(TESTS_SECTION, 'COOKIE')
    
    fileFlag = config.getboolean(INSTRUMENTATION_SECTION, 'FILE_INSTRUMENTATION')
    fileLogPath = config.get(INSTRUMENTATION_SECTION, 'ACCESSED_FILES_LOG_PATH')
    
    randomFlag = config.getboolean(INSTRUMENTATION_SECTION, 'RANDOM_INSTRUMENTATION')
    randomSnapshotPath = config.get(INSTRUMENTATION_SECTION, 'RANDOM_SNAPSHOT_PATH')
    randomSeedPath = config.get(INSTRUMENTATION_SECTION, 'RANDOM_SEED_PATH')
    
    timeFlag = config.getboolean(INSTRUMENTATION_SECTION, 'TIME_INSTRUMENTATION')
    timeSnapshotPath = config.get(INSTRUMENTATION_SECTION, 'TIME_SNAPSHOT_PATH')  
    timeSeedPath = config.get(INSTRUMENTATION_SECTION, 'TIME_SEED_PATH')
    sessionSnapshotPath = config.get(INSTRUMENTATION_SECTION, 'RANDOM_SESSION_SNAPSHOT_PATH')
        
    
    isolation = config.getboolean(EXECUTION_SECTION, 'ISOLATION')
    optimize_tests = config.getboolean(EXECUTION_SECTION, 'OPTIMIZE_TESTS')
    checkpointing = config.getboolean(EXECUTION_SECTION, 'CHECKPOINTING')
    vm = config.getboolean(EXECUTION_SECTION, 'VM')
    output_filename = config.get(EXECUTION_SECTION, 'OUTPUT')
    response_log = config.get(EXECUTION_SECTION, 'RESPONSE_LOG')
    database_log = config.get(EXECUTION_SECTION, 'DATABASE_LOG')
    log = config.getboolean(EXECUTION_SECTION, 'LOG')    
    
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
    if vm:
        runcmd('VBoxManage startvm webcheck --type headless')
        print "Sleep for 30 seconds"
        time.sleep(30)
    if checkpointing:
        # set isolation level to read uncommitted (for proxy)
        runcmd('mysql -u {} -p{} {}'.format(db_username, db_password, db_database), input='set global transaction isolation level read uncommitted;')    

    if checkpoint:
        checkpoint('start')
            
    run_tests(tests)
        
    if checkpoint:
        restore('start')
    if vm:
        restore('init')
        runcmd('VBoxManage controlvm webcheck poweroff')
        
    
    if vm:
        cmd = 'VBoxManage snapshot webcheck list | grep -v "init" | awk -F \' \' \'{print $4}\' | sed \'s/)//\' | tac | while read id; do echo $id; VBoxManage snapshot webcheck delete $id; done;'
        runcmd(cmd)