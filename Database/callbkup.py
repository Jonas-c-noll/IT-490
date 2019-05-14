#!/usr/bin/env python
import pika
import json
import requests
from connect import register
from connect import auth
from parse import parse
from parse import grabs

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
    k = 'they call me the idea bringer'
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

    temp = parse(body)
    user = temp['username']
    pss = temp['password']
    temp1 = auth(user, pss)
    print(" [x] Received authentication" )
    if(temp1 == 0):
        k = "a"
        write('authentication succed')
    else:
        k = "n"
        write('authentication failed')
    channel.basic_publish(exchange='',
                      routing_key='login',
                      body=k)

    print(" [x] Sent 'Hello World!'")
    connection.close()

def calllog(ch, method, properties, body):
    write(body)    
    print '[*] log updated'

#def callfry:


def write(info):
    f = open('logs.txt', 'a')
    f.write(info)
    f.write('\n')
