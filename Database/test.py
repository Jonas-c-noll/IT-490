#!/usr/bin/env python
import pika
import json
import MySQLdb


from call import write
from connect import grabscore
from connect import upscore
from connect import grabhighfry
user = 'jotest'
#k = upscore(user, 420)
k = grabhighfry(user)
print k
