### In case of PostgreSQL


```
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ sudo service docker start
[sudo] password for shinya:
 * Starting Docker: docker                                                                                                                                            [ OK ]
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose -f ./docker-compose-with-volume.yml up -d
Creating network "postgresql_default" with the default driver
Creating volume "postgresql_postgres" with default driver
Pulling postgres (postgres:latest)...
latest: Pulling from library/postgres
7d63c13d9b9b: Pull complete
cad0f9d5f5fe: Pull complete
ff74a7a559cb: Pull complete
c43dfd845683: Pull complete
e554331369f5: Pull complete
d25d54a3ac3a: Pull complete
bbc6df00588c: Pull complete
d4deb2e86480: Pull complete
cb59c7cc00aa: Pull complete
80c65de48730: Pull complete
1525521889be: Pull complete
38df9e245e81: Pull complete
79300c1d4f7a: Pull complete
Digest: sha256:db927beee892dd02fbe963559f29a7867708747934812a80f83bff406a0d54fd
Status: Downloaded newer image for postgres:latest
Creating postgresql_postgres_1 ...
Creating postgresql_postgres_1 ... done
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose ps
        Name                       Command              State                    Ports
--------------------------------------------------------------------------------------------------------
postgresql_postgres_1   docker-entrypoint.sh postgres   Up      0.0.0.0:5432->5432/tcp,:::5432->5432/tcp

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose -f ./docker-compose-with-volume.yml up -d
Creating network "postgresql_default" with the default driver
Creating volume "postgresql_postgres-store" with default driver
Creating postgresql_postgres_1 ...
Creating postgresql_postgres_1 ... done

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose exec postgres psql --username=postgres
psql (14.0 (Debian 14.0-1.pgdg110+1))
Type "help" for help.

postgres=# \l
                                 List of databases
   Name    |  Owner   | Encoding |  Collate   |   Ctype    |   Access privileges
-----------+----------+----------+------------+------------+-----------------------
 POC       | postgres | UTF8     | en_US.utf8 | en_US.utf8 |
 postgres  | postgres | UTF8     | en_US.utf8 | en_US.utf8 |
 template0 | postgres | UTF8     | en_US.utf8 | en_US.utf8 | =c/postgres          +
           |          |          |            |            | postgres=CTc/postgres
 template1 | postgres | UTF8     | en_US.utf8 | en_US.utf8 | =c/postgres          +
           |          |          |            |            | postgres=CTc/postgres
(4 rows)

postgres=# \q

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker volume ls
DRIVER    VOLUME NAME
local     postgresql_postgres-store

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker volume inspect postgresql_postgres-store
[
    {
        "CreatedAt": "2021-11-03T15:04:43+09:00",
        "Driver": "local",
        "Labels": {
            "com.docker.compose.project": "postgresql",
            "com.docker.compose.volume": "postgres-store"
        },
        "Mountpoint": "/var/lib/docker/volumes/postgresql_postgres-store/_data",
        "Name": "postgresql_postgres-store",
        "Options": null,
        "Scope": "local"
    }
]
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$


shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose exec postgres psql --username=postgres
psql (14.0 (Debian 14.0-1.pgdg110+1))
Type "help" for help.

postgres=# select version();
                                                           version
-----------------------------------------------------------------------------------------------------------------------------
 PostgreSQL 14.0 (Debian 14.0-1.pgdg110+1) on x86_64-pc-linux-gnu, compiled by gcc (Debian 10.2.1-6) 10.2.1 20210110, 64-bit
(1 row)

postgres=# \l
                                 List of databases
   Name    |  Owner   | Encoding |  Collate   |   Ctype    |   Access privileges
-----------+----------+----------+------------+------------+-----------------------
 POC       | postgres | UTF8     | en_US.utf8 | en_US.utf8 |
 postgres  | postgres | UTF8     | en_US.utf8 | en_US.utf8 |
 template0 | postgres | UTF8     | en_US.utf8 | en_US.utf8 | =c/postgres          +
           |          |          |            |            | postgres=CTc/postgres
 template1 | postgres | UTF8     | en_US.utf8 | en_US.utf8 | =c/postgres          +
           |          |          |            |            | postgres=CTc/postgres
(4 rows)

postgres=#

```




