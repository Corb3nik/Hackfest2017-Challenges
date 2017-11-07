FROM mysql:5.7.18
ENV MYSQL_DATABASE: "baby_sqli"
ENV MYSQL_USER: "baby_sqli"
ENV MYSQL_PASSWORD: "thisisasecurepassword123"
ENV MYSQL_ROOT_PASSWORD: "root"
ENV MYSQL_ALLOW_EMPTY_PASSWORD: "yes"
ADD setup.sql /docker-entrypoint-initdb.d/setup.sql

