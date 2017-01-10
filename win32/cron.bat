@echo off
:Beginning
timeout 60
php "%~dp0..\core\cron.php"
GOTO Beginning