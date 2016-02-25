<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() 
    {
	
    	Model::unguard();

        $this->call(ClientTableSeeder::class);
		$this->call(UserTableSeeder::class);
		$this->call(ProjectTableSeeder::class);
		$this->call(ProjectNoteTableSeeder::class);
		$this->call(ProjectTaskTableSeeder::class);
		$this->call(OAuthClientSeeder::class);

		Model::reguard();
	}
}
