FROM php:8.2-fpm

# Cài đặt các system dependencies cần thiết
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libjpeg62-turbo-dev \
    libfreetype6-dev

# Xóa cache của apt để giảm dung lượng image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài đặt các PHP extensions phổ biến cho Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài đặt extension Redis (Quan trọng để chạy Queue và Caching mượt mà)
RUN pecl install redis && docker-php-ext-enable redis

# Lấy Composer phiên bản mới nhất
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Phân quyền cho user www-data (user mặc định của php-fpm)
# Điều này giúp tránh lỗi không ghi được file vào folder storage/cache
RUN chown -R www-data:www-data /var/www/html

# Switch sang user www-data để an toàn hơn (Bảo mật)
USER www-data

# Port mặc định của php-fpm là 9000
EXPOSE 9000

CMD ["php-fpm"]
