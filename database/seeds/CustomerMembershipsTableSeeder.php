<?php

use App\Client;
use App\Membership;
use App\MembershipDetail;
use Illuminate\Database\Seeder;

class CustomerMembershipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customersCsv = Storage::disk('local')->get('memberships.csv');
        $customersArray = explode("\r\n", $customersCsv);


        foreach ($customersArray as $customer) {
            $columns = explode(",", $customer);

            $customerId = Client::select('id')->whereDocument($columns[2])->get()->first()->id;
            $membership = Membership::find($columns[0]);

            MembershipDetail::create([
                'client_id' => $customerId,
                'membership_id' => $columns[0],
                'start_at' => $columns[1],
                'end_at' => $membership->getEndDate(\Carbon\Carbon::createFromFormat('Y-m-d', $columns[1]))
            ]);
        }
    }
}
