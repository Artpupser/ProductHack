<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MigrationDatabase1 extends AbstractMigration
{
	public function up(): void
	{
		$this->execute("
            CREATE TABLE if not exists sessions_table (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NULL,
                token VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                expires_at TIMESTAMP NULL,
                ip_address INET NULL,
                user_agent VARCHAR(500) NULL,
                state VARCHAR(30) NULL,
                CONSTRAINT user_id_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ");
	}

	public function down(): void
	{
		$this->execute("
            DROP TABLE if exists sessions_table;
        ");
	}
}
