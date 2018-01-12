#!/bin/bash

echo "Provisioning virtual machine..."

echo "Installing tools"
apt-get install debconf-utils vim -y > /dev/null

echo "Installing NGIX"
cat <<EOF > /etc/apt/sources.list

deb http://debian.mirrors.ovh.net/debian/ wheezy main contrib non-free
#deb-src http://debian.mirrors.ovh.net/debian/ wheezy main contrib non-free

deb http://security.debian.org/ wheezy/updates main contrib non-free
#deb-src http://security.debian.org/ wheezy/updates main contrib non-free

# dotdeb
deb http://packages.dotdeb.org wheezy all
deb http://packages.dotdeb.org wheezy-php55 all

EOF
wget https://www.dotdeb.org/dotdeb.gpg -O- | apt-key add -
apt-get update > /dev/null
apt-get install nginx -y > /dev/null

echo "Installing PHP"
apt-get install php5-common php5-dev php5-cli php5-fpm -y > /dev/null

echo "Installing PHP extensions"
apt-get install curl php5-curl php5-gd php5-mcrypt php5-mysql -y > /dev/null

echo "Installing Memcached"
apt-get install memcached -y > /dev/null

echo "Installing MySQL server"
debconf-set-selections <<< "mysql-server mysql-server/root_password password 1234"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password 1234"
apt-get install mysql-server -y > /dev/null

echo "Configuring NGINX"
cp /vagrant/provision/config/nginx_vhost /etc/nginx/sites-available/nginx_vhost > /dev/null
cp /vagrant/provision/config/nginx_restrictions_params /etc/nginx/restrictions_params > /dev/null
cp /vagrant/provision/config/php-fpm-pool-www.conf /etc/php5/fpm/pool.d/www.conf > /dev/null
ln -snf /etc/nginx/sites-available/nginx_vhost /etc/nginx/sites-enabled/ > /dev/null
rm -f /etc/nginx/sites-available/default

echo "Configuring PHP5"
cat <<EOF | tee /etc/php5/cli/conf.d/timezone.ini /etc/php5/fpm/conf.d/timezone.ini
date.timezone = "Europe/Paris"
EOF

mkdir -p /var/lib/php5/sessions/
chown www-data:www-data /var/lib/php5/sessions/
touch /var/log/symfony.log
chown www-data:www-data /var/log/symfony.log

service nginx restart > /dev/null

echo "Configuring database"
cat <<EOF | mysql -uroot -p1234 > /dev/null
CREATE DATABASE IF NOT EXISTS congres;
CREATE USER 'congres'@'localhost' IDENTIFIED BY 'congres';
GRANT ALL PRIVILEGES ON congres.* TO 'congres'@'localhost';
FLUSH PRIVILEGES;
EOF

