#!/usr/bin/env python
import pika
import requests
import json

#from connect import auth
#from connect import grab
#from  parse import sent

#connection = pika.BlockingConnection(pika.ConnectionParameters(
#        host='localhost'))
#channel = connection.channel()

credentials = pika.PlainCredentials('admin', 'IT490password');

parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)

connection = pika.BlockingConnection(parameters)

channel = connection.channel()




channel.queue_declare(queue='http1')

def callback(ch, method, properties, body):
    print(" [x] Received %r on http1" % body)
    r = json.loads(body)
    res = requests.get('http://jservice.io/api/category?id=%27+str(r)  )
    x = res.text
    y = "received and sent json"
    channel.queue_declare(queue='http2')
    channel.basic_publish(exchange='',
                      routing_key='http2',
                      body=x)
    print(" [x] Sent %r to http2" % body)


    channel.queue_declare(queue='log')
    channel.basic_publish(exchange='',
                      routing_key='log',
                      body=y)








channel.basic_consume(callback,
                      queue='http1',
                      no_ack=True)



print(' [*] Waiting for messages. To exit press CTRL+C')

channel.start_consuming()
