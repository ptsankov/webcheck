#!/usr/bin/python

import sys
import ConfigParser
import MySQLdb
from static import DATABASE_SECTION
import random
import string
from datetime import date
from webcheck import runcmd
import os

MIN_INT = 0
MAX_INT = 100000000
VARCHAR_LENGTH=10

def random_int():
    return random.randint(MIN_INT, MAX_INT)

def random_medium_int():
    return random.randint(MIN_INT, 9999999)

def random_small_int():
    return random.randint(MIN_INT, 999999)

def random_tinyint():
    return random.randint(0, 254)

def random_varchar():
    return ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(VARCHAR_LENGTH))

def random_date():
    return date.today().isoformat()

def random_char():
    return random.choice(string.ascii_letters)

def dump_size(dump_file):    
    runcmd('mysqldump -u {} -p{} {}'.format(db_username, db_password, db_database), output=open(dump_file, 'w'))
    return os.path.getsize(dump_file)/(1024*1024) 


if __name__ == '__main__':
    
    if len(sys.argv) != 3:
        print ('Usage: ' + sys.argv[0] + ' <config file> <size in MB>')
        sys.exit(-1)
               
    size = int(sys.argv[2])   
            
    config_file = sys.argv[1]           
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    
    db_host = config.get(DATABASE_SECTION, 'HOST')
    db_username = config.get(DATABASE_SECTION, 'USERNAME')
    db_password = config.get(DATABASE_SECTION, 'PASSWORD')
    db_database = config.get(DATABASE_SECTION, 'DATABASE')
    db_tables_prefix = 'phpbb_'
    
    db_connection = MySQLdb.connect(host=db_host, user=db_username, passwd=db_password, db=db_database)
    cursor = db_connection.cursor()
    
    query_tables = 'show tables like "{}%"'.format(db_tables_prefix)    
    cursor.execute(query_tables)
    result_tables = cursor.fetchall()
    tables = [x[0] for x in result_tables]
    
    dump_file='dump.sql'
    sql_size = dump_size(dump_file)
    
    while sql_size < size:
        for table in tables:
            query_desc = 'desc {}'.format(table)
            cursor.execute(query_desc)
            result_desc = cursor.fetchall()
            cur_entry = 0
            insert_stmt = "insert into {} values (".format(table) + ("%s," * len(result_desc)).strip(",") + ")"
            while cur_entry < 1000:
                res = []
                for desc_entry in result_desc:
                    sql_type = desc_entry[1]
                    if sql_type.startswith('int') or sql_type.startswith('decimal') or sql_type.startswith('float') or sql_type.startswith('bigint'):
                        res.append(random_int())
                    elif sql_type.startswith('mediumint'):
                        res.append(random_medium_int())
                    elif sql_type.startswith('smallint'):
                        res.append(random_small_int())
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
                try:            
                    cursor.execute(insert_stmt, res)
                except:
                    pass
                cur_entry += 1
        db_connection.commit()
        sql_size = dump_size(dump_file)
        print 'Dump size', sql_size
    db_connection.commit()
    db_connection.close()
