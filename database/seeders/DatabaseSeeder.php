<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\InsuranceInstitute;
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
//        \App\Models\User::factory(10)->create();
        Hospital::factory(5)->create();
        InsuranceInstitute::factory(5)->create();
    }
}
