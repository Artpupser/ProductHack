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

            create table if not exists roles (
               id serial primary key,
               name varchar(30) not null default 'N/A'
            );

            create table if not exists users (
                id serial primary key,
                role_id int not null references roles(id),
                email varchar(254) check (email ~* '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$') unique,
                password_hash varchar(255) not null,
                full_name varchar(150)
            );

            create table if not exists products (
                id serial primary key,
                name varchar(150) not null,
                description TEXT,
                price numeric(10,2) not null,
                stock int not null default 0
            );

            create table if not exists order_statuses (
                id serial primary key,
                name varchar(16) not null unique
            );

            create table if not exists orders (
					id serial primary key,
					user_id int not null references users(id),
					status_id int not null default 2 references order_statuses(id),
					created_at timestamp not null default current_timestamp,
					updated_at timestamp not null default current_timestamp,
					total_price numeric(10,2) not null default 0
            );

            create table if not exists order_items (
					id serial primary key,
					order_id int not null references orders(id) on delete cascade,
					product_id int not null references products(id),
					amount int not null check (amount > 0),
					price_snapshot numeric(10,2) not null
            );

            create table if not exists sessions (
					id serial primary key,
					user_id int not null references users(id) on delete cascade,
					token varchar(255) not null unique,
					created_at timestamp not null default current_timestamp,
					expires_at timestamp not null
            );

            create table if not exists payment_statuses (
					id serial primary key,
					name varchar(8) not null unique
            );

            create table if not exists payments (
					id serial primary key,
					order_id int not null references orders(id),
					status_id int not null references payment_statuses(id),
					amount numeric(10,2) not null,
					transaction_id varchar(128)
            );

				insert into roles (id, name) values
				(1,'user'),
				(2,'admin')
				on conflict (id) do nothing;

				insert into order_statuses (id, name) values
				(1, 'cancel'),
				(2, 'created'),
				(3, 'process'),
				(4, 'completed')
				on conflict (id) do nothing;

				insert into payment_statuses (id, name) values
				(1, 'ok'),
				(2, 'cancel'),
				(3, 'error')
				on conflict (id) do nothing;
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
