# 🐳 Docker Configuration for AdminLTE Laravel

This directory contains Docker configuration files for running the AdminLTE Laravel application in containers.

## 📁 Files Structure

```
docker/
├── apache/
│   └── vhost.conf          # Apache virtual host configuration
├── mysql/
│   └── init.sql           # MySQL initialization script
├── Dockerfile             # Main application Docker image
├── docker-compose.yml     # Docker Compose configuration
├── .env.docker           # Environment variables for Docker
├── .dockerignore         # Docker ignore file
└── docker-setup.sh       # Automated setup script
```

## 🚀 Quick Start

### Option 1: Automated Setup (Recommended)
```bash
# Run the automated setup script
./docker-setup.sh
```

### Option 2: Manual Setup
```bash
# 1. Copy environment file
cp .env.docker .env

# 2. Generate application key
# Edit .env and set APP_KEY (or run the setup script)

# 3. Build and start containers
docker-compose up -d

# 4. Run migrations and seeders
docker-compose exec app php artisan migrate --seed

# 5. Create storage link
docker-compose exec app php artisan storage:link
```

## 🌐 Application URLs

- **Main Application**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

## 🗄️ Database Access

### From Host Machine
- **Host**: localhost
- **Port**: 3307
- **Database**: adminlte_laravel
- **Username**: laravel_user
- **Password**: laravel_password
- **Root Password**: root_password

### From Application Container
- **Host**: db
- **Port**: 3306
- **Database**: adminlte_laravel
- **Username**: laravel_user
- **Password**: laravel_password

## 📦 Services

### 1. App (Laravel Application)
- **Port**: 8080:80
- **Base Image**: PHP 8.2 with Apache
- **Features**:
  - PHP extensions (MySQL, GD, Zip, Intl, etc.)
  - Composer
  - Node.js & NPM for asset compilation
  - Apache with mod_rewrite

### 2. Database (MySQL 8.0)
- **Port**: 3307:3306
- **Persistent storage**: mysql_data volume
- **Timezone**: Asia/Jakarta (GMT+7)

### 3. phpMyAdmin
- **Port**: 8081:80
- **Features**: Web-based MySQL administration

### 4. Redis (Optional)
- **Port**: 6379:6379
- **Usage**: Caching and session storage

## 🔧 Docker Commands

### Basic Operations
```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# Restart services
docker-compose restart

# View logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f app
```

### Application Management
```bash
# Access application container
docker-compose exec app bash

# Run Artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear

# Run Composer commands
docker-compose exec app composer install
docker-compose exec app composer update

# Run NPM commands
docker-compose exec app npm install
docker-compose exec app npm run build
```

### Database Management
```bash
# Access MySQL container
docker-compose exec db bash

# Connect to MySQL
docker-compose exec db mysql -u laravel_user -p adminlte_laravel

# Backup database
docker-compose exec db mysqldump -u laravel_user -p adminlte_laravel > backup.sql

# Restore database
docker-compose exec -T db mysql -u laravel_user -p adminlte_laravel < backup.sql
```

## 🔧 Customization

### Environment Variables
Edit `.env` file to customize:
- Database credentials
- Application settings
- Mail configuration
- Redis settings

### Apache Configuration
Modify `docker/apache/vhost.conf` for:
- SSL configuration
- Additional security headers
- Custom rewrite rules

### MySQL Configuration
Edit `docker/mysql/init.sql` for:
- Initial database setup
- User permissions
- Custom configurations

## 🛠️ Development vs Production

### Development Mode
```bash
# Enable debug mode
APP_DEBUG=true
APP_ENV=local

# Use file-based cache and sessions
CACHE_DRIVER=file
SESSION_DRIVER=file
```

### Production Mode
```bash
# Disable debug mode
APP_DEBUG=false
APP_ENV=production

# Use Redis for cache and sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis

# Optimize application
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

## 🔒 Security Considerations

1. **Change default passwords** in production
2. **Use environment variables** for sensitive data
3. **Enable HTTPS** with SSL certificates
4. **Configure firewall** rules
5. **Regular updates** of base images

## 📋 Default Login

After setup, you can login with:
- **NIP**: 196001011980031001
- **Password**: password

## 🆘 Troubleshooting

### Common Issues

1. **Port conflicts**
   ```bash
   # Change ports in docker-compose.yml if needed
   ports:
     - "8081:80"  # Change 8080 to another port
   ```

2. **Permission issues**
   ```bash
   # Fix permissions (Linux/macOS)
   sudo chown -R $USER:$USER storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

3. **Database connection issues**
   ```bash
   # Wait for database to be ready
   docker-compose exec app php artisan migrate
   ```

4. **Clear all caches**
   ```bash
   docker-compose exec app php artisan config:clear
   docker-compose exec app php artisan cache:clear
   docker-compose exec app php artisan view:clear
   ```

## 📚 Additional Resources

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel Documentation](https://laravel.com/docs)
- [AdminLTE Documentation](https://adminlte.io/docs)
