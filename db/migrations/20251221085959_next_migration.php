<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NextMigration extends AbstractMigration
{
public function up(): void
    {
        $max_count_session = 3;
        // Создание таблицы sessions_table
        $this->execute("
            DROP TABLE IF EXISTS users CASCADE;
            DROP TABLE IF EXISTS user_roles CASCADE;
            DROP TABLE IF EXISTS sessions_table CASCADE;

            CREATE TABLE roles (
                id SERIAL PRIMARY KEY,
                name VARCHAR(30) NOT NULL DEFAULT 'N/A'
            );

            CREATE TABLE users (
                id SERIAL PRIMARY KEY,
                role_id INTEGER NOT NULL REFERENCES roles(id),
                email VARCHAR(255) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                full_name VARCHAR(150)
            );

            CREATE TABLE order_statuses (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE
            );

            CREATE TABLE products (
                id SERIAL PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                description TEXT,
                price NUMERIC(10,2) NOT NULL,
                stock INTEGER NOT NULL DEFAULT 0,
                image BYTEA NULL DEFAULT NULL
            );

            CREATE TABLE orders (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id),
                status_id INTEGER NOT NULL REFERENCES order_statuses(id),
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP,
                total_price NUMERIC(10,2) NOT NULL DEFAULT 0
            );

            CREATE TABLE order_items (
                id SERIAL PRIMARY KEY,
                order_id INTEGER NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
                product_id INTEGER NOT NULL REFERENCES products(id),
                quantity INTEGER NOT NULL CHECK (quantity > 0),
                price_snapshot NUMERIC(10,2) NOT NULL
            );

            CREATE TABLE sessions (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                token VARCHAR(255) NOT NULL UNIQUE,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                last_activity TIMESTAMP,
                expires_at TIMESTAMP NOT NULL,
                ip_address VARCHAR(50),
                user_agent TEXT,
                revoked BOOLEAN NOT NULL DEFAULT FALSE
            );

            CREATE TABLE payment_methods (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE
            );

            CREATE TABLE payment_statuses (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE
            );

            CREATE TABLE payments (
                id SERIAL PRIMARY KEY,
                order_id INTEGER NOT NULL REFERENCES orders(id),
                method_id INTEGER NOT NULL REFERENCES payment_methods(id),
                status_id INTEGER NOT NULL REFERENCES payment_statuses(id),
                amount NUMERIC(10,2) NOT NULL,
                transaction_id VARCHAR(100),
                error_message TEXT
            );
        ");
    }

    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS order_items CASCADE;
DROP TABLE IF EXISTS payments CASCADE;
DROP TABLE IF EXISTS delivery_info CASCADE;
DROP TABLE IF EXISTS orders CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS products CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS suppliers CASCADE;
DROP TABLE IF EXISTS brands CASCADE;
DROP TABLE IF EXISTS payment_statuses CASCADE;
DROP TABLE IF EXISTS payment_methods CASCADE;
DROP TABLE IF EXISTS order_statuses CASCADE;
DROP TABLE IF EXISTS roles;");
    }
}
