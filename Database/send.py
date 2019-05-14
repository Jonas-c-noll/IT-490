#!/usr/bin/env python
import pika

credentials = pika.PlainCredentials('admin', 'IT490password')
parameters = pika.ConnectionParameters('192.168.10.61', '5672', '/', credentials)
connection = pika.BlockingConnection(parameters)

channel = connection.channel()

channel.queue_declare(queue='hello')

channel.basic_publish(exchange='', routing_key='hello', body='Hello')

print("  [x] Send 'Hello World'")
connection.close()
