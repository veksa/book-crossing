#!/usr/bin/env bash

#== Bash helpers ==

function info {
    echo " "
    echo "--> $1"
    echo " "
}

#== Provision script ==

username=$(whoami)
info "Provision-script user: `whoami`"

chmod -R 775 /vagrant
usermod -a -G ubuntu www-data

info "Allocate swap for MySQL"
fallocate -l 2048M /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap defaults 0 0' >> /etc/fstab

info "Import repository keys"
apt-get install software-properties-common python-software-properties -y
apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db
add-apt-repository 'deb http://ftp.cc.uoc.gr/mirrors/mariadb/repo/10.0/ubuntu trusty main' -y
add-apt-repository ppa:ubuntu-toolchain-r/test -y
add-apt-repository ppa:ondrej/php -y
add-apt-repository ppa:webupd8team/java -y

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Prepare root password for MySQL"
export DEBIAN_FRONTEND=noninteractive
debconf-set-selections <<< "mariadb-server-5.5 mysql-server/root_password password \"''\""
debconf-set-selections <<< "mariadb-server-5.5 mysql-server/root_password_again password \"''\""
echo "Done!"

info "Install MySQL"
apt-get install -y mariadb-server mariadb-client

info "Configure MySQL"
sed -i "s/log_bin/#log_bin/" /etc/mysql/my.cnf
sed -i "s/max_binlog_size/#max_binlog_size/" /etc/mysql/my.cnf
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

info "Install additional software"
apt-get install -y mc git g++-4.9 pwgen debconf-utils unzip php7.0 php7.0-cli php7.0-dev php7.0-cgi php7.0-fpm php7.0-curl php7.0-intl php7.0-gd php7.0-mcrypt php7.0-mysql php7.0-mbstring php7.0-imap php7.0-zip php-memcached php-xdebug pkg-config nginx

info "Create default tables"
service mysqld start
mysql -e "CREATE DATABASE book_crossing DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;"
mysql -e "CREATE DATABASE book_crossing_tests DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;"

info "Configure nginx"
ln -s /var/www/vagrant/nginx/api.books.conf /etc/nginx/sites-enabled/
ln -s /var/www/vagrant/nginx/books.conf /etc/nginx/sites-enabled/
rm -rf /etc/nginx/sites-available/default
rm -rf /etc/nginx/sites-enabled/default
cp /vagrant/provision/404.html /usr/share/nginx/html/404.html > /dev/null

info "Configure php-fpm"
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 100M/" /etc/php/7.0/fpm/php.ini
sed -i "s/;date.timezone =/date.timezone = Europe\/Moscow/" /etc/php/7.0/fpm/php.ini
sed -i "s/memory_limit = 128M/memory_limit = 1024M/" /etc/php/7.0/fpm/php.ini
sed -i "s/_errors = Off/_errors = On/" /etc/php/7.0/fpm/php.ini
sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.0/fpm/php.ini

info "Configure cli php"
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 100M/" /etc/php/7.0/cli/php.ini
sed -i "s/;date.timezone =/date.timezone = Europe\/Moscow/" /etc/php/7.0/cli/php.ini
sed -i "s/memory_limit = 128M/memory_limit = 1024M/" /etc/php/7.0/cli/php.ini
sed -i "s/_errors = Off/_errors = On/" /etc/php/7.0/cli/php.ini
sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.0/cli/php.ini

info "Configure opcache for php"
echo '
# Added for opcache
opcache.revalidate_freq=0
opcache.max_accelerated_files=7963
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.fast_shutdown=1
' | tee --append /etc/php/7.0/fpm/php.ini

info "Install phpMyAdmin"
mkdir /usr/share/phpmyadmin
cd /usr/share/phpmyadmin
wget https://files.phpmyadmin.net/phpMyAdmin/4.6.4/phpMyAdmin-4.6.4-all-languages.zip
unzip phpMyAdmin-4.6.4-all-languages.zip
rm -rf phpMyAdmin-4.6.4-all-languages.zip
mv phpMyAdmin-4.6.4-all-languages/* .
rm -rf phpMyAdmin-4.6.4-all-languages
mkdir config
chmod o+rw config

info "Configure phpMyAdmin"
cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
sed -i "s/AllowNoPassword'] = false;/AllowNoPassword'] = true;/" /usr/share/phpmyadmin/config.inc.php

info "Clean installation"
apt-get autoremove -y

info "Install root folder"
if ! [ -L /var/www ]; then
    rm -rf /var/www
    ln -fs /vagrant /var/www
fi

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
