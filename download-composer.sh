#!/bin/bash
# Script untuk download Composer.phar untuk deployment ke Hostinger (Linux/Mac)
# Jalankan script ini dengan: bash download-composer.sh

echo "Downloading Composer installer..."

# Download installer
curl -sS https://getcomposer.org/installer -o composer-setup.php

if [ $? -eq 0 ]; then
    echo "Installer downloaded successfully!"
    
    # Run installer
    echo "Installing Composer.phar..."
    php composer-setup.php --install-dir=. --filename=composer.phar
    
    # Clean up installer
    rm -f composer-setup.php
    
    echo ""
    echo "Composer.phar berhasil didownload!"
    echo "File location: $(pwd)/composer.phar"
    echo ""
    echo "Untuk menggunakan: php composer.phar install"
    
    # Make it executable
    chmod +x composer.phar
    
    echo "File dibuat executable!"
else
    echo "Error downloading Composer"
    exit 1
fi

