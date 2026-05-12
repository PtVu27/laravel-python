#!/bin/sh
set -e

echo "🚀 Starting Laravel application..."

cd /var/www/html

# Create .env from environment variables if not exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file from environment variables..."
    cp .env.example .env 2>/dev/null || touch .env
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
else
    echo "🔑 Using existing APP_KEY from environment..."
fi

# Create storage directories if missing
echo "📁 Ensuring storage directories exist..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# ======================================
# FIX 500 ERROR: Permission + Cache
# ======================================

# 1. Force full permissions (fix permission denied errors)
echo "🔓 Setting permissions (chmod 777)..."
chmod -R 777 storage bootstrap/cache

# 2. Clear ALL cached config/routes/views (fix stale cache 500 errors)
echo "🧹 Clearing all cached configuration..."
php artisan optimize:clear 2>/dev/null || true

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Run migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force 2>/dev/null || echo "⚠️ Migration failed - database may not be available yet"

# Run seeders (Create admin account)
echo "🌱 Seeding database..."
php artisan db:seed --force 2>/dev/null || echo "⚠️ Seeding failed"

# Re-cache configuration for production (after clearing)
echo "⚡ Optimizing for production..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Ensure permissions again after caching
chmod -R 777 storage bootstrap/cache

# Update Nginx port if PORT env is set (Render requirement)
if [ -n "$PORT" ]; then
    echo "🌐 Configuring Nginx to listen on port $PORT..."
    sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/http.d/default.conf
fi

echo "✅ Application ready! Starting services..."

exec "$@"
