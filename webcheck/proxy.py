#!/usr/bin/python

import MySQLdb
import sys
import ConfigParser

DATABASE_SECTION = 'DATABASE'

if __name__ == "__main__":
    try:
        # Program Section
    
        if len(sys.argv) != 2:
            print ('Usage: ' + sys.argv[0] + ' <config file>')
            sys.exit(-1)
              
        config_file = sys.argv[1]        
        config = ConfigParser.ConfigParser()
        config.read(config_file)
        db_username = config.get(DATABASE_SECTION, 'USERNAME')
        db_password = config.get(DATABASE_SECTION, 'PASSWORD')
        db_database = config.get(DATABASE_SECTION, 'DATABASE')
    
        # ------------------------------
        #   Setup Database Connections
        # ------------------------------
        db_tr_cnx = MySQLdb.connect(user=db_username, password=db_password, database=db_database)
        db_result_cnx = MySQLdb.connect(user=db_username, password=db_password, database=db_database)
        cursor_tr = db_tr_cnx.cursor()
        cursor_res = db_result_cnx.cursor()
    
        # --------------------------
        #   Setup Messaging Server
        # --------------------------
        serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM) # Create a socket object
        host = '127.0.0.1' # Get local machine name
        port = 12325 # Reserve a port for your service.
        serversocket.bind((host, port)) # Bind to the port
        serversocket.listen(5) # 5 simultaneous connection max
    
        # --------------
        #  Transaction
        # --------------
        is_transaction = False
    
        # ------------
        #  Variables
        # ------------
        created_tables = []
        i = 0
        number_error_catch = 0
    
        # -------
        #  LOOP
        # -------
        while True:
            # Accept connections from outside
            (clientsocket, address) = serversocket.accept()
            #print "DEBUG: -----------------------"
            print "DEBUG: Connected with " + address[0] + ":" + str(address[1])
    
            # Read data sent by the client
            mess = clientsocket.recv(4096)
            # Might fuck up the whole thing --> yep
            #mess = mess.lower()
    
    
            # Remove previously created tables.
            removed = []
            for table in created_tables:
                remove_table(table, cursor_res, db_result_cnx)
                removed.append(table)
            for rem in removed:
                created_tables.remove(rem)
    
            # Handle different types of message
            if mess == "start_savepoint":
                is_transaction = True
                #print "DEBUG: Transaction started on cursor_tr !!!"
                #cursor_tr.execute("start transaction")
                cursor_tr.execute("savepoint xxx")
    
                sent = clientsocket.send("Savepoint-Intermediate-Success")
                if sent == 0:
                    raise RuntimeError("Socket connection broken")
    
            elif mess == "start_tr_initial":
                is_transaction_initial = True
                #print "DEBUG: Transaction started on cursor_tr !!!"
                cursor_tr.execute("start transaction")
                cursor_tr.execute("savepoint initial")
    
                sent = clientsocket.send("Transaction-Initial-Success")
                if sent == 0:
                    raise RuntimeError("Socket connection broken")
    
            elif mess == "roll_back":
                if is_transaction:
                    #print "DEBUG: Rollback on cursor_tr"
                    cursor_tr.execute("rollback to savepoint xxx")
    
                    sent = clientsocket.send("Rollback-Intermediate-Success")
                    if sent == 0:
                        raise RuntimeError("Socket connection broken")
    
            elif mess == "roll_back_initial":
                if is_transaction_initial:
                    #print "DEBUG: Rollback on cursor_tr"
                    cursor_tr.execute("rollback to savepoint initial")
    
                    sent = clientsocket.send("Rollback-Initial-Success")
                    if sent == 0:
                        raise RuntimeError("Socket connection broken")
    
            else:
                # A query has been sent
                #print "DEBUG: message: ", mess
                query = mess.lower()
                print "DEBUG: Message:", query
                
    
                # Determine type of query: Selection or Other.
                if ("select" in query[:10]) or ("show" in query[:10]):
    
                    # Execute query, and get result.
                    cursor_tr.execute(query)
                    #print "DEBUG: query executed"
                    query_desc = cursor_tr.description
                    query_result = cursor_tr.fetchall()
                    #print "DEBUG: query_result - "
    
                    # Create result table
                    column_list, table_name = create_and_fill_result_table(query_result, query_desc, cursor_res, db_result_cnx, i)
                    created_tables.append(table_name)
    
                    # Calculate new query q'
                    new_query = "select " + ",".join(column_list) + " from " + table_name
    
                    # Send new query to client
                    sent = clientsocket.send(new_query)
                    if sent == 0:
                        raise RuntimeError("Socket connection broken")
    
                else: 
                    # UPDATE, DELETE, INSERT or some other query
                    # Execute query
                    try:
                        cursor_tr.execute(query)
                        print "DEBUG: query executed"
                        sent1 = clientsocket.send("true")
                        if sent1 == 0:
                            raise RuntimeError("Socket connection broken")
                    except:
                        print "DEBUG: query failed to execute"
                        sent2 = clientsocket.send("false")
                        if sent2 == 0:
                            raise RuntimeError("Socket connection broken")
    
                # Commit if not in transaction
                if not is_transaction:
                    db_tr_cnx.commit()
    
            # Close client socket
            clientsocket.close()
            i = i+1
    
    except KeyboardInterrupt:
        serversocket.close()
        print "Keyboard Interrupt"
    
    except:
        serversocket.close()
        raise