<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NextMigration extends AbstractMigration
{
	public function up(): void
	{
		$this->execute("
            drop table if exists users cascade;
            drop table if exists user_roles cascade;
            drop table if exists sessions_table cascade;

            create table roles (
                id SERIAL PRIMARY KEY,
                name VARCHAR(30) NOT NULL DEFAULT 'N/A'
            );

            create table users (
                id SERIAL PRIMARY KEY,
                role_id INTEGER NOT NULL REFERENCES roles(id),
                email VARCHAR(255) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                full_name VARCHAR(150)
            );

            create table order_statuses (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE
            );

            create table products (
                id SERIAL PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                description TEXT,
                price NUMERIC(10,2) NOT NULL,
                stock INTEGER NOT NULL DEFAULT 0,
                ids_images text not null default ''
            );

            create table orders (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id),
                status_id INTEGER NOT NULL REFERENCES order_statuses(id),
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP,
                total_price NUMERIC(10,2) NOT NULL DEFAULT 0
            );

            create table order_items (
                id SERIAL PRIMARY KEY,
                order_id INTEGER NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
                product_id INTEGER NOT NULL REFERENCES products(id),
                quantity INTEGER NOT NULL CHECK (quantity > 0),
                price_snapshot NUMERIC(10,2) NOT NULL
            );

            create table sessions (
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

            create table payment_methods (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE
            );

            create table payment_statuses (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE
            );

            create table payments (
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
		$this->execute("drop table if exists order_items cascade;
drop table if exists payments cascade;
drop table if exists delivery_info cascade;
drop table if exists orders cascade;
drop table if exists sessions cascade;
drop table if exists users cascade;
drop table if exists products cascade;
drop table if exists categories cascade;
drop table if exists suppliers cascade;
drop table if exists brands cascade;
drop table if exists payment_statuses cascade;
drop table if exists payment_methods cascade;
drop table if exists order_statuses cascade;
drop table if exists roles;");
	}
}
