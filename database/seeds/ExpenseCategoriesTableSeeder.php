<?php

use Illuminate\Database\Seeder;

class ExpenseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_categories')->insert([
            'description' => 'Pasajes'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Café'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Productos de nevera'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Clases Grupales'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Productos de venta'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Botellon Agua'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Servicios públicos'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Productos de aseo'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Implementos para el Gym'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Salario'
        ]);

        DB::table('expense_categories')->insert([
            'description' => 'Arriendo'
        ]);
    }
}
