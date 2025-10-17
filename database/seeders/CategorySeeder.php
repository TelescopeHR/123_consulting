<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create([
            'id' => 1,
            'name' => 'Subscription',
            'type' => 'Course'
        ]);

        $category->slug_relation()->updateOrCreate([], [
            'slug' => Str::slug('Subscription')
        ]);
    }
}
