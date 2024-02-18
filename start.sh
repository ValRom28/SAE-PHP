#!/bin/bash

php Cli/sqlite.php delete-tables
sleep 1
php Cli/sqlite.php create-tables
sleep 1
php Cli/sqlite.php load-data
sleep 1
php -S localhost:5000