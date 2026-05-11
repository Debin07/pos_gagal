# Gas Galon - Aplikasi Manajemen Stok Gas & Galon

Aplikasi web untuk mengelola stok gas dan galon berbasis Laravel 12 dengan Filament admin panel.

## 🚀 Fitur

- ✅ Manajemen Produk (Gas & Galon)
- ✅ Manajemen Stok & Restock
- ✅ Point of Sale (POS) System
- ✅ Manajemen Pelanggan
- ✅ Laporan Transaksi
- ✅ Admin Panel dengan Filament
- ✅ Multi-user support

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Filament 3 (Admin Panel)
- **Database**: MySQL
- **Styling**: Tailwind CSS
- **Deployment**: VPS/Cloud

## 📋 Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+
- Git

## 🔧 Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/yourusername/gas-galon.git
   cd gas-galon
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Edit .env file dengan database credentials
   php artisan migrate
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Run Application**
   ```bash
   php artisan serve
   ```

## 🌐 Deployment Options

### Opsi 1: VPS (DigitalOcean/Linode/Vultr) - RECOMMENDED

#### Setup VPS Ubuntu/Debian:

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx mysql-server php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath unzip curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Setup MySQL
sudo mysql_secure_installation

# Create database
sudo mysql -u root -p
CREATE DATABASE gas_galon;
CREATE USER 'gas_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON gas_galon.* TO 'gas_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Deploy Application:

```bash
# Clone project
cd /var/www
sudo git clone https://github.com/yourusername/gas-galon.git
cd gas-galon

# Install dependencies
sudo composer install --no-dev --optimize-autoloader
sudo npm install && sudo npm run build

# Setup environment
sudo cp .env.example .env
sudo php artisan key:generate

# Setup storage permissions
sudo chown -R www-data:www-data /var/www/gas-galon
sudo chmod -R 755 /var/www/gas-galon
sudo chmod -R 775 /var/www/gas-galon/storage
sudo chmod -R 775 /var/www/gas-galon/bootstrap/cache

# Run migrations
sudo php artisan migrate --seed
sudo php artisan storage:link
```

#### Nginx Configuration:

```bash
sudo nano /etc/nginx/sites-available/gas-galon
```

Add this configuration:
```
server {
    listen 80;
    server_name your_domain.com;
    root /var/www/gas-galon/public;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/gas-galon /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Opsi 2: Railway (Mudah & Cepat)

1. **Push ke GitHub**
   ```bash
   git add .
   git commit -m "Ready for deployment"
   git push origin main
   ```

2. **Deploy ke Railway**
   - Daftar di [Railway.app](https://railway.app)
   - Connect GitHub repository
   - Railway akan auto-detect sebagai Laravel app
   - Setup environment variables
   - Database akan dibuat otomatis

3. **Environment Variables untuk Railway:**
   ```
   APP_NAME="Gas Galon"
   APP_ENV=production
   APP_KEY=base64_key_from_artisan_key_generate
   APP_DEBUG=false
   APP_URL=https://your-app.railway.app

   DB_CONNECTION=mysql
   DB_HOST=${MYSQLHOST}
   DB_PORT=${MYSQLPORT}
   DB_DATABASE=${MYSQLDATABASE}
   DB_USERNAME=${MYSQLUSER}
   DB_PASSWORD=${MYSQLPASSWORD}
   ```

### Opsi 3: Heroku

1. **Install Heroku CLI**
   ```bash
   # Download dari https://devcenter.heroku.com/articles/heroku-cli
   ```

2. **Setup Heroku App**
   ```bash
   heroku create your-app-name
   heroku addons:create heroku:mysql
   ```

3. **Deploy**
   ```bash
   git push heroku main
   heroku run php artisan migrate
   ```

### Opsi 4: AWS/Google Cloud/Azure

Untuk production enterprise-level, gunakan:
- **AWS**: EC2 + RDS + S3
- **Google Cloud**: Compute Engine + Cloud SQL
- **Azure**: App Service + Database

## 🔐 Default Admin Account

- **Email**: admin@gasgalon.com
- **Password**: password

## 📞 Support

Jika ada pertanyaan, silakan buat issue di GitHub repository.

## 📄 License

This project is licensed under the MIT License.
