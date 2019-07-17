#!/usr/bin/python3
import pymysql

sqlhost = "localhost"
sqluser = "root"
sqlpassword = "your password here"

conn = pymysql.connect(sqlhost, sqluser, sqlpassword)
cursor = conn.cursor()

sqlstmt = "CREATE DATABASE omdbapi;"
cursor.execute(sqlstmt)

sqlstmt = "USE omdbapi;"
cursor.execute(sqlstmt)

sqlstmt = "CREATE TABLE userdetails (username varchar(255) not null, email varchar(255) not null,password varchar(255) not null);"
cursor.execute(sqlstmt)

sqlstmt = "CREATE USER 'useromdbapi'@'localhost' IDENTIFIED BY 'useromdbapi1!Q';"
cursor.execute(sqlstmt)

sqlstmt = "GRANT ALL PRIVILEGES ON omdbapi . * TO 'useromdbapi'@'localhost';"
cursor.execute(sqlstmt)

sqlstmt = "FLUSH PRIVILEGES;"
cursor.execute(sqlstmt)

conn.close()
