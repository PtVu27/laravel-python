#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-dev --optimize-autoloader

# Tối ưu hóa Laravel
php artisan optimize

# Chạy migrate để tạo bảng (quan trọng)
php artisan migrate --force