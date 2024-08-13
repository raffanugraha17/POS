<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

       $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);

        
        $this->call(BanksSeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(CashierListSeeder::class);
        $this->call(CustomerListSeeder::class);
        


    }
    
}
