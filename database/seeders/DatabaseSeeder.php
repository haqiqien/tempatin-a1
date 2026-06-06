<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent seed: users
        $admin = User::updateOrCreate(
            ['email' => 'admin@tempatin.id'],
            [
                'full_name' => 'Admin Tempatin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        $demo = User::updateOrCreate(
            ['email' => 'user@tempatin.id'],
            [
                'full_name' => 'Pengguna Demo',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        $user1 = User::updateOrCreate(
            ['email' => 'user1@tempatin.id'],
            [
                'full_name' => 'Pengguna Satu',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'user2@tempatin.id'],
            [
                'full_name' => 'Pengguna Dua',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        // Partners (create users then partner records)
        $partnerUser1 = User::updateOrCreate(
            ['email' => 'partner1@tempatin.id'],
            [
                'full_name' => 'Mitra Kopi Keren',
                'password' => Hash::make('password'),
                'role' => 'partner',
                'status' => 'active',
            ]
        );

        Partner::updateOrCreate(
            ['user_id' => $partnerUser1->user_id],
            [
                'business_name' => 'Kopi Keren',
                'contact_name' => 'Andi',
                'contact_phone' => '081200000001',
                'status' => 'active',
            ]
        );

        $partnerUser2 = User::updateOrCreate(
            ['email' => 'partner2@tempatin.id'],
            [
                'full_name' => 'Mitra Ruang Santai',
                'password' => Hash::make('password'),
                'role' => 'partner',
                'status' => 'active',
            ]
        );

        Partner::updateOrCreate(
            ['user_id' => $partnerUser2->user_id],
            [
                'business_name' => 'Ruang Santai',
                'contact_name' => 'Budi',
                'contact_phone' => '081200000002',
                'status' => 'active',
            ]
        );

        $this->call([
            AppSettingSeeder::class,
            FacilitySeeder::class,
            PlaceSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
