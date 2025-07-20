#!/bin/bash

# Production Optimization Script for Laravel Medical Website
# This script optimizes the application for production deployment

set -e

echo "🚀 Starting production optimization..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    print_error "This script must be run from the Laravel project root directory"
    exit 1
fi

# Install dependencies
print_status "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

print_status "Installing NPM dependencies..."
npm ci

# Build assets for production
print_status "Building production assets with Vite..."
npm run build

# Laravel optimizations
print_status "Optimizing Laravel for production..."

# Clear all caches first
print_status "Clearing existing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize Laravel caches
print_status "Creating optimized caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer autoloader
print_status "Optimizing Composer autoloader..."
composer dump-autoload --optimize --classmap-authoritative

# Warm application caches
print_status "Warming application caches..."
php artisan cache:warm --force

# Set proper permissions (if running on Unix-like systems)
if [[ "$OSTYPE" == "linux-gnu"* || "$OSTYPE" == "darwin"* ]]; then
    print_status "Setting proper file permissions..."
    chmod -R 755 storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
fi

# Database optimizations
print_status "Running database migrations..."
php artisan migrate --force

# Clear and warm response cache
print_status "Warming response cache..."
php artisan responsecache:clear
# Note: Response cache will be warmed when first requests are made

# Performance validation
print_status "Validating optimization..."

# Check if critical cache files exist
if [ -f "bootstrap/cache/config.php" ]; then
    print_success "✅ Configuration cache created"
else
    print_warning "⚠️ Configuration cache not found"
fi

if [ -f "bootstrap/cache/routes-v7.php" ]; then
    print_success "✅ Route cache created"
else
    print_warning "⚠️ Route cache not found"
fi

if [ -d "storage/framework/views" ] && [ "$(ls -A storage/framework/views)" ]; then
    print_success "✅ View cache populated"
else
    print_warning "⚠️ View cache appears empty"
fi

# Check if production assets exist
if [ -d "public/build" ] && [ "$(ls -A public/build)" ]; then
    print_success "✅ Production assets built"
else
    print_warning "⚠️ Production assets not found"
fi

# Calculate and display asset sizes
if [ -d "public/build/assets" ]; then
    print_status "Asset bundle sizes:"
    
    # CSS files
    for file in public/build/assets/*.css; do
        if [ -f "$file" ]; then
            size=$(du -h "$file" | cut -f1)
            filename=$(basename "$file")
            echo "  📄 CSS: $filename - $size"
        fi
    done
    
    # JS files
    for file in public/build/assets/*.js; do
        if [ -f "$file" ]; then
            size=$(du -h "$file" | cut -f1)
            filename=$(basename "$file")
            echo "  📜 JS:  $filename - $size"
        fi
    done
fi

# Final recommendations
echo ""
print_success "🎉 Production optimization completed!"
echo ""
print_status "📋 Post-deployment checklist:"
echo "  • Ensure APP_ENV=production in .env"
echo "  • Ensure APP_DEBUG=false in .env"
echo "  • Enable RESPONSE_CACHE_ENABLED=true"
echo "  • Configure proper web server (nginx/apache)"
echo "  • Set up SSL certificate"
echo "  • Configure cache headers in web server"
echo "  • Set up monitoring and logging"
echo ""
print_status "🔧 Performance commands:"
echo "  • Clear response cache: php artisan responsecache:clear"
echo "  • Warm caches: php artisan cache:warm"
echo "  • Monitor cache: php artisan cache:warm --content"
echo ""
print_status "🏥 Your medical website is ready for production!"