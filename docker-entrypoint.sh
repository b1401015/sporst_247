#!/bin/sh

# Create upload directory if it doesn't exist
mkdir -p /var/www/html/public/upload

# Set permissions
chmod 777 -R /var/www/html/public/upload

# Execute the main container command
exec "$@"
