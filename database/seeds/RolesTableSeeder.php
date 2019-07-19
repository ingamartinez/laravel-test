<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    private $roles;

    public function __construct()
    {
        $this->roles = collect(['root','admin']);
    }

    /**
     * Run the database seeds.
     *
     * @param Carbon $date
     * @return void
     */
    public function run(Carbon $date)
    {
        $this->roles->each(function ($role) use ($date){
            DB::table('roles')->insert([
                'name' => $role,
                'created_at' => $date->now(),
                'updated_at' => $date->now()
            ]);
        });
    }
}
