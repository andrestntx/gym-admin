<?php

use Illuminate\Database\Seeder;

class MembershipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
            'name' => 'Estudiante Cooperativa $15.000',
            'price' => 15000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Mensualidad básica (2019) $65.000',
            'price' => 65000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Mensualidad básica $55.000',
            'price' => 55000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Mensualidad Estudiante (2019) $40.000',
            'price' => 40000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Mensualidad Pareja (2019) $60.000',
            'price' => 60000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Mensualidad Pareja $50.000',
            'price' => 50000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Mensuidad de Rumba $30.000',
            'price' => 30000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Plan Valera 15 días $40.000',
            'price' => 40000,
            'days' => 30
        ]);

        DB::table('memberships')->insert([
            'name' => 'Plan Valera 30 días $75.000',
            'price' => 75000,
            'days' => 60
        ]);

        DB::table('memberships')->insert([
            'name' => 'Promoción Plan Anual $330.000',
            'price' => 360000,
            'days' => 360
        ]);
    }
}
