<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CodeMigration extends AbstractMigration
{
	public function up(): void
	{
		$this->execute("
			create table if not exists email_verification_codes (
				id serial primary key not null,
				email varchar(254) check (email ~* '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$') unique,
				code char(6) not null,
				created_at timestamp with time zone not null default current_timestamp,
				expires_at timestamp with time zone not null
			);

			create or replace function public.delete_expired_session()
			returns trigger as $$
			begin
				delete from sessions
				where expires_at < current_timestamp;
				return new;
			end;
			$$ language 'plpgsql';



			");
	}

	public function down(): void
	{
		$this->execute("
		drop table if exists phone_verification_codes;
		drop trigger if exists trigger_session_changed;
		drop function if exists public.delete_expired_session();
		");
	}
}
