# rdbms-docker
This repository is used for creating rdbms docker images

Please read detail information about docker-compose.
https://docs.docker.jp/compose/toc.html


## MySQL

#### docker-compose.yml (DATA is not removed volumes option)

- stop and down is not remove mysql objects
- down --volume or down --volumes will not remove the volume and data.

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

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose.yml up -d
Starting mysql_db_1 ...
Starting mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| POC                |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)

mysql> use POC
Database changed
mysql> CREATE TABLE `sensor` (
    ->   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    ->   `dev_id` varchar(32) NOT NULL,
    ->   `temperature` varchar(10) NOT NULL,
    ->   `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ->   PRIMARY KEY (`id`)
    -> ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
Query OK, 0 rows affected, 1 warning (0.05 sec)

mysql> insert into sensor(id,dev_id,temperature,last_update) values(1,'dev01','30°',now());
Query OK, 1 row affected (0.01 sec)

mysql> select * from sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:16:48 |
+----+--------+-------------+---------------------+
1 row in set (0.00 sec)

mysql>exit

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose stop
Stopping mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose.yml up -d
Starting mysql_db_1 ...
Starting mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select * from POC.sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:16:48 |
+----+--------+-------------+---------------------+
1 row in set (0.01 sec)

mysql> exit
Bye

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose down
Stopping mysql_db_1 ... done
Removing mysql_db_1 ... done
Removing network mysql_default

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
Name   Command   State   Ports
------------------------------
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose.yml up -d
Creating network "mysql_default" with the default driver
Creating mysql_db_1 ...
Creating mysql_db_1 ... done
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select * from POC.sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:16:48 |
+----+--------+-------------+---------------------+
1 row in set (0.01 sec)

mysql> exit

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose down --volumes
Removing mysql_db_1 ... done
Removing network mysql_default
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
Name   Command   State   Ports
------------------------------
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose.yml up -d
Creating network "mysql_default" with the default driver
Creating mysql_db_1 ...
Creating mysql_db_1 ... done
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select * from POC.sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:16:48 |
+----+--------+-------------+---------------------+
1 row in set (0.01 sec)

mysql> exit
Bye

```

#### docker-compose-with-volume.yml (DATA is removed by volumes option)

- stop and down is not remove mysql objects
- down --volumes will remove the volume and data.

※ ここではファイルを指定しています。Defaultではdocker-compose.ymlが読み込まれる為。

```
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml up -d
Creating network "mysql_default" with the default driver
Creating volume "mysql_mysql-store" with default driver
Creating mysql_db_1 ...
Creating mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp


shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker volume ls
DRIVER    VOLUME NAME
local     mysql_mysql-store
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker volume inspect mysql_mysql-store
[
    {
        "CreatedAt": "2021-11-02T14:44:24+09:00",
        "Driver": "local",
        "Labels": {
            "com.docker.compose.project": "mysql",
            "com.docker.compose.volume": "mysql-store"
        },
        "Mountpoint": "/var/lib/docker/volumes/mysql_mysql-store/_data",
        "Name": "mysql_mysql-store",
        "Options": null,
        "Scope": "local"
    }
]

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.


mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| POC                |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)

mysql> use POC
Database changed
mysql> CREATE TABLE `sensor` (
    ->   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    ->   `dev_id` varchar(32) NOT NULL,
    ->   `temperature` varchar(10) NOT NULL,
    ->   `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ->   PRIMARY KEY (`id`)
    -> ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
Query OK, 0 rows affected, 1 warning (0.05 sec)

mysql> select * from POC.sensor;
Empty set (0.00 sec)

mysql> insert into sensor(id,dev_id,temperature,last_update) values(1,'dev01','30°',now());
Query OK, 1 row affected (0.01 sec)

mysql> select * from POC.sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:32:25 |
+----+--------+-------------+---------------------+
1 row in set (0.00 sec)

mysql> exit
Bye
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp


shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml stop
Stopping mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml up -d
Starting mysql_db_1 ...
Starting mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select * from POC.sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:32:25 |
+----+--------+-------------+---------------------+
1 row in set (0.01 sec)

mysql> exit
Bye

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml down
Stopping mysql_db_1 ... done
Removing mysql_db_1 ... done
Removing network mysql_default

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml up -d
Creating network "mysql_default" with the default driver
Creating mysql_db_1 ...
Creating mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select * from POC.sensor;
+----+--------+-------------+---------------------+
| id | dev_id | temperature | last_update         |
+----+--------+-------------+---------------------+
|  1 | dev01  | 30°         | 2021-11-01 21:32:25 |
+----+--------+-------------+---------------------+
1 row in set (0.01 sec)

mysql> exit
Bye


shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml down --volumes
Stopping mysql_db_1 ... done
Removing mysql_db_1 ... done
Removing network mysql_default
Removing volume mysql_mysql-store
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-volume.yml up -d
Creating network "mysql_default" with the default driver
Creating volume "mysql_mysql-store" with default driver
Creating mysql_db_1 ...
Creating mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 8
Server version: 8.0.27 MySQL Community Server - GPL

Copyright (c) 2000, 2021, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> select * from POC.sensor;
ERROR 1146 (42S02): Table 'POC.sensor' doesn't exist
mysql>
```


### Using .env file for storing not shareable information.

- アカウントやパスワードを環境変数に入れています。（Gitで共有出来ない情報をローカルのみに保持）
- git ignoreにて.envは除外しておいてください。

```
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ cat docker-compose-with-env-and-volume.yml
version: "3"

services:
    db:
       image: mysql:8.0
       volumes:
         - mysql-store:/var/lib/mysql
       # - ./docker/mysql/data:/var/lib/mysql
         - ./docker/mysql/logs:/var/log/mysql
         - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
       environment:
         - MYSQL_DATABASE=${DB_NAME}
         - MYSQL_USER=${DB_USER}
         - MYSQL_PASSWORD=${DB_PASSWORD}
         - MYSQL_ROOT_PASSWORD=${DB_ROOT_PASSWORD}
         - TZ="Asia/Tokyo"
      #command: mysqld --character-set-server=utf8mb4
       ports:
         - 13306:3306
volumes:
       mysql-store:
       
       
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ cat .env
DB_NAME=POC
DB_USER=admin
DB_PASSWORD=password
DB_ROOT_PASSWORD=password

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose -f ./docker-compose-with-env-and-volume.yml up -d
Creating network "mysql_default" with the default driver
Creating volume "mysql_mysql-store" with default driver
Creating mysql_db_1 ...
Creating mysql_db_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
Enter password:
ERROR 2013 (HY000): Lost connection to MySQL server at 'reading initial communication packet', system error: 2
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ mysql -h 127.0.0.1 -P 13306 -u root -p
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

mysql>

```




### NOTE (LOGIN to the Docker) 

```
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose ps
   Name                Command             State                           Ports
--------------------------------------------------------------------------------------------------------
mysql_db_1   docker-entrypoint.sh mysqld   Up      0.0.0.0:13306->3306/tcp,:::13306->3306/tcp, 33060/tcp

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose exec db mysql -V
mysql  Ver 8.0.27 for Linux on x86_64 (MySQL Community Server - GPL)

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/mysql$ docker-compose exec db bash
root@0ba49c28c5f4:/# exit
exit
```
