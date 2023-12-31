<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'alias' => 'admin',
            ],
            [
                'id' => 2,
                'name' => 'Viewer',
                'alias' => 'viewer',
            ],
        ]);
        Schema::enableForeignKeyConstraints();

    }
}
