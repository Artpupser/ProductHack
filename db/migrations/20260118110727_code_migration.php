<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CodeMigration extends AbstractMigration
{
	public function up(): void
	{
		$this->execute("
			create table phone_verification_codes (
				id serial primary key not null,
				phone_number varchar(20) check (phone_number ~ '^\+[1-9][0-9]{0,15}$') not null,
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
