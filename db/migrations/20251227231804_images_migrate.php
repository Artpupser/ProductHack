<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ImagesMigrate extends AbstractMigration
{
 public function up(): void
    {
        $max_count_session = 3;
        // Создание таблицы sessions_table
        $this->execute("
            CREATE TABLE IF NOT EXISTS images (
                id SERIAL PRIMARY KEY not null,
                base64 TEXT not null
            );
        ");
    }

    public function down(): void
    {
        // Удаление таблицы sessions_table
        $this->execute("
            DROP TABLE IF EXISTS images;
        ");
    }
}
