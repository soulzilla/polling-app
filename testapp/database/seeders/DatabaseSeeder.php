<?php

namespace Database\Seeders;

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
        $this->call(SurveySeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(VariantSeeder::class);
    }
}
