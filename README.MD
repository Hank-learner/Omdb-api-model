# FORMBUILDER

Apache 2 in ubuntu is used to host this server with mysql and php

## Setting up the mysql server:

### Instructions:

download the pymysql library since it is used in the files else:sudo apt-get install python3-pymysql

> 1.run the sqlinitialization.py file in the terminal(first make sure to update the root password in the file for connecting to mysql) <br>
> 2.next run the server.py in the terminal <br>
> 3.update the omdb api key and youtube api key in the variables in explorephp.php and home.php files
> 4.next copy omdb api folder to html
> 5.make sure to give the rquired permissions to the folder and files using chmod 777 \*
> 6.on running the folder index.php will be the login page