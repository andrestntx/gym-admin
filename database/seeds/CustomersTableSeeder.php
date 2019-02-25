<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customersCsv = Storage::disk('local')->get('customers.csv');
        $customersArray = explode("\n", $customersCsv);

        foreach ($customersArray as $customer) {
            $columns = explode(",", $customer);

            DB::table('clients')->insert([
                'document' => $columns[0],
                'email' => $columns[1],
                'name'  => $columns[2],
                'sex' => $columns[3],
                'phone' => $columns[4],
                'address' => $columns[5],
                'birth_date' => $columns[6] != '0' ? Carbon::createFromFormat('m/d/y', $columns[6])->toDateString() : null,
                'created_at' => Carbon::createFromFormat('m/d/y H:i', $columns[7])->toDateTimeString()
            ]);
        }
    }
}
