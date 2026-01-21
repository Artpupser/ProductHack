<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class StartSeed extends AbstractSeed
{
    public function run(): void
    {
        $faker = Faker\Factory::create('ru_RU'); //data generator
        $faker->seed('seed');
        //user_roles_generate
        $user_roles_table = $this->table('user_roles');
        $roles_data = [
            ["id" => 0, "name" => "user"],
            ["id" => 1, "name" => "employee"],
            ["id" => 2, "name" => "admin"]
        ];
        $user_roles_table->setData($roles_data)->save();

        $user_table = $this->table('users');
        $users_data = [];
        for ($i = 0; $i < 30; $i++) {
            $users_data[$i] = [
                'id' => $i,
                'fullname' => $faker->name(),
                'email' => $faker->email(),
                'password_hash' => hash('sha256', $faker->password(10, 30)),
                'role_id' => (int) $faker->randomElement([0, 1, 2])
            ];
        }
        $user_table->insert($users_data)->save();
    }
}
