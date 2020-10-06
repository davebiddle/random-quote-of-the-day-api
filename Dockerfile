FROM ubuntu:20.04
#------------------------------------------------
# Install Apache, PHP and required PHP extensions
#------------------------------------------------
#USER root

# Install required packages
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends --quiet ca-certificates \
    apache2 php7.4 libapache2-mod-php7.4 php7.4-bcmath php7.4-mbstring wget vim

# Configure PHP server timezone
# https://serverfault.com/a/949998
RUN ln -fs /usr/share/zoneinfo/Europe/London /etc/localtime

# Configure Apache's default vhost to point to Laravel's `public` directory
RUN sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/public/' \
    /etc/apache2/sites-available/000-default.conf

# Install `mhsendmail` for configuring Mailhog container as outgoing email server, and configure PHP to use it
# https://blog.mailtrap.io/mailhog-explained/#Set_up_MailHog_using_Docker
WORKDIR /usr/bin
RUN wget https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 && \
    chmod +x mhsendmail_linux_amd64 && \
    mv mhsendmail_linux_amd64 mhsendmail

WORKDIR /etc/php/7.4/apache2/conf.d
RUN echo "sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025" > ./mailhog.ini

# Update Apache user's id and group to match the host user's id and group,
# in order to allow Apache write access to the webroot directory.
ARG HOST_USER_ID
ARG HOST_GROUP_ID

RUN usermod -u $HOST_USER_ID www-data && \
    groupadd --gid $HOST_GROUP_ID apache-web && \
    usermod -aG $HOST_GROUP_ID www-data

# ENTRYPOINT
# https://docs.docker.com/engine/reference/builder/#entrypoint
# https://docs.docker.com/config/containers/multi-service_container/
# Runs apache2ctl -D FOREGROUND when this container starts.
# The -D flag allows passing an Apache configuration parameter, 'FOREGROUND' in this case.
# The 'FOREGROUND' configuration parameter causes Apache to run as the container's main process.
# Why is this desirable? Without passing `FOREGROUND`, Apache would run in a 'detached' state, as a background process.
# This would cause the container to exit, because containers only run while their main process is running.
EXPOSE 80 443
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]