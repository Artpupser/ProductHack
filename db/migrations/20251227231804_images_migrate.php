<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ImagesMigrate extends AbstractMigration
{
	public function up(): void
	{
		$this->execute("
            create table if not exists images (
                id serial primary key not null,
				tag varchar(12) not null,
                base64 text not null
            );
        ");
	}

	public function down(): void
	{
		$this->execute("drop table if exists images;");
	}
}
