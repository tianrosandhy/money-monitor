# Simple Wallet Monitor Apps
---
### About
This apps is from Laravel 8 with custom module structure. This apps will help you monitor and reporting your money condition. This apps is free to download and use. 

**Check the demo here :**
https://money-monitor.tianrosandhy.com
Demo Email : user@money.com
Demo Password : 123456


### Minimum Requirements
- Storage at least 300MB
- PHP 7.3 or more
- Composer version 1 or more

### Installation
First you need to clone this repository in your www/htdocs directory
```sh
git clone https://github.com/tianrosandhy/money-monitor.git
```
Run composer install in your project directory to install the dependencies
```sh
composer install
```
Create blank database, then copy the ".env.example" into ".env"
```sh
cp .env.example .env
```
Open the .env file, and setup the environtment. Make sure you fill the right environtment in APP_URL, DB_DATABASE, DB_USERNAME, and DB_PASSWORD, because that was the mandatory environtment for this apps
```sh
APP_NAME="Money Monitor"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=https://your-project-endpoint.test
FORCE_HTTPS=true #OR FALSE IF YOUR SERVER DOESNT SUPPORT HTTPS

FILESYSTEM_DRIVER=public
LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_blank_database_name
DB_USERNAME=root
DB_PASSWORD=
```

After you setup the right environtment, then these are the last laravel command before run your apps. If the commands below are failed, then you need to make sure the environtment is working
```sh
php artisan key:generate
php artisan migrate
php artisan storage:link
```

Last, you need to open your browser and access your project endpoint (Example : https://your-project-endpoint.test) and fill the new superadmin credentials  for this apps. 
That's all!

### Dummy Data
You can generate dummy wallets data with the commands below. This command will generate default wallet in your apps. Just type "yes" after the confirmation message shown
```sh
php artisan generate:wallet
```
If you want to fill the default data in that default wallets data, you can run these command too
```sh
php artisan generate:dummy-record
```
Then please type the months dummy data that you want to generate from 1-24 month. Please note that the dummy record command only generate dummy values from default wallet for testing purpose only. 

If you want to clear the database, and start from new scratch apps again, just run this command : 
```sh
php artisan migrate:fresh
php artisan key:generate
```
then you need to open the browser to start the superadmin credential installation again.

### Contact
For more information, you can contact me via email : tianrosandhy@gmail.com