<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CodeMigration extends AbstractMigration
{
	public function up(): void
	{
		$this->execute("
			create table email_verification_codes (
				id serial primary key not null,
				email varchar(254) check (email ~* '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$') unique,
				code char(6) not null,
				created_at timestamp with time zone not null default current_timestamp,
				expires_at timestamp with time zone not null
			);
        ");
	}

	public function down(): void
	{
		$this->execute("drop table if exists phone_verification_codes;");
	}
}
