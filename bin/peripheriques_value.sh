#!/bin/sh
kill -TERM $(cat /var/run/peripheriques_value.pid)

currentFolder=`dirname $0`

exec /usr/bin/php $currentFolder/peripheriques_value.php > /dev/null &

echo $! |tee /var/run/peripheriques_value.pid
