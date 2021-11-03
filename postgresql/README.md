## In case of PostgreSQL


#### Docker Compose for PostgreSQL with Volume

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

#### Docker Compose for PostgreSQL with PostGIS


```
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose -f ./docker-compose-with-postgis.yml up -d
Creating network "postgresql_default" with the default driver
Creating volume "postgresql_postgis-store" with default driver
Pulling postgis (postgis/postgis:latest)...
latest: Pulling from postgis/postgis
7d63c13d9b9b: Already exists
cad0f9d5f5fe: Already exists
ff74a7a559cb: Already exists
c43dfd845683: Already exists
e554331369f5: Already exists
d25d54a3ac3a: Already exists
bbc6df00588c: Already exists
d4deb2e86480: Already exists
d4132927c0d9: Pull complete
3d03efa70ed1: Pull complete
645312b7d892: Pull complete
3cc7074f2000: Pull complete
4e6d0469c332: Pull complete
491db3867d77: Pull complete
4c11382a9f43: Pull complete
77fa4330ea15: Pull complete
Digest: sha256:126a86e4b944894f9140bcfb210593e9725963582c8bcab621db1422ab93d648
Status: Downloaded newer image for postgis/postgis:latest
Creating postgresql_postgis_1 ...
Creating postgresql_postgis_1 ... done
shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$

shinya@DESKTOP-8BDL7KA:~/git/rdbms-docker/postgresql$ docker-compose exec postgres psql --username=postgres
psql (13.4 (Debian 13.4-4.pgdg110+1))
Type "help" for help.

postgres=# \c POC
You are now connected to database "POC" as user "postgres".
POC=# CREATE EXTENSION IF NOT EXISTS postgis;
CREATE EXTENSION
POC=# CREATE TABLE IF NOT EXISTS T_GIS
(
    id     int PRIMARY KEY,
    geom   GEOMETRY(POINT, 4612)
);
CREATE TABLE
POC=# SELECT PostGIS_full_version();
                                                                       postgis_full_version
-------------------------------------------------------------------------------------------------------------------------------------------------------------------
 POSTGIS="3.1.4 ded6c34" [EXTENSION] PGSQL="130" GEOS="3.9.0-CAPI-1.16.2" PROJ="7.2.1" LIBXML="2.9.10" LIBJSON="0.15" LIBPROTOBUF="1.3.3" WAGYU="0.5.0 (Internal)"
(1 row)

POC=# SELECT ST_GeoHash(ST_SetSRID(ST_MakePoint(139.777254,35.713768),4326));
      st_geohash
----------------------
 xn77htqxy0fu2t0y69sv
(1 row)

POC=#


```


#### Information

https://hub.docker.com/_/postgres

https://registry.hub.docker.com/r/postgis/postgis/

http://postgis.net/

