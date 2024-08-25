#!/bin/bash

echo "Starting setup..."

# Step 1: Install Composer dependencies
echo "Installing Composer dependencies..."
composer install

# Step 2: Install NPM dependencies
echo "Installing NPM dependencies..."
npm install

# Step 3: Install Laravel Breeze
echo "Installing Laravel Breeze..."
composer require laravel/breeze --dev
php artisan breeze:install

# Step 4: Install Purifier package
echo "Installing Mews Purifier..."
composer require mews/purifier

# Step 5: Install RobThree TwoFactorAuth package
echo "Installing RobThree TwoFactorAuth..."
composer require robthree/twofactorauth

# Step 6: Migrate and seed the database
echo "Migrating and seeding the database..."
php artisan migrate --seed

echo "Setup complete."