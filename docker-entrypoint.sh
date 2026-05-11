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
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Run migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force 2>/dev/null || echo "⚠️ Migration failed - database may not be available yet"

# Cache configuration for production
echo "⚡ Optimizing for production..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Update Nginx port if PORT env is set (Render requirement)
if [ -n "$PORT" ]; then
    echo "🌐 Configuring Nginx to listen on port $PORT..."
    sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/http.d/default.conf
fi

echo "✅ Application ready! Starting services..."

exec "$@"
