<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function getUserByRoleEloquent(Request $request){
        dd(User::with('roles')->getQuery());
        return response()->json(User::with('roles')->get());
    }

    public function getUserByRoleQueryBuilder(Request $request){
        dd($this->transformQueryBuilder($this->getQueryBuilder()));
        return response()->json(User::with('roles')->get());
    }

    public function getQueryBuilder(){
        return DB::table('users')
            ->join('users_roles','users.id','=','users_roles.user_id')
            ->join('roles','roles.id','=','users_roles.role_id')
            ->select('users.*','roles.id as role_id','roles.name as role_name')
            ->get();
    }

    public function transformQueryBuilder(Collection $query){
        $newQuery=$query->transform(function ($item){
            return $this->transformUser($item);
        });
        return $newQuery;
    }

    public function transformUser($user){
        $user->role = "asd";
        return $user;
//        dd($user);
    }
}
