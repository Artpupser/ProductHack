<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAllTablesMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS user_roles (
                id SMALLINT PRIMARY KEY,
                name VARCHAR(24) NOT NULL,
                UNIQUE(name)
            );");
        $this->execute("
            CREATE TABLE IF NOT EXISTS users (
                id BIGINT PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL,
                email VARCHAR(254),
                password_hash VARCHAR(64),
                role_id SMALLINT NOT NULL DEFAULT 0,
                FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE CASCADE ON UPDATE NO ACTION
            );");
    }
}
