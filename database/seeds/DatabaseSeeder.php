<?php

use App\User;
use App\Transporter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //factory(User::class)->create();
        factory(Transporter::class,10)->create();
    }
}
