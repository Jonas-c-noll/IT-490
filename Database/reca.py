#!/usr/bin/env python
import pika
import json
import call

from connect import register
from call import callreg
from call import callauth
from call import calllog

def calltest(ch, method, properties, body):
    print "potatos"

credentials = pika.PlainCredentials('admin', 'IT490password')
parameters = pika.ConnectionParameters('192.168.10.60', '5672', '/', credentials)
connection = pika.BlockingConnection(parameters)
channel = connection.channel()
channel.queue_declare(queue='login')

channel.basic_consume(calltest,
                      queue='login',
                      no_ack=True)

#    print(" [x] Sent 'Hello World!'")

print "Waiting for stuff..."
channel.start_consuming()
