<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $nomor = 1;
        return [
            'idcustomer' => 'CUS' . str_pad($nomor++, 4, '0', STR_PAD_LEFT),
            'nama_customer' => fake()->name(),
            'alamat_customer' => fake()->address(),
            'notelp_customer' => '08' . fake()->numerify('##########'),
        ];
    }
}
