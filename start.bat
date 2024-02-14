@echo off

php Cli\sqlite.php delete-tables
ping -n 2 127.0.0.1>nul
php Cli\sqlite.php create-tables
ping -n 2 127.0.0.1>nul
php Cli\sqlite.php load-data
ping -n 2 127.0.0.1>nul
php -S localhost:5000