<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ExpenseCategoriesTableSeeder::class);
        $this->call( MembershipsTableSeeder::class);
        $this->call( CustomersTableSeeder::class);
        $this->call( CustomerMembershipsTableSeeder::class);
    }
}
