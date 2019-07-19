<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserByRoleEloquent(Request $request){
        return response()->json(User::with('roles')->get());
    }

    public function getUserByRoleQueryBuilder(Request $request){
        return response()->json(User::with('roles')->get());
    }
}
