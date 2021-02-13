FROM ubuntu
ENV TZ=America/Argentina/Buenos_Aires
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update
RUN apt-get install -y curl
RUN apt-get install -y nano
RUN apt-get install -y dnsutils
RUN apt-get install -y apache2 
RUN apt-get install -y php7.4 libapache2-mod-php7.4 php7.4-mysql php7.4-curl php7.4-cli
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2enmod php7.4
RUN mkdir /var/log/meliapp
RUN touch /var/log/meliapp/archivoLog.txt
RUN chown www-data /var/log/meliapp/archivoLog.txt
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_LOG_DIR=/var/log/apache2
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_PID_FILE=/var/run/apache2.pid
ADD Html /var/www/html
ADD Certificados /etc/ssl/
ADD Configuracion/000-default.conf /etc/apache2/sites-available/
ADD Configuracion/default-ssl.conf /etc/apache2/sites-available/
ADD Configuracion/apache2.conf /etc/apache2/
ADD Configuracion/ports.conf /etc/apache2/
ADD Configuracion/security.conf /etc/apache2/conf-available
ADD Configuracion/ssl-params.conf /etc/apache2/conf-available
ADD Configuracion/scriptCargaWeb.sh /usr/bin/
RUN a2ensite default-ssl.conf
RUN chown -R www-data /var/www/
RUN chmod +x /usr/bin/scriptCargaWeb.sh
CMD usr/sbin/apache2ctl start && sleep 10 && /usr/bin/scriptCargaWeb.sh
EXPOSE 80
EXPOSE 443
