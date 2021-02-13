FROM mysql
MAINTAINER Sebastian <curellsebastian@gmail.com>
ENV MYSQL_ROOT_PASSWORD 1234
ENV MYSQL_USER usuario
ENV MYSQL_PASSWORD 12345
ENV MYSQL_DATABASE demodb
COPY script.sql  /docker-entrypoint-initdb.d/
EXPOSE 3306
