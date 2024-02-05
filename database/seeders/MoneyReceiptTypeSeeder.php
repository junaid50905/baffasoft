<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoneyReceiptTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('money_receipt_types')->delete();
        DB::table('money_receipt_types')->insert([
                ['code' => 'new_membership', 'name' => 'New Membership'],
                ['code' => 'membership_annual_subscription', 'name' => 'Membership Annual Subscription'],
                ['code' => 'id_card', 'name' => 'ID Card'],
                ['code' => 'shed_rent', 'name' => 'Shed Rent Inddor/Outdoor'],
                ['code' => 'dgr_training', 'name' => 'DGR Training'],
                ['code' => 'advertisement', 'name' => 'Advertisement'],
                ['code' => 'gate_pass', 'name' => 'Gate Pass / Amend'],
                ['code' => 'others', 'name' => 'Others']
        ]);
    }
}
