<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Master Admin', 'Admin', 'Guest'];

        foreach ($roles as $role) {
            $r = new Role;
            $r->name =  $role;
            $r->save();
        }
    }
}
