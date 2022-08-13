<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'api',
                'allow_for_public' => 0,
            ],
//            [
//                'name' => 'client_manager',
//                'guard_name' => 'api',
//                'allow_for_public' => 0,
//            ],
//            [
//                'name' => 'seo_manager',
//                'guard_name' => 'api',
//                'allow_for_public' => 0,
//            ],
//            [
//                'name' => 'content_manager',
//                'guard_name' => 'api',
//                'allow_for_public' => 0,
//            ],
//            [
//                'name' => 'customer',
//                'guard_name' => 'api',
//                'allow_for_public' => 1,
//            ],
        ];
        DB::table('roles')->insert($roles);
    }
}
