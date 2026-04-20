# SimpleWebFramework

## Setup

For the whole setup phase, don't forget to replace every `<VARIABLE_NAME>` with your own values

### Modules

Install needed modules:

```shell
sudo apt install php-common libapache2-mod-php php-cli php-mysql mariadb-server mariadb-client composer
```

### Database

Open MySQL in a shell (or with an tool such as PhpMyAdmin) and execute:

```shell
CREATE DATABASE <DB_NAME>;
CREATE USER <DB_USERNAME>@<DB_HOST> IDENTIFIED BY '<DB_PASSWORD>';
GRANT ALL PRIVILEGES ON <DB_NAME>.* TO <DB_USERNAME>@<DB_HOST>;
```

### Environment
At the root of your project, create a `.env` file based on this template:

```
DATABASE_NAME="<DB_NAME>"
DATABASE_HOST="<DB_HOST>"
DATABASE_PORT=3306
DATABASE_USERNAME="<DB_USERNAME>"
DATABASE_PASSWORD="<DB_PASSWORD>"
```

### Setup Apache
Create /etc/apache2/sites-availables/<CUSTOM_NAME>.conf:

```
<VirtualHost *:80>
	ServerName <SERVER_NAME>

	ServerAdmin <ADMIN_EMAIL>
	DocumentRoot /var/www/SimpleWebFramework/public

	<Directory /var/www/SimpleWebFramework/public/>
			Require all granted
			AllowOverride All
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/<CUSTOM_NAME>.error.log
	CustomLog ${APACHE_LOG_DIR}/<CUSTOM_NAME>.access.log combined
</VirtualHost>
```

#### Finish setup:
```
sudo a2ensite <CUSTOM_NAME>
sudo a2enmod rewrite
sudo service apache2 restart
```

### Install

```
cd /var/www/
sudo -u www-data git clone git@github.com:pppgOn/SimpleWebFramework.git
sudo -u www-data composer install
```