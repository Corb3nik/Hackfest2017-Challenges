FROM php:7.0-apache
RUN apt-get update -y
RUN apt-get install git ruby cron -y

COPY theeee_flaaag_issss_heeeeere.txt /theeee_flaaag_issss_heeeeere.txt

COPY src/ /var/www/html
WORKDIR /var/www/html
RUN git init
RUN git add .
RUN git commit -m "initial commit"

ADD crontab /etc/cron.d/log-cleanup
RUN chmod 0644 /etc/cron.d/log-cleanup

ENTRYPOINT cron && git instaweb --httpd=webrick -p 21001 && apache2-foreground
