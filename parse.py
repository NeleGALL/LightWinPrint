#!/usr/bin/python
# -*- coding: utf-8

import MySQLdb
import string

db = MySQLdb.connect(host="192.168.10.10", user="ps1", passwd="ps1", db="Log", charset='utf8')
cursor = db.cursor()
sql = "SELECT Time, User, Printer, Pages, Size, Document FROM `print` ORDER BY `time` DESC"
cursor.execute(sql)
data =  cursor.fetchall()
Time, User, Printer, Pages, Size, Document = rec
for rec in data:
	YearA = Time.year
	DayA = Time.day
	print Document