<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Invitation;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Define Category Names
        $categoryNames = ['Rent', 'Groceries', 'Utilities', 'Internet', 'Houseware', 'Others'];

        // 2. Create Colocations
        Colocation::factory(3)->create()->each(function ($colocation) use ($categoryNames) {
            
            // 3. Create Categories for this Colocation
            $categories = collect();
            foreach ($categoryNames as $name) {
                $categories->push(Category::factory()->create([
                    'name' => $name,
                    'colocation_id' => $colocation->id
                ]));
            }

            // 4. Create Users for each Colocation
            $owner = User::factory()->create();
            $colocation->users()->attach($owner, ['role' => 'owner', 'joined_at' => now()]);
            Profile::factory()->create(['user_id' => $owner->id]);

            $members = User::factory(3)->create();
            $members->each(function($u) use ($colocation) {
                $colocation->users()->attach($u, ['role' => 'member', 'joined_at' => now()]);
                Profile::factory()->create(['user_id' => $u->id]);
            });

            $allUsers = $members->concat([$owner]);

            // 5. Create Expenses
            Expense::factory(5)->create([
                'colocation_id' => $colocation->id,
                'payer_id' => $allUsers->random()->id,
                'category_id' => $categories->random()->id,
            ])->each(function ($expense) use ($allUsers) {
                // 6. Create Debts for each expense
                $debtors = $allUsers->where('id', '!=', $expense->payer_id);
                $count = $debtors->count();
                if ($count > 0) {
                    $debtAmount = $expense->amount / ($count + 1);
                    foreach ($debtors as $debtor) {
                        Debt::factory()->create([
                            'expense_id' => $expense->id,
                            'debtor_id' => $debtor->id,
                            'amount' => $debtAmount,
                            'paid' => fake()->boolean(),
                        ]);
                    }
                }
            });

            // 7. Create Invitations
            Invitation::factory(2)->create([
                'colocation_id' => $colocation->id,
            ]);
        });

        // Create an admin user
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Support',
            'email' => 'admin@easycoloc.com',
        ]);
        // Note: Admin in this app might not be in a colocation, or could be owner/member of a special one.
    }
}
