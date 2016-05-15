<?php
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeProject\Entities\User::class, 9)->create();

        factory(\CodeProject\Entities\User::class)->create([
            'name' => 'Maicon Marioto',
            'email' => 'maicon@maicon.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ]);

    }
}
