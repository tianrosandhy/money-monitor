<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Post\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(10)->create();
    }
}
