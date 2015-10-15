#!/usr/bin/python

import MySQLdb
import sys
import ConfigParser
import socket
from static import PROXY_SECTION, DATABASE_SECTION

if __name__ == '__main__':
    
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
        #   Create table templates
        # --------------------------
        query = 'start transaction'
        print query
        cursor_tr.execute(query)        
    
        
    
        # ------------
        #  Variables
        # ------------
        result_counter = 0
        number_error_catch = 0
    
        # -------
        #  LOOP
        # -------
        while True:
            # Accept connections from outside
            (clientsocket, address) = listening_socket.accept()
            #print 'DEBUG: -----------------------'
            print 'DEBUG: Connected with', address[0] + ':' + str(address[1])
    
            # Read data sent by the client
            msg = clientsocket.recv(4096)
    
            print 'Received message', msg
            # Handle different types of message
            if msg.startswith('checkpoint'):
                label = msg.split(':')[1]                
                print 'DEBUG: Transaction started'
                #cursor_tr.execute('start transaction')
                query = 'savepoint {}'.format(label)
                print query
                cursor_tr.execute(query)
    
                sent = clientsocket.send('OK')
                if sent == 0:
                    raise RuntimeError('Socket connection broken')
    
            elif msg.startswith('restore'):
                label = msg.split(':')[1]
                query = 'rollback to savepoint {}'.format(label)
                print query
                cursor_tr.execute(query)

                sent = clientsocket.send('OK')
                if sent == 0:
                    raise RuntimeError('Socket connection broken')
    
            else:
                # A query has been sent                
                query = msg.lower()    
                print query        
    
                # Determine type of query: Selection or Other.
                if ('show' in query[:10]):
                    raise RuntimeError('Add support for SHOW queries')
                elif ('select' in query[:10]):
                    # Execute query, and get result.
                    cursor_tr.execute(query)
                    query_result = cursor_tr.fetchall()
                    query_desc = cursor_tr.description
                    result_table = 'result_{}'.format(result_counter)
                    
                    query = 'create temporary table {} select * from ('.format(result_table) + query + ') as XXX where false'
                    print query                     
                    cursor_tr.execute(query)
                    query = 'show create table {}'.format(result_table)
                    print query
                    cursor_tr.execute(query)
                    table_create = cursor_tr.fetchall()                    
                    query = 'drop temporary table {}'.format(result_table)
                    print query
                    cursor_tr.execute(query)
                    create_table_command = table_create[0][1].replace('CREATE TEMPORARY TABLE', 'CREATE TABLE')
                    print create_table_command
                    cursor.execute(create_table_command)                                                    
                    
                    insert_stmt = "INSERT INTO {} VALUES (".format(result_table) + ("%s," * len(query_desc)).strip(",") + ")"
                    for res in query_result:                        
                        cursor.execute(insert_stmt, res)                                          
                    db_connection.commit()

                    new_query = 'select * from {}'.format(result_table)
                    result_counter += 1
                    
                    # Send new query to client
                    sent = clientsocket.send(new_query)
                    if sent == 0:
                        raise RuntimeError('Socket connection broken')
                    
                else: 
                    # UPDATE, DELETE, INSERT or some other query
                    # Execute query
                    try:
                        cursor_tr.execute(query)
                        sent = clientsocket.send('true')
                        if sent == 0:
                            raise RuntimeError('Socket connection broken')
                    except:
                        sent = clientsocket.send('false')
                        if sent == 0:
                            raise RuntimeError('Socket connection broken')           
    
    except KeyboardInterrupt:
        print 'Keyboard Interrupt'
    except:
        raise
    finally:
        # Clean up the connection
        listening_socket.close()