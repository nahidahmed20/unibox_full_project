<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $accounts = [
            ['code' => '1001', 'name' => 'Cash', 'type' => 'asset', 'status' => 1, 'is_default' => 1],
            ['code' => '1002', 'name' => 'Bank Account', 'type' => 'asset', 'status' => 1, 'is_default' => 1],
            ['code' => '1200', 'name' => 'Accounts Receivable', 'type' => 'asset', 'status' => 1, 'is_default' => 1],
            ['code' => '1300', 'name' => 'Inventory', 'type' => 'asset', 'status' => 1, 'is_default' => 1],
            
            ['code' => '2000', 'name' => 'Accounts Payable', 'type' => 'liability', 'status' => 1, 'is_default' => 1],
            ['code' => '2100', 'name' => 'Sales Tax Payable', 'type' => 'liability', 'status' => 1, 'is_default' => 1],
            
            ['code' => '3000', 'name' => 'Owners Equity', 'type' => 'equity', 'status' => 1, 'is_default' => 1],
            ['code' => '3100', 'name' => 'Retained Earnings', 'type' => 'equity', 'status' => 1, 'is_default' => 1],
            
            ['code' => '4000', 'name' => 'Sales Revenue', 'type' => 'revenue', 'status' => 1, 'is_default' => 1],
            ['code' => '4100', 'name' => 'Service Revenue', 'type' => 'revenue', 'status' => 1, 'is_default' => 1],
            
            ['code' => '5000', 'name' => 'Cost of Goods Sold', 'type' => 'expense', 'status' => 1, 'is_default' => 1],
            ['code' => '5100', 'name' => 'Salary Expense', 'type' => 'expense', 'status' => 1, 'is_default' => 1],
            ['code' => '5200', 'name' => 'Rent Expense', 'type' => 'expense', 'status' => 1, 'is_default' => 1],
            ['code' => '5300', 'name' => 'Discount Given', 'type' => 'expense', 'status' => 1, 'is_default' => 1],
        ];

        foreach ($accounts as $acc) {
            Account::firstOrCreate(['code' => $acc['code']], $acc);
        }
    }
}
