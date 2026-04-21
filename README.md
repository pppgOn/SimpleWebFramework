# SimpleWebFramework

## Setup

For the whole setup phase, don't forget to replace every `<VARIABLE_NAME>` with your own values.

### Modules

Install needed modules:

```shell
sudo apt install php-common libapache2-mod-php php-cli php-mysql mariadb-server mariadb-client composer
```

### Database

Open MySQL in a shell (or with a tool such as PhpMyAdmin) and execute:

```sql
CREATE DATABASE <DB_NAME>;
CREATE USER <DB_USERNAME>@<DB_HOST> IDENTIFIED BY '<DB_PASSWORD>';
GRANT ALL PRIVILEGES ON <DB_NAME>.* TO <DB_USERNAME>@<DB_HOST>;
```

### Setup Apache
Create /etc/apache2/sites-available/<CUSTOM_NAME>.conf:

```apache
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
```shell
sudo a2ensite <CUSTOM_NAME>
sudo a2enmod rewrite
sudo service apache2 restart
```

### Install

In your project directory:

```shell
cd /var/www/
sudo -u www-data git clone --recursive git@github.com:pppgOn/SimpleWebFramework.git
mkdir controllers
cd SimpleWebFramework/
sudo -u www-data composer install
cd app/
sudo -u www-data ln -s ../../controllers .
```

### Environment
At the root of the framework, create a `.env` file based on this template:

```shell
DATABASE_NAME="<DB_NAME>"
DATABASE_HOST="<DB_HOST>"
DATABASE_PORT=3306
DATABASE_USERNAME="<DB_USERNAME>"
DATABASE_PASSWORD="<DB_PASSWORD>"
```

## Usage

### Controllers

The framework is based on controllers. You must create all of your controllers as childs of basics contoller (`Controller` or `BootstrapController`) in the controllers directory.

Here is a simple example of a controller you can create:

```php
<?php
require_once FRAMEWORK_APP_ROOT . DIRECTORY_SEPARATOR . 'BootstrapController.php';

class TestController extends BootstrapController {
	#[Route(Method::GET, 'test/(?<id>[1-9][0-9]*)')]
	public function route_with_params(int $id) : void {
		echo 'route with this parameter: ' . strval($id);
	}

	#[Route(Method::GET, 'db/users')]
	public function test_db() : void {
		var_dump(db\execute('SELECT * FROM user')->fetchAll());
	}
}
```

### Database

The framework include a database wrapper wich you can use in the `db` namespace. The database wrapper is based on [PDO](https://www.php.net/manual/fr/book.pdo.php).