<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewFactory extends Factory
{
    use HasFactory;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "product_id" => function(){
                return Product::all()->random();
            },
            "customer" => $this->faker->name(),
            "review" => $this->faker->paragraph(),
            "star" => $this->faker->numberBetween(0,5)
        ];
    }
}
