#!/bin/sh
kill -TERM $(cat /var/run/peripheriques_value.pid)

exec /usr/bin/php /usr/bin/peripheriques_value.php > /dev/null &

echo $! |tee /var/run/peripheriques_value.pid
