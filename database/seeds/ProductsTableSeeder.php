<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Agua 620Ml $2.000',
            'price' => 2000
        ]);

        DB::table('products')->insert([
            'name' => 'Agua Litro $2.500',
            'price' => 2500
        ]);

        DB::table('products')->insert([
            'name' => 'Agua Brisa $2.500',
            'price' => 2500
        ]);

        DB::table('products')->insert([
            'name' => 'Exporade $2.000',
            'price' => 2000
        ]);

        DB::table('products')->insert([
            'name' => 'Powerade $2.500',
            'price' => 2500
        ]);

        DB::table('products')->insert([
            'name' => 'Clase de Zumba ($3.000)',
            'price' => 3000
        ]);

        DB::table('products')->insert([
            'name' => 'Entrenamiento Grupos ($4.000)',
            'price' => 4000
        ]);

        DB::table('products')->insert([
            'name' => 'Entrenamiento ($6.000)',
            'price' => 6000
        ]);

        DB::table('products')->insert([
            'name' => 'Entrenamiento Descuento ($5.000)',
            'price' => 5000
        ]);

        DB::table('products')->insert([
            'name' => 'QuemaGrass $1.500',
            'price' => 1500
        ]);

        DB::table('products')->insert([
            'name' => 'Fat Cero $2.000',
            'price' => 2000
        ]);

        DB::table('products')->insert([
            'name' => 'Mass Evolucion $2.000',
            'price' => 2000
        ]);

        DB::table('products')->insert([
            'name' => 'Pumt Nox $5.000',
            'price' => 5000
        ]);

        DB::table('products')->insert([
            'name' => 'Amio Stack $5.000',
            'price' => 5000
        ]);

        DB::table('products')->insert([
            'name' => 'Whypure $5.000',
            'price' => 5000
        ]);

        DB::table('products')->insert([
            'name' => 'Guantes para manos $15.000',
            'price' => 15000
        ]);

        DB::table('products')->insert([
            'name' => 'Cinturilla $60.000',
            'price' => 60000
        ]);

        DB::table('products')->insert([
            'name' => 'Puro combustible $6.500',
            'price' => 6500
        ]);

        DB::table('products')->insert([
            'name' => 'Bocadillo $500',
            'price' => 500
        ]);

        DB::table('products')->insert([
            'name' => 'HYDROTECH $1.500',
            'price' => 1500
        ]);

        DB::table('products')->insert([
            'name' => 'Bolsa de Maní $2.000',
            'price' => 2000,
        ]);

        DB::table('products')->insert([
            'name' => 'Titatium $6.000',
            'price' => 6000
        ]);

        DB::table('products')->insert([
            'name' => 'Toalla $2.500',
            'price' => 2500
        ]);

        DB::table('products')->insert([
            'name' => 'Calleras $15.000',
            'price' => 15000
        ]);

        DB::table('products')->insert([
            'name' => 'Barra Goin Energía $5.000',
            'price' => 5000
        ]);
    }
}
