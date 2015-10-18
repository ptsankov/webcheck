#!/usr/bin/python

import sys
import ConfigParser
import MySQLdb
from static import DATABASE_SECTION
import random
import string
from datetime import date

MIN_INT = 0
MAX_INT = 100000000
VARCHAR_LENGTH=10

def random_int():
    return random.randint(MIN_INT, MAX_INT)

def random_tinyint():
    return random.randint(0, 254)

def random_varchar():
    return ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(VARCHAR_LENGTH))

def random_date():
    return date.today().isoformat()

def random_char():
    return random.choice(string.ascii_letters)



if __name__ == '__main__':
    
    if len(sys.argv) != 3:
        print ('Usage: ' + sys.argv[0] + ' <config file> <# entries per table')
        sys.exit(-1)
               
    num_entries = int(sys.argv[2])   
            
    config_file = sys.argv[1]           
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    
    db_host = config.get(DATABASE_SECTION, 'HOST')
    db_username = config.get(DATABASE_SECTION, 'USERNAME')
    db_password = config.get(DATABASE_SECTION, 'PASSWORD')
    db_database = config.get(DATABASE_SECTION, 'DATABASE')
    db_tables_prefix = config.get(DATABASE_SECTION, 'TABLES_PREFIX')
    
    db_connection = MySQLdb.connect(host=db_host, user=db_username, passwd=db_password, db=db_database)
    cursor = db_connection.cursor()
    
    query_tables = 'show tables like "{}%"'.format(db_tables_prefix)    
    cursor.execute(query_tables)
    result_tables = cursor.fetchall()
    tables = [x[0] for x in result_tables]
    
    for table in tables:
        print 'Table', table
        query_desc = 'desc {}'.format(table)
        cursor.execute(query_desc)
        result_desc = cursor.fetchall()
        cur_entry = 0
        insert_stmt = "insert into {} values (".format(table) + ("%s," * len(result_desc)).strip(",") + ")"
        while cur_entry < num_entries:
            res = []
            for desc_entry in result_desc:
                sql_type = desc_entry[1]
                if sql_type.startswith('int') or sql_type.startswith('decimal') or sql_type.startswith('float'):
                    res.append(random_int())
                elif sql_type.startswith('tinyint'):
                    res.append(random_tinyint())
                elif  sql_type.startswith('varchar') or sql_type.startswith('mediumtext') or sql_type.startswith('text'):
                    res.append(random_varchar())
                elif sql_type.startswith('date'):
                    res.append(random_date())
                elif sql_type.startswith('char'):
                    res.append(random_char())
                else:
                    print 'Add support for', sql_type
                    sys.exit(-1)
            print insert_stmt, res
            try:            
                cursor.execute(insert_stmt, res)
            except:
                pass
            cur_entry += 1
    db_connection.commit()
    db_connection.close()
