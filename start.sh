#!/bin/bash

php Cli/sqlqite.php delete-tables
sleep 1
php Cli/sqlqite.php create-tables
sleep 1
php Cli/sqlqite.php load-data
sleep 1
php -S localhost:5000