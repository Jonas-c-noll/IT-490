#!/usr/bin/env python
import pika
import json
import call

from connect import register
from call import callreg
from call import callauth
from call import calllog
from call import callfry
from call import callfrylist
from call import callscore
from call import callgrabscore
from call import callfryscore
credentials = pika.PlainCredentials('admin', 'IT490password')
print "1"
parameters = pika.ConnectionParameters('192.168.10.80', '5672', '/', credentials)
print "2"
connection = pika.BlockingConnection(parameters)
print "3"
channel = connection.channel()
print "4"

channel.queue_declare(queue='reg')
print "5"
channel.queue_declare(queue='auth')
print "7"
channel.queue_declare(queue='log')
print "8"
channel.queue_declare(queue='fry')
print "9"
channel.queue_declare(queue='score')
print "10"
channel.queue_declare(queue='fryrec')
print "11"
channel.queue_declare(queue='scoreup')
print "12"
channel.queue_declare(queue='highscores')
print "13"
channel.queue_declare(queue='highfry')
print "14"
channel.basic_consume(callreg,
                      queue='reg',
                      no_ack=True)
channel.basic_consume(callauth,
                      queue='auth',
                      no_ack=True)
channel.basic_consume(calllog,
                      queue='log',
                      no_ack=True)
channel.basic_consume(callfry,
                      queue='fry',
                      no_ack=True)
channel.basic_consume(callfrylist,
                      queue='fryrec',
                      no_ack=True
                    )
channel.basic_consume(callscore,
                      queue='scoreup',
                      no_ack=True)
channel.basic_consume(callgrabscore,
                      queue='highscores',
                      no_ack=True)
channel.basic_consume(callgrabscore,
                      queue='highscores',
                      no_ack=True)
channel.basic_consume(callfryscore,
                      queue='highfry',
                      no_ack=True)#send the full scores
print "Waiting for stuff..."
channel.start_consuming()
