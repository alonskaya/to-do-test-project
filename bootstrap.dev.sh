#!/bin/bash

sleep 5

php /var/www/vendor/bin/doctrine-migrations migrations:migrate --configuration=config/migrations.php --db-configuration=config/database.php

php-fpm