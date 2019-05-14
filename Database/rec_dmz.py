#!/usr/bin/env python
import pika
import json
import call

from connect import register
#from call import callreg
#from call import callauth
from call import calllog

credentials = pika.PlainCredentials('admin', 'IT490password')
parameters = pika.ConnectionParameters('192.168.10.50', '5672', '/', credentials)
connection = pika.BlockingConnection(parameters)
channel = connection.channel()

channel.queue_declare(queue='log')

channel.basic_consume(calllog,
                      queue='log',
                      no_ack=True)

print "Waiting for stuff..."
channel.start_consuming()
