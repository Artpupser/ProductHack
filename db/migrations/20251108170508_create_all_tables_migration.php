<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAllTablesMigration extends AbstractMigration
{
	public function change(): void
	{
		$this->execute("
            create table if not exists user_roles (
    			id smallint primary key,
    			name varchar(24) not null,
    			unique(name)
			);");

		$this->execute("
            create table if not exists users (
				id bigint primary key,
				fullname varchar(255) not null,
				email varchar(254),
				password_hash varchar(64),
				role_id smallint not null default 0,
				foreign key (role_id) references user_roles(id) 
					on delete cascade 
					on update no action
			);");
	}
}
