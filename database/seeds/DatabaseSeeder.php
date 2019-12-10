<?php

use App\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
		$this->call(RolesAndPermissionTableSeeder::class);

		factory(Status::class,1)->create();
    }
}
