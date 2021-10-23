# rdbms-docker
This repository is used for creating rdbms docker images


### MySQL

```
root@DESKTOP-8BDL7KA:# docker-compose -f ./docker-compose.yml up -d
Creating mysql_db_1 ...
Creating mysql_db_1 ... done


root@DESKTOP-8BDL7KA:# docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp

root@DESKTOP-8BDL7KA:# mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select @@version;
+-----------+
| @@version |
+-----------+
| 8.0.27    |
+-----------+
1 row in set (0.00 sec)

mysql> exit
Bye

root@DESKTOP-8BDL7KA:# docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp

root@DESKTOP-8BDL7KA:# docker-compose stop
Stopping mysql_db_1 ... done
root@DESKTOP-8BDL7KA:# docker-compose ps
   Name                Command             State    Ports
---------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Exit 0

```
