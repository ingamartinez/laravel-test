<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Carbon $date
     * @return void
     */
    public function run(Carbon $date)
    {
        for($i=1; $i<=$this->getUsersCount(); $i++){
            $user = $i;
            $role = $i == 1 ? 1 : 2;

            $this->createUserRole($user, $role, $date);

        }

    }

    private function getUsersCount(){
        return User::count();
    }

    private function createUserRole($user, $role, Carbon $date){
        DB::table('users_roles')->insert([
            'user_id' => $user,
            'role_id' => $role,
            'created_at' => $date->now(),
            'updated_at' => $date->now()
        ]);
    }

    private function craftUserRole(){

    }
}
