
### mysql_native_password

```
PHPのバージョンにもよりますが、MySQL8.0から認証プラグインがDefaultで以下のcaching_sha2_passwordになっています。
こちらのリポジトリーでは、docker-composeで新規作成したアカウントが、caching_sha2_passwordになっているので、
PHPのバージョンによって認証方法を変更する必要があります。

Dockrを起動したあとは、my.cnfにてDefault認証方法をmysql_native_passwordに変更してるので、
新規ユーザーは、mysql_native_passwordになります。
```


- アカウントの認証プラグインの変更方法は以下の通りです。（MySQL5.7迄は特に対応は不要です）
```
mysql> SELECT user, host, plugin FROM mysql.user;
+------------------+-----------+-----------------------+
| user             | host      | plugin                |
+------------------+-----------+-----------------------+
| admin            | %         | caching_sha2_password |
| root             | %         | caching_sha2_password |
| mysql.infoschema | localhost | caching_sha2_password |
| mysql.session    | localhost | caching_sha2_password |
| mysql.sys        | localhost | caching_sha2_password |
| root             | localhost | caching_sha2_password |
+------------------+-----------+-----------------------+
6 rows in set (0.01 sec)

mysql> show global variables like 'default_authentication_plugin';
+-------------------------------+-----------------------+
| Variable_name                 | Value                 |
+-------------------------------+-----------------------+
| default_authentication_plugin | mysql_native_password |
+-------------------------------+-----------------------+
1 row in set (0.00 sec)

mysql> alter user `admin`@`%` IDENTIFIED WITH mysql_native_password BY 'password';
Query OK, 0 rows affected (0.01 sec)

mysql> alter user `root`@`%` IDENTIFIED WITH mysql_native_password BY 'password';
Query OK, 0 rows affected (0.01 sec)

mysql> SELECT user, host, plugin FROM mysql.user;
+------------------+-----------+-----------------------+
| user             | host      | plugin                |
+------------------+-----------+-----------------------+
| admin            | %         | mysql_native_password |
| root             | %         | mysql_native_password |
| mysql.infoschema | localhost | caching_sha2_password |
| mysql.session    | localhost | caching_sha2_password |
| mysql.sys        | localhost | caching_sha2_password |
| root             | localhost | caching_sha2_password |
+------------------+-----------+-----------------------+
6 rows in set (0.00 sec)

mysql>
```

※　MySQL Dockerを起動する方法は、こちらのレポジトリのTOPを参照してください。
