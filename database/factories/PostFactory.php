<?php

namespace Database\Factories;

use App\Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'author' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'tags' => '',
            'image' => '{"thumb":"origin","id":"2","path":"2020/06/login-bg.jpg"}',
            'is_active' => 1,
        ];
    }
}
