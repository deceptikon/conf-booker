from datetime import datetime
import time
import csv
import MySQLdb
import MySQLdb.cursors
import ujson as json

json_dumps = json.dumps

db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                     user="root",         # your username
                     passwd="root",  # your password
                     db="conf_booker_db",
                     cursorclass=MySQLdb.cursors.DictCursor)






# you must create a Cursor object. It will let
#  you execute all the queries you need
cur = db.cursor()

# Use all the SQL you like

with open('db.csv', mode='r') as infile:
    reader = csv.reader(infile, delimiter=';', quotechar='"')
    for row in reader:
        if row[5]:
            print (row)
            cur.execute(
                  """INSERT INTO users (fullname,job_place,address,position,degree,phone,email,device,uid, is_member)
                  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, 1)""",
                  row)

    db.commit()
db.close()
