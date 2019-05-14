#!/usr/bin/env python
import pika
import json
import requests

def parse(string):
    temp = json.loads(string)
    #temp1 = json.dumps(temp)
    return temp

def grabs(string):
    r = requests.get(string)
#print r.json()
    k = r.json()
    k = json.dumps(k)
    return k

