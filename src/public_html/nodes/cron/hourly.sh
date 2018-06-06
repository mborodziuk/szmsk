#!/bin/sh
killall php
cd /var/www/nodes/cron
php hourly.php
