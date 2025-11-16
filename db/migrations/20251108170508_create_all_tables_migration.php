<?php

declare(strict_types=1);

use Phinx\Db\Adapter\PostgresAdapter;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateAllTablesMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $user_roles_table = $this->table('user_roles', [
            'id' => false, 
            'primary_key' => 'id']);
        if (!$user_roles_table->exists()) {
            $user_roles_table->addColumn((new Column())
                ->setName('id')
                ->setType(PostgresAdapter::PHINX_TYPE_SMALL_INTEGER) //id
                ->setOptions([
                    "signed" => false])) 
                ->addColumn((new Column())
                    ->setName("name")
                    ->setType(PostgresAdapter::PHINX_TYPE_STRING)
                    ->setOptions(["limit" => 24, "null" => false]))
                ->addIndex(["name"], ['unique' => true]) //name
                ->create();
        }
        $user_roles_table->insert([
            ["id" => 0, "name" => "user"],
            ["id" => 1, "name" => "employee"],
            ["id" => 2, "name" => "admin"]
        ])->save();
        $user_table = $this->table('users', [
            'id' => false, 
            'primary_key' => 'id']);
        if (!$user_table->exists()) {
            $user_table->addColumn((new Column())
                    ->setName("id")
                    ->setType(PostgresAdapter::PHINX_TYPE_BIG_INTEGER)
                    ->setOptions([
                        "signed" => false])) // id
                ->addColumn((new Column())
                    ->setName("email")
                    ->setType(PostgresAdapter::PHINX_TYPE_STRING)
                    ->setOptions(["limit" => 254])) // email
                ->addColumn((new Column())
                    ->setName("password_hash")
                    ->setType(PostgresAdapter::PHINX_TYPE_STRING)
                    ->setOptions(["limit" => 64])) // password_hash
                ->addColumn((new Column())
                    ->setName("role_id")
                    ->setType(PostgresAdapter::PHINX_TYPE_SMALL_INTEGER)
                    ->setOptions(["null" => false, "default" => 0])) 
                ->addForeignKey("role_id", "user_roles", "id", ["delete" => "SET 0","update" => "NO_ACTION"])//role
                ->create();
            }   
        }
}
