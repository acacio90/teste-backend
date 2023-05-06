<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;
    

    public function definition()
    {
        return [
            'student_id' => 1,
            'book_id' => 1,
            'loan_date' => $this->faker->dateTime(),
            'return_date' => $this->faker->dateTime()
        ];  
    }
}