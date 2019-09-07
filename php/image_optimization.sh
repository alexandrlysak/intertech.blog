#!/bin/bash

cd /var/www/storage
find -type f -name "*.jpg" -exec jpegoptim --strip-all {} \;
find -type f -name "*.png" -exec optipng {} \;