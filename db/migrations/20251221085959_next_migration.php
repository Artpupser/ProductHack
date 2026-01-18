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
                id serial primary key,
                name varchar(30) not null default 'N/A'
            );

            create table users (
                id serial primary key,
                role_id int not null references roles(id),
                email varchar(254) check (email ~* '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$') unique,
                password_hash varchar(255) not null,
                full_name varchar(150)
            );

            create table order_statuses (
                id serial primary key,
                name varchar(100) not null unique
            );

            create table products (
                id serial primary key,
                name varchar(150) not null,
                description TEXT,
                price numeric(10,2) not null,
                stock int not null default 0,
                ids_images text not null default ''
            );

            create table orders (
                id serial primary key,
                user_id int not null references users(id),
                status_id int not null references order_statuses(id),
                created_at timestamp not null default current_timestamp,
                updated_at timestamp,
                total_price numeric(10,2) not null default 0
            );

            create table order_items (
                id serial primary key,
                order_id int not null references orders(id) on delete cascade,
                product_id int not null references products(id),
                quantity int not null check (quantity > 0),
                price_snapshot numeric(10,2) not null
            );

            create table sessions (
                id serial primary key,
                user_id int not null references users(id) on delete cascade,
                token varchar(255) not null unique,
                created_at timestamp not null default current_timestamp,
                expires_at timestamp not null,
            );

            create table payment_methods (
                id serial primary key,
                name varchar(100) not null unique
            );

            create table payment_statuses (
                id serial primary key,
                name varchar(100) not null unique
            );

            create table payments (
                id serial primary key,
                order_id int not null references orders(id),
                method_id int not null references payment_methods(id),
                status_id int not null references payment_statuses(id),
                amount numeric(10,2) not null,
                transaction_id varchar(100),
                error_message text
            );

				insert into roles (name) values
				('User'),
				('Admin')
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
