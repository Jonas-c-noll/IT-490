#!/usr/bin/python
import pika
import json
import MySQLdb


#def write(info):
#    f = open('logs.txt', 'a')
#    f.write(info)
#    f.write('\n')



#def qckauth(user):
# Open database connection
#    db = MySQLdb.connect("localhost","root","password","IT490" )
#    print "This is authentication for IT project"

# prepare a cursor object using cursor() method
#    cursor = db.cursor()

# execute SQL query using execute() method.

# Fetch a single row using fetchone() method.

#    s = "select * from Auth  where username = '" + user + "';"
#    cursor.execute(s)
#    data = cursor.fetchone()
#    if (data):
#        return 0
#    else:
#        print "Not in friends list"
#        return 1
# disconnect from server
#    db.close()

def auth(user, pss):
# Open database connection
    db = MySQLdb.connect("localhost","root","password","IT490" )
    print "This is authentication for IT project"

    cursor = db.cursor()

    s = "select * from Auth  where username = '" + user + "' and password = '" + pss + "';"
#    write("======This is authentication======")
#    write(s)
#    write("============================")
    cursor.execute(s)
    data = cursor.fetchone()
    if (data):
        print "Auth Succeed"
        return 0
    else:
        print "Auth failed"
        return 1
# disconnect from server
    db.close()


def register (name, passwd, highscore):
# Open database connection
    print "This is registration reponse for IT project"
    db = MySQLdb.connect("localhost","root","password","IT490" )


# prepare a cursor object using cursor() method
    cursor = db.cursor()

# execute SQL query using execute() method.

# Fetch a single row using fetchone() method.
#    s ="INSERT INTO `Auth` (`username`, `password`, `Highscore`) VALUES (%s, %s, %s)"

    s = "INSERT INTO `Auth`(`username`, `password`, `Highscore`) VALUES (" +"'" + name +"','" + passwd + "'," + highscore + ")"
    sp = "CREATE TABLE " + name + "(FRYNAME varchar(255) UNIQUE);"
#    write("========This is registeration=======")
#    write(s)
#    write("================================")
    try:
        cursor.execute(sp)
        db.commit
        print "you inserted a friend"
    except(MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error"
        print (e)
        print "\n" + sp
        return 1

    try:
        cursor.execute(s)
        db.commit()
        write("Registration suceeds")
        return 0
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error"
        print(e)
        print "\n" + s
        write("Error: there is an error")
        write(str(e))
        return 1
    data = cursor.fetchone()
    return 0 
 # disconnect from server
    db.close()


def grabscore(user):
    s = "select `Highscore` from Auth where username = '" + user + "';"
    print s
    db = MySQLdb.connect("localhost","root","password","IT490" )
    cursor = db.cursor()
    print "This is Highscore for IT project"
    try:
        cursor.execute(s)
        p = cursor.fetchall()
        write("score has been grabbed")
        return p[0][0] 
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error: "
        print(e)
        print "\n"
        write(str(e))
        return 0
    data = cursor.fetchone()

def upscore(user, score):
    score = str(score)
    s = "UPDATE `Auth` SET `Highscore`=" + score + " WHERE `username` = '" + user + "';"
    db = MySQLdb.connect("localhost","root","password","IT490" )
    cursor = db.cursor()
    print "This is Highscore for IT project"
    try:
        cursor.execute(s)
        db.commit()
        print "Debug: it worked? " + s
        write("Highscore for %r has been recorded" %user)
        return 0
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error: "
        print(e)
        print "\n"
        write(str(e))
        return 1

def insrtfry(username, fry):
    db = MySQLdb.connect("localhost","root","password","IT490" )
    print "This is inserting into your friend"

    cursor = db.cursor()

    s = "INSERT INTO`" + username + "`(`FRYNAME`)VALUES('" + fry + "')"
#    pre_s = "SELECT `username` FROM `Auth` WHERE `username` = " + fry 
#    print pre_s
#    try:
#        cursor.execute(pre_s)
#        db.commit()
#        returen 0
#    except (MySQLdb.Error, MySQLdb.Warning) as e:
#        print "There is an error"
#        print(e)
#        print "\n" + pre_s 
#        write(str(e))
#        return 1
#    chck = qckauth(fry)
#    if (chck != 0):
#	return 0
    try: 
        cursor.execute(s)
        db.commit()
        print "Registeration succ"
        return 0
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error"
        print(e)
        print "\n" + s
        write(str(e))
        return 1

def grabfry(user):
    db = MySQLdb.connect("localhost","root","password","IT490" )
    print "This is inserting into your friend"

    cursor = db.cursor()
    s = "Select FRYNAME from " + user + " where 1"
    print s
    try:
        cursor.execute(s)
#        db.commit()
        p = cursor.fetchall()
        print "grab succ"
        return p
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error"
        print(e)
        print "\n" + s
        write(str(e))
        return 1

def callfullscore():
    db = MySQLdb.connect("localhost","root","password","IT490" )

    cursor = db.cursor()
    s = "SELECT `username`, `Highscore` as 'Username', 'Highscores' FROM `Auth` WHERE 1 ORDER BY `Highscore`  DESC" 
    try:
        cursor.execute(s)
#        db.commit()
        p = cursor.fetchall()
        print "grab succ"
        return p
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error"
        print(e)
        print "\n" + s
        write(str(e))
        return 1

def grabhighfry(user):
    db = MySQLdb.connect("localhost","root","password","IT490" )
    result = ''
    cnt = 0
    cursor = db.cursor()
    s = "SELECT * FROM " + user + " WHERE 1"
    try:
        cursor.execute(s)
#        db.commit()
        p = cursor.fetchall()
#        print p[0][0]
#        print p[1][0]
        for row in cursor:
            s1 = "select `Highscore` from Auth where username = '" + p[cnt][0] + "';"
            print "The command is " + s1
            cursor.execute(s1)
            k = cursor.fetchall()
            #print k
            #print result
            result = result + p[cnt][0] + ":" + str(k[0][0])
            #print result
            cnt = cnt + 1
        print "grab succ" 
        return result 
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print "There is an error"
        print(e)
        print "\n" + s
        write(str(e))
        return 1

def write(info):
    f = open('logs.txt', 'a')
    f.write(info)
    f.write('\n')

