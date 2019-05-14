#!/usr/bin/env python
import pika
import json
import requests
from connect import register
from connect import auth
from parse import parse
from parse import grabs
from connect import grabscore
from connect import insrtfry
from connect import grabfry
from connect import callfullscore
from connect import upscore
from connect import grabhighfry 
credentials = pika.PlainCredentials('admin', 'IT490password')
parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)


def callreg(ch, method, properties, body):
    parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
    connection = pika.BlockingConnection(parameters)
    channel = connection.channel()

    channel.queue_declare(queue='regauth')
    #parse the body    
    temp = parse(body)
    user = temp['username']
    pss = temp['password']
    hscore = temp['highscore']
    #register('4','Potato','password','241')
    temp1 = register(user, pss, hscore) 
    if(temp1 == 0):
        k = "t"
    else:
        k = "f"
    channel.basic_publish(exchange='',
                          routing_key='regauth',
                          body=k)

    print(" [x] I've sent something")
    connection.close()

    print(" [x] Received registeration" )

def callauth(ch, method, properties, body):
    parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
    connection = pika.BlockingConnection(parameters)
    channel = connection.channel()

    channel.queue_declare(queue='login')
    channel.queue_declare(queue='scoreget')
    
    temp = parse(body)
    user = temp['username']
    pss = temp['password']
    temp1 = auth(user, pss)
    #sentscore = str(grabscore(user))
    print(" [x] Received authentication" )
    if(temp1 == 0):
        k = "a"
        write('authentication succed')
    else:
        k = "n"
        write('authentication failed')
    t = channel.basic_publish(exchange='',
                      routing_key='login',
                      body=k)
    kk = channel.basic_publish(exchange = '',
                      routing_key='scoreget',
                      body = k 
                      )

def calllog(ch, method, properties, body):
    write(body)    
    print '[*] log updated'

def callscore(ch, method, properties, body):
    parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
    connection = pika.BlockingConnection(parameters)
    channel = connection.channel()
    channel.queue_declare(queue='scoreget')
    #parse the body    
    temp = parse(body)
    user = temp['username']
#    cmd = temp['command']
    score =temp['score']
    scores = grabscore(user)
    print 'the score is: ' + str(scores)
    if (score > scores):
        upscore(user, score)
        k = 'score updated'
        print k
    else:
        k = 'score checked, no update'
        print k
    t = channel.basic_publish(exchange='',
                          routing_key='scoreget',
                          body=k)
#    if(t):
#        print "The message: " + k + " works"
    connection.close()

def callgrabscore(ch, method, properties, body):
    parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
    connection = pika.BlockingConnection(parameters)
    channel = connection.channel()
    channel.queue_declare(queue='highscore')
    #parse the body

    k = callfullscore()
#    print "callgrabscore is suppose to do something"
#    result = str( grabfry(k))
    k = str(k)
    print  k

    t = channel.basic_publish(exchange='',
                      routing_key='highscore',
                      body=k)
    if (t):
        print "It worked"


def callfry(ch, method, properties, body):   
    temp = parse(body)
    user = temp['username']
    fry =temp['friend']
    insrtfry(user, fry)
    print "friend insert success"

def callfrylist(ch, method, properties, body):
    parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
    connection = pika.BlockingConnection(parameters)
    channel = connection.channel()

    channel.queue_declare(queue='frylist')
   
    temp = parse(body);
    print body;
    user = temp['username']
    result = str( grabfry(user))

    t = channel.basic_publish(exchange='',
                      routing_key='frylist',
                      body=result)
    if (t):
        print "It worked"

def callfryscore(ch, method, properties, body):
    parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
    connection = pika.BlockingConnection(parameters)
    channel = connection.channel()

    channel.queue_declare(queue='frylist')

    temp = parse(body);
    print body;
    user = temp['username']
    result = str(grabhighfry(user))
    print result
    t = channel.basic_publish(exchange='',
                      routing_key='frylist',
                      body=result)
    if (t):
        print "It worked"


def write(info):
    f = open('logs.txt', 'a')
    f.write(info)
    f.write('\n')
