# Installation Instructions
Tested on Ubuntu 20.04 LTS.

1. Clone project repo: `sudo rm -rf /var/www/html && sudo git clone https://github.com/RomanAvery/TripleLMS.git /var/www/html`
2. Run install script: `cd /var/www/html && sudo ./deployment/vm-install.sh`
3. (Optional) run install script for MySQL: `sudo ./deployment/mysql-install.sh`
    - It will prompt you to create a root password, make sure to keep this safe!
    - 
4. Configure Laravel Nova authentication: `composer config 
5. Copy .ENV file and populate it: `cp .env.example .env && sudo nano .env`
6. Install PHP dependencies with Composer: `sudo chown $USER:$USER . -R && composer install --no-dev --no-interaction --prefer-dist --ignore-platform-reqs --optimize-autoloader --apcu-autoloader --ansi --no-scripts`
7. 