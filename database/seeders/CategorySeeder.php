<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Bowl',
                'slug' => 'bowl',
                'status' => 1,
                'show_at_home' =>1
            ],
            [
                'name' => 'Veggie-Burger',
                'slug' => 'veggie-burger',
                'status' => 1,
                'show_at_home' =>1
            ],
            [
                'name' => 'Veggie-Pasta',
                'slug' => 'veggie-pasta',
                'status' => 1,
                'show_at_home' =>1
            ],

        ]);
    }
}
