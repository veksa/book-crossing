#!/usr/bin/env bash

#== Import script args ==

github_token=$(echo "$1")

#== Bash helpers ==

function info {
    echo " "
    echo "--> $1"
    echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

info "Configure mysql default access data"
echo '
[mysql]
user=root
password=
' | tee --append ~/.my.cnf


info "Configure composer"
composer config --global github-oauth.github.com ${github_token}
echo "Done!"

info "Install plugins for composer"
composer global require "fxp/composer-asset-plugin:^1.2.0" --no-progress

info "Install project dependencies"
cd /var/www
composer --no-progress --prefer-dist install

cd /var/www
info "Init project"
php init --env=Development --overwrite=y

info "Enabling colorized prompt for guest console"
sed -i "s/#force_color_prompt=yes/force_color_prompt=yes/" /home/vagrant/.bashrc

info "Apply crontab"
crontab /var/www/vagrant/provision/crontab

info "Apply only login table"
php yii migrate/up 2 <<< "yes"

info "Apply test database"
php /var/www/yii_test migrate/up <<< "yes"

info "Build tests"
php /var/www/vendor/codeception/base/codecept build

info "Download the Book Review dataset"
if [ ! -r BX-SQL-Dump.zip ]
then
    wget "http://www2.informatik.uni-freiburg.de/~cziegler/BX/BX-SQL-Dump.zip"
fi

if [ ! -r BX-Users.sql ]
then
    unzip BX-SQL-Dump.zip
fi

mv BX-* ~

perl -pi -e s'/\) TYPE=MyISAM;/\);/' ~/*.sql

ACS="mysql book_crossing"

info "Decompression of Ratings"
$ACS < ~/BX-Book-Ratings.sql
info "Decompression of Books"
$ACS < ~/BX-Books.sql
info "Decompression of Users"
$ACS < ~/BX-Users.sql
info "Done!";

info "Optimize tables, replace primary ISBN to ID and add unique to ISBN, normalize country"
$ACS < /var/www/vagrant/provision/optimize.sql
info "Done!";

php yii rating
