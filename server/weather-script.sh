#!/bin/sh

#/var/www/weather is my webroot
cd "$(dirname "$0")"

php decode.php
convert weather-script-output.svg weather-script-output-new.png
pngcrush -c 0 -nofilecheck weather-script-output-new.png weather-script-output.png

