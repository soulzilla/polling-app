<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 4; $j++) {
                $variant = new Variant();
                $variant->question_id = $i;
                $variant->title = fake()->word;
                $variant->weight = $j;
                $variant->is_published = true;
                $variant->save();
            }
        }
    }
}
