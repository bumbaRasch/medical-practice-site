# Deployment & Configuration Guide

## Table of Contents

1. [Environment Setup](#environment-setup)
2. [Local Development](#local-development)
3. [Production Deployment](#production-deployment)
4. [Docker Configuration](#docker-configuration)
5. [Performance Optimization](#performance-optimization)
6. [Database Management](#database-management)
7. [Caching Configuration](#caching-configuration)
8. [Security Configuration](#security-configuration)
9. [Monitoring & Logging](#monitoring--logging)
10. [Backup & Recovery](#backup--recovery)

---

## Environment Setup

### System Requirements

**Minimum Requirements:**
- PHP 8.3+ with extensions: mbstring, xml, ctype, json, bcmath, pdo_mysql
- Composer 2.0+
- Node.js 18+ with npm/yarn
- MySQL 8.0+ or MariaDB 10.4+
- Redis 6.0+ (for caching)

**Recommended Production:**
- PHP 8.3 with OPcache enabled
- 2+ CPU cores
- 4GB+ RAM
- SSD storage
- CDN for static assets

### Required PHP Extensions

```bash
# Ubuntu/Debian
sudo apt-get install php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-redis

# CentOS/RHEL  
sudo yum install php83-cli php83-fpm php83-mysql php83-xml php83-mbstring php83-curl php83-zip php83-redis
```

---

## Local Development

### Initial Setup

```bash
# Clone repository
git clone <repository-url>
cd arzt-landing-page

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Environment configuration
cp .env.example .env
php artisan key:generate
```

### Environment Variables (.env)

```ini
# Application
APP_NAME="Hausarzt Praxis"
APP_ENV=local
APP_KEY=base64:generated-key-here
APP_DEBUG=true
APP_TIMEZONE=Europe/Berlin
APP_URL=http://localhost:8000

# Localization
APP_LOCALE=de
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=de_DE

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hausarzt_db_bumbara
DB_USERNAME=laravel_hausarzt_bumbara
DB_PASSWORD=secret_password_hausartz_bumba

# Cache & Session
CACHE_STORE=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@hausarzt-praxis.de"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_PRACTICE_EMAIL="praxis@hausarzt-praxis.de"

# Performance
RESPONSE_CACHE_ENABLED=true
TELESCOPE_ENABLED=true

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

### Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE hausarzt_db_bumbara CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'laravel_hausarzt_bumbara'@'localhost' IDENTIFIED BY 'secret_password_hausartz_bumba';
GRANT ALL PRIVILEGES ON hausarzt_db_bumbara.* TO 'laravel_hausarzt_bumbara'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations and seeds
php artisan migrate:fresh --seed
```

### Development Server

```bash
# Start Laravel development server
php artisan serve

# Start asset compilation with hot reload
npm run dev

# Access application
# http://localhost:8000
```

---

## Production Deployment

### Production Environment Variables

```ini
# Application
APP_NAME="Hausarzt Praxis"
APP_ENV=production
APP_KEY=base64:production-key-here
APP_DEBUG=false
APP_TIMEZONE=Europe/Berlin
APP_URL=https://hausarzt-praxis.de

# Security
SECURE_COOKIES=true
HTTPS_ONLY=true
TRUSTED_PROXIES=*

# Database - Production Credentials
DB_CONNECTION=mysql
DB_HOST=production-db-host
DB_PORT=3306
DB_DATABASE=hausarzt_production
DB_USERNAME=hausarzt_prod_user
DB_PASSWORD=secure-production-password

# Cache & Performance
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_HOST=production-redis-host
REDIS_PASSWORD=redis-production-password

# Mail - Production SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.strato.de
MAIL_PORT=587
MAIL_USERNAME=praxis@hausarzt-praxis.de
MAIL_PASSWORD=production-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="praxis@hausarzt-praxis.de"
MAIL_FROM_NAME="Hausarzt Praxis"
MAIL_PRACTICE_EMAIL="praxis@hausarzt-praxis.de"

# Performance & Caching
RESPONSE_CACHE_ENABLED=true
CACHE_PREFIX=hausarzt_prod
SESSION_LIFETIME=120

# Monitoring & Error Tracking
SENTRY_LARAVEL_DSN=https://your-sentry-dsn
LOG_CHANNEL=stack
LOG_LEVEL=warning
TELESCOPE_ENABLED=false

# Asset Optimization
ASSET_URL=https://cdn.hausarzt-praxis.de
MIX_ASSET_URL=https://cdn.hausarzt-praxis.de
```

### Production Optimization Script

Create `scripts/optimize-production.sh`:

```bash
#!/bin/bash
set -e

echo "🚀 Optimizing Laravel application for production..."

# Install dependencies (production optimized)
composer install --optimize-autoloader --no-dev --no-interaction

# Clear and cache configurations
echo "📝 Caching configurations..."
php artisan config:clear
php artisan config:cache

php artisan route:clear  
php artisan route:cache

php artisan view:clear
php artisan view:cache

# Build optimized frontend assets
echo "🎨 Building optimized assets..."
npm ci --production
npm run build

# Warm application caches
echo "🔥 Warming caches..."
php artisan cache:clear
php artisan responsecache:clear

# Custom cache warming (if command exists)
if php artisan list | grep -q "cache:warm"; then
    php artisan cache:warm --force
fi

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Optimize autoloader
composer dump-autoload --optimize

echo "✅ Production optimization complete!"
echo "📊 Application ready for production deployment"
```

Make executable: `chmod +x scripts/optimize-production.sh`

### Web Server Configuration

#### Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name hausarzt-praxis.de www.hausarzt-praxis.de;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name hausarzt-praxis.de www.hausarzt-praxis.de;
    
    root /var/www/hausarzt-praxis.de/public;
    index index.php;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/hausarzt-praxis.de/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/hausarzt-praxis.de/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    ssl_prefer_server_ciphers off;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Performance
    client_max_body_size 10M;
    
    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

    # Static file caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|webp|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Laravel routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Security
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location /favicon.ico {
        access_log off;
        log_not_found off;
    }

    location /robots.txt {
        access_log off;
        log_not_found off;
    }
}
```

#### Apache Configuration

```apache
<VirtualHost *:443>
    ServerName hausarzt-praxis.de
    DocumentRoot /var/www/hausarzt-praxis.de/public
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/hausarzt-praxis.de/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/hausarzt-praxis.de/privkey.pem
    
    # Security Headers
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    
    # PHP Configuration
    <FilesMatch \.php$>
        SetHandler "proxy:unix:/var/run/php/php8.3-fpm.sock|fcgi://localhost"
    </FilesMatch>
    
    # Laravel Routing
    <Directory /var/www/hausarzt-praxis.de/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Asset Optimization
    <LocationMatch "\.(css|js|png|jpg|jpeg|gif|ico|svg|webp)$">
        ExpiresActive On
        ExpiresDefault "access plus 1 year"
        Header append Cache-Control "public"
    </LocationMatch>
</VirtualHost>
```

---

## Docker Configuration

### Docker Compose for Production

```yaml
# docker-compose.production.yml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile.production
    container_name: hausarzt-app
    restart: unless-stopped
    environment:
      - APP_ENV=production
      - DB_HOST=db
      - REDIS_HOST=redis
    volumes:
      - ./storage:/var/www/html/storage
      - ./bootstrap/cache:/var/www/html/bootstrap/cache
    networks:
      - hausarzt-network
    depends_on:
      - db
      - redis

  nginx:
    image: nginx:alpine
    container_name: hausarzt-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - .:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
      - ./docker/ssl:/etc/ssl/certs
    networks:
      - hausarzt-network
    depends_on:
      - app

  db:
    image: mysql:8.0
    container_name: hausarzt-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: hausarzt_production
      MYSQL_USER: hausarzt_prod_user
      MYSQL_PASSWORD: secure-production-password
      MYSQL_ROOT_PASSWORD: root-production-password
    volumes:
      - db_data:/var/lib/mysql
      - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
    networks:
      - hausarzt-network

  redis:
    image: redis:7-alpine
    container_name: hausarzt-redis
    restart: unless-stopped
    command: redis-server --appendonly yes --requirepass redis-production-password
    volumes:
      - redis_data:/data
    networks:
      - hausarzt-network

volumes:
  db_data:
  redis_data:

networks:
  hausarzt-network:
    driver: bridge
```

### Production Dockerfile

```dockerfile
# Dockerfile.production
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    nodejs \
    npm \
    mysql-client \
    redis \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    bcmath \
    opcache

# Install Redis PHP extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies and optimize
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm ci --production && npm run build

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 755 storage bootstrap/cache

# PHP-FPM configuration
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

EXPOSE 9000

CMD ["php-fpm"]
```

### Docker Development Setup

```bash
# Start development environment
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate:fresh --seed

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install && npm run dev

# View logs
docker-compose logs -f app
```

---

## Performance Optimization

### PHP Configuration (php.ini)

```ini
; Production optimizations
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
opcache.save_comments=1
opcache.fast_shutdown=1

; Memory and execution
memory_limit=512M
max_execution_time=300
max_input_time=300

; File uploads
upload_max_filesize=10M
post_max_size=10M

; Session
session.cookie_httponly=1
session.cookie_secure=1
session.use_strict_mode=1

; Security
expose_php=0
```

### Performance Monitoring Commands

```bash
# Cache optimization
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Custom cache warming
php artisan cache:warm --force

# Response cache management
php artisan responsecache:clear
php artisan responsecache:flush

# Performance testing
php artisan tinker
>>> cache('test-key', 'test-value');
>>> cache('test-key');
```

---

## Database Management

### Production Database Configuration

```sql
-- MySQL configuration for production
[mysqld]
innodb_buffer_pool_size = 2G
innodb_log_file_size = 512M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT

# Character set
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# Performance
query_cache_type = 1
query_cache_size = 256M
tmp_table_size = 256M
max_heap_table_size = 256M

# Connections
max_connections = 200
```

### Database Backup Strategy

```bash
#!/bin/bash
# scripts/backup-database.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/hausarzt"
DB_NAME="hausarzt_production"
DB_USER="hausarzt_prod_user"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump \
    --user=$DB_USER \
    --password \
    --single-transaction \
    --routines \
    --triggers \
    $DB_NAME > $BACKUP_DIR/hausarzt_db_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/hausarzt_db_$DATE.sql

# Remove backups older than 30 days
find $BACKUP_DIR -name "hausarzt_db_*.sql.gz" -mtime +30 -delete

echo "Backup completed: hausarzt_db_$DATE.sql.gz"
```

### Migration Commands

```bash
# Production migration (with backup)
php artisan down --message="Database maintenance in progress"
php artisan backup:run
php artisan migrate --force
php artisan up

# Rollback (if needed)
php artisan migrate:rollback --step=1

# Fresh installation
php artisan migrate:fresh --seed --force
```

---

## Caching Configuration

### Redis Configuration

```
# /etc/redis/redis.conf
maxmemory 2gb
maxmemory-policy allkeys-lru
save 900 1
save 300 10
save 60 10000

# Security
requirepass redis-production-password
rename-command FLUSHDB ""
rename-command FLUSHALL ""
```

### Cache Configuration

```php
// config/cache.php
'stores' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
    ],
],

'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache'),
```

### Response Cache Configuration

```php
// config/responsecache.php
'enabled' => env('RESPONSE_CACHE_ENABLED', true),
'cache_time_in_minutes' => 60 * 24, // 24 hours
'cache_profile' => \App\Http\CacheProfiles\MedicalWebsiteCacheProfile::class,
'serializer' => \Spatie\ResponseCache\Serializers\DefaultSerializer::class,
```

---

## Security Configuration

### Security Headers Implementation

```php
// app/Http/Middleware/SecurityHeaders.php
private function getSecurityHeaders(): array
{
    return [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'DENY',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        'Content-Security-Policy' => $this->getCSPHeader(),
    ];
}

private function getCSPHeader(): string
{
    return "default-src 'self'; " .
           "script-src 'self' 'unsafe-inline'; " .
           "style-src 'self' 'unsafe-inline'; " .
           "img-src 'self' data: https:; " .
           "font-src 'self'; " .
           "connect-src 'self'; " .
           "media-src 'self'; " .
           "frame-src 'none';";
}
```

### SSL/TLS Configuration

```bash
# Let's Encrypt SSL certificate
sudo certbot --nginx -d hausarzt-praxis.de -d www.hausarzt-praxis.de

# Auto-renewal cron job
0 12 * * * /usr/bin/certbot renew --quiet
```

### Security Monitoring

```bash
# Security audit commands
composer audit
npm audit
php artisan route:list --method=POST # Review POST routes

# Log monitoring
tail -f storage/logs/laravel.log | grep -i "error\|warning\|critical"
```

---

## Monitoring & Logging

### Application Monitoring

```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'medical'],
        'ignore_exceptions' => false,
    ],
    
    'medical' => [
        'driver' => 'single',
        'path' => storage_path('logs/medical.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'formatter' => \App\Logging\MedicalFormatter::class,
    ],
],
```

### Performance Monitoring

```bash
# Monitor application performance
php artisan telescope:install
php artisan migrate

# Monitor database queries
DB::enableQueryLog();
// ... run operations
dd(DB::getQueryLog());

# Monitor cache performance
redis-cli monitor
```

### Error Tracking with Sentry

```bash
# Install Sentry
composer require sentry/sentry-laravel

# Configure
php artisan sentry:publish --dsn=https://your-sentry-dsn

# Test
php artisan sentry:test
```

---

## Backup & Recovery

### Automated Backup Script

```bash
#!/bin/bash
# scripts/backup-all.sh

set -e

BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_BASE="/var/backups/hausarzt"
APP_PATH="/var/www/hausarzt-praxis.de"

echo "🔄 Starting backup process: $BACKUP_DATE"

# Create backup directories
mkdir -p "$BACKUP_BASE/database"
mkdir -p "$BACKUP_BASE/files"
mkdir -p "$BACKUP_BASE/config"

# Database backup
echo "📊 Backing up database..."
mysqldump --user=hausarzt_prod_user --password --single-transaction hausarzt_production \
    | gzip > "$BACKUP_BASE/database/db_$BACKUP_DATE.sql.gz"

# File backup (excluding cache and logs)
echo "📁 Backing up application files..."
tar --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='node_modules' \
    --exclude='vendor' \
    -czf "$BACKUP_BASE/files/app_$BACKUP_DATE.tar.gz" \
    -C "$(dirname $APP_PATH)" "$(basename $APP_PATH)"

# Configuration backup
echo "⚙️ Backing up configuration..."
cp "$APP_PATH/.env" "$BACKUP_BASE/config/env_$BACKUP_DATE"
cp -r /etc/nginx/sites-available "$BACKUP_BASE/config/nginx_$BACKUP_DATE"

# Cleanup old backups (keep 7 days)
find "$BACKUP_BASE" -type f -mtime +7 -delete

echo "✅ Backup completed: $BACKUP_DATE"
```

### Recovery Procedures

```bash
# Database recovery
gunzip -c /var/backups/hausarzt/database/db_20241220_120000.sql.gz | \
    mysql -u hausarzt_prod_user -p hausarzt_production

# Application recovery
cd /var/www
tar -xzf /var/backups/hausarzt/files/app_20241220_120000.tar.gz
chown -R www-data:www-data hausarzt-praxis.de

# Configuration recovery
cp /var/backups/hausarzt/config/env_20241220_120000 /var/www/hausarzt-praxis.de/.env
```

---

## Maintenance & Updates

### Update Procedure

```bash
#!/bin/bash
# scripts/update-production.sh

set -e

echo "🔄 Starting production update..."

# 1. Enable maintenance mode
php artisan down --message="System update in progress"

# 2. Backup before update
./scripts/backup-all.sh

# 3. Pull latest code
git pull origin main

# 4. Update dependencies
composer install --optimize-autoloader --no-dev
npm ci --production

# 5. Run migrations
php artisan migrate --force

# 6. Clear and rebuild caches
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Build assets
npm run build

# 8. Warm caches
php artisan cache:warm --force

# 9. Test critical functionality
php artisan tinker --execute="echo 'Application test: ' . app()->version();"

# 10. Disable maintenance mode
php artisan up

echo "✅ Production update completed successfully"
```

### Health Check Script

```bash
#!/bin/bash
# scripts/health-check.sh

# Check application status
curl -f http://localhost/health || exit 1

# Check database connection
php artisan tinker --execute="DB::connection()->getPdo();" || exit 1

# Check cache connection
php artisan tinker --execute="Cache::store('redis')->put('health_check', 'ok', 10);" || exit 1

# Check log file permissions
test -w storage/logs/laravel.log || exit 1

echo "✅ All health checks passed"
```

---

This comprehensive deployment and configuration guide provides all necessary information for setting up, deploying, and maintaining the Modern Hausarzt Website in production environments.