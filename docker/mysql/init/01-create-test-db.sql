CREATE DATABASE IF NOT EXISTS app_laravel_test
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON app_laravel_test.* TO 'laravel'@'%';
FLUSH PRIVILEGES;

