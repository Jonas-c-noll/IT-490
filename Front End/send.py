#!/usr/bin/env python
import pika
import sys

connection = pika.BlockingConnection(pika.ConnectionParameters('localhost'))
channel = connection.channel()

channel.queue_declare(queue=sys.argv[1])

channel.basic_publish(exchange='',
	routing_key=sys.argv[1],
	body=sys.argv[2])
print(" [x] Sent " + sys.argv[2])
connection.close()
