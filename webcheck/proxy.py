#!/usr/bin/python

import MySQLdb
import sys
import ConfigParser
import socket
from static import PROXY_SECTION, DATABASE_SECTION
import hashlib

def log(m):
    if debug:
        print 'PROXY:', m

if __name__ == '__main__':
    
    global debug    
    
    if len(sys.argv) != 2:
        print ('Usage: ' + sys.argv[0] + ' <config file>')
        sys.exit(-1)
    
    # Program Section
    config_file = sys.argv[1]        
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    db_host = config.get(DATABASE_SECTION, 'HOST')
    db_username = config.get(DATABASE_SECTION, 'USERNAME')
    db_password = config.get(DATABASE_SECTION, 'PASSWORD')
    db_database = config.get(DATABASE_SECTION, 'DATABASE')
        
    proxy_ip = config.get(PROXY_SECTION, 'IP')
    proxy_port = config.getint(PROXY_SECTION, 'PORT')
    proxy_max_connections = config.getint(PROXY_SECTION, 'MAX_CONNECTIONS')
#    proxy_max_result_tables = config.getint(PROXY_SECTION, 'MAX_RESULT_TABLES')
#    result_tables_prefix = config.get(PROXY_SECTION, 'RESULT_TABLES_PREFIX')    

    debug = config.getboolean(PROXY_SECTION, 'DEBUG')
    
    create_table_command_cache = {}
    
    
    # --------------------------
    #   Setup Listening Socket
    # --------------------------
    listening_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)        
    listening_socket.bind((proxy_ip, proxy_port))
    listening_socket.listen(proxy_max_connections)    
    
    try:

    
        # ------------------------------
        #   Setup Database Connections
        # ------------------------------
        db_connection_tr = MySQLdb.connect(host=db_host, user=db_username, passwd=db_password, db=db_database)
        db_connection = MySQLdb.connect(host=db_host, user=db_username, passwd=db_password, db=db_database)
        cursor_tr = db_connection_tr.cursor()
        cursor = db_connection.cursor()
        
        # --------------------------
        #   Start transaction
        # --------------------------
        query = 'start transaction'
        print query
        cursor_tr.execute(query)            
        
            
        '''
        result_tables_query = 'show tables like "{}%"'.format(result_tables_prefix)
        log(result_tables_query)
        cursor.execute(result_tables_query)
        result_table_names_query = cursor.fetchall()        
        result_table_names = [x[0] for x in result_table_names_query]
        for result_table in result_table_names:
            drop_table_query = 'drop table {}'.format(result_table)
            log(drop_table_query)
            log(drop_table_query)
            cursor.execute(drop_table_query)
        
        result_counter = 0
        '''
    
        # -------
        #  LOOP
        # -------
        while True:
            # Accept connections from outside
            (clientsocket, address) = listening_socket.accept()
            log('DEBUG: Connected with ' + address[0] + ':' + str(address[1]))
    
            # Read data sent by the client
            msg = clientsocket.recv(4096)
    
            print 'Received message ' + msg
            # Handle different types of message
            if msg.startswith('checkpoint'):
                label = msg.split(':')[1]                
                log('DEBUG: Transaction started')
                #cursor_tr.execute('start transaction')
                query = 'savepoint {}'.format(label)
                log(query)
                cursor_tr.execute(query)
    
                sent = clientsocket.send('OK')
                if sent == 0:
                    raise RuntimeError('Socket connection broken')
    
            elif msg.startswith('restore'):
                label = msg.split(':')[1]
                query = 'rollback to savepoint {}'.format(label)
                log(query)
                cursor_tr.execute(query)

                sent = clientsocket.send('OK')
                if sent == 0:
                    raise RuntimeError('Socket connection broken')
    
            else:               
                query = msg.lower()    
                log(query)        
    
                if ('show' in query[:10]):
                    new_query = "select table_name from information_schema.tables where table_schema='{}'".format(db_database)
                    # Send new query to client
                    sent = clientsocket.send(new_query)
                    clientsocket.close()
                    if sent == 0:
                        raise RuntimeError('Socket connection broken')
                elif ('select' in query[:10]):
                    raise NameError('Proxy should not receive select queries')
                    '''
                    query = query.replace(';', '')                    

                    if query not in create_table_command_cache.keys():
                        query_result_template = 'template_{}'.format(hashlib.sha1(query).hexdigest()[:8])                                                                           
                        temporary_table_query = 'create temporary table {} select * from ('.format(query_result_template) + query + ') as XXX where false'
                        log(temporary_table_query)                     
                        cursor_tr.execute(temporary_table_query)
                        
                        show_create_query = 'show create table {}'.format(query_result_template)
                        log(show_create_query)
                        cursor_tr.execute(show_create_query)                        
                        table_create = cursor_tr.fetchall() 
                             
                        create_table_command = table_create[0][1].lower().replace('create temporary table', 'create table').replace(query_result_template, 'RESULT_TABLE_NAME')
                        create_table_command_cache[query] = create_table_command
                                      
                        drop_temporary_table_query = 'drop temporary table {}'.format(query_result_template)
                        log(drop_temporary_table_query)
                        cursor_tr.execute(drop_temporary_table_query)                                                            
                    
                                        
                    #cursor.execute('DROP TABLE IF EXISTS {}'.format(result_table))
                    
                    result_table = 'result_{}'.format(result_counter)
                    create_table_command = create_table_command_cache[query].replace('RESULT_TABLE_NAME', result_table)                                          
                    log(create_table_command)
                    cursor.execute(create_table_command)                                                    
                                        
                    cursor_tr.execute(query)                                    
                    query_result = cursor_tr.fetchall()
                    query_desc = cursor_tr.description
                    
                    insert_stmt = "insert into {} values (".format(result_table) + ("%s," * len(query_desc)).strip(",") + ")"
                    for res in query_result:                        
                        cursor.execute(insert_stmt, res)                                          
                    db_connection.commit()

                    new_query = 'select * from {}'.format(result_table)
                    result_counter = (result_counter + 1) # % proxy_max_result_tables
                    
                    sent = clientsocket.send(new_query)
                    clientsocket.close()
                    if sent == 0:
                        raise RuntimeError('Socket connection broken')
                    '''
                else: 
                    # UPDATE, DELETE, INSERT or some other query
                    # Execute query
                    try:
                        cursor_tr.execute(query)
                        sent = clientsocket.send('true')
                        clientsocket.close()
                        if sent == 0:
                            raise RuntimeError('Socket connection broken')
                    except:
                        sent = clientsocket.send('false')
                        clientsocket.close()
                        if sent == 0:
                            raise RuntimeError('Socket connection broken')           
    
    except KeyboardInterrupt:
        print 'Keyboard Interrupt'        
    except:
        raise
    finally:
        # Clean up the connection
        listening_socket.close()