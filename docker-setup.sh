#!/bin/bash

# Docker setup script for AdminLTE Laravel Application
# This script helps you get started with Docker quickly

echo "🐳 Setting up AdminLTE Laravel with Docker..."

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    echo "Visit: https://docs.docker.com/get-docker/"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    echo "Visit: https://docs.docker.com/compose/install/"
    exit 1
fi

echo "✅ Docker and Docker Compose are installed"

# Create .env file for Docker if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.docker..."
    cp .env.docker .env
    echo "✅ .env file created"
else
    echo "⚠️  .env file already exists"
    read -p "Do you want to update it with Docker configuration? (y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        cp .env.docker .env
        echo "✅ .env file updated with Docker configuration"
    fi
fi

# Generate application key
echo "🔑 Generating application key..."
if [ -f .env ]; then
    # Check if APP_KEY is empty
    if ! grep -q "APP_KEY=base64:" .env; then
        # Generate a random key
        APP_KEY=$(openssl rand -base64 32)
        sed -i.bak "s/APP_KEY=/APP_KEY=base64:${APP_KEY}/" .env
        echo "✅ Application key generated"
    else
        echo "✅ Application key already exists"
    fi
fi

# Create necessary directories
echo "📁 Creating necessary directories..."
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Set permissions (for Unix systems)
if [[ "$OSTYPE" != "msys" && "$OSTYPE" != "cygwin" ]]; then
    echo "🔒 Setting permissions..."
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    echo "✅ Permissions set"
fi

echo "🚀 Building Docker containers..."
docker-compose build

echo "📦 Starting Docker containers..."
docker-compose up -d

echo "⏳ Waiting for database to be ready..."
sleep 30

echo "🗄️  Running database migrations..."
docker-compose exec app php artisan migrate --force

echo "🌱 Seeding database..."
docker-compose exec app php artisan db:seed --force

echo "🔗 Creating storage symlink..."
docker-compose exec app php artisan storage:link

echo "🧹 Clearing caches..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📋 Application URLs:"
echo "   🌐 Main Application: http://localhost:8080"
echo "   🗄️  phpMyAdmin: http://localhost:8081"
echo ""
echo "📊 Database Information:"
echo "   Host: localhost:3307"
echo "   Database: adminlte_laravel"
echo "   Username: laravel_user"
echo "   Password: laravel_password"
echo ""
echo "🔧 Useful Docker commands:"
echo "   Stop containers: docker-compose down"
echo "   View logs: docker-compose logs -f"
echo "   Access app container: docker-compose exec app bash"
echo "   Access database: docker-compose exec db mysql -u laravel_user -p adminlte_laravel"
echo ""
echo "📝 Default Admin Login:"
echo "   NIP: 196001011980031001"
echo "   Password: password"
echo ""
echo "Happy coding! 🚀"
