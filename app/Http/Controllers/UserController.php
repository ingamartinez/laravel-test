<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\AppHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    use AppHelpers;

    public function getUserByRoleEloquent(Request $request)
    {
        $users = User::
            whereHas('roles', function ($query) use ($request) {
                $query->whereName($request->input('role'));
            })
            ->with(['roles' => function ($query) use ($request) {
                $query->whereName($request->input('role'));
            }])
        ->get();
        return $this->returnSuccess("Success", $users);
    }

    public function getUserByRoleQueryBuilder(Request $request)
    {
        return $this->returnSuccess("Success", $this->transformRoles($this->getQueryBuilder($request->input('role'))));
    }

    public function getQueryBuilder($role)
    {
        return DB::table('users')
            ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->join('roles', 'roles.id', '=', 'users_roles.role_id')
            ->where('roles.name', '=', $role)
            ->select('users.*', 'roles.id as role_id', 'roles.name as role_name', 'roles.created_at as role_created_at', 'roles.updated_at as role_updated_at')
        ->get();
    }

    private function transformRoles($users)
    {
        $newCollection = [];

        foreach ($users as $key => $user) {
            $newCollection[$user->id]['id'] = $user->id;
            $newCollection[$user->id]['firstname'] = $user->firstname;
            $newCollection[$user->id]['lastname'] = $user->lastname;
            $newCollection[$user->id]['created_at'] = $user->created_at;
            $newCollection[$user->id]['updated_at'] = $user->updated_at;
            $newCollection[$user->id]['roles'][] = [
                'id' => $user->role_id,
                'name' => $user->role_name,
                'created_at' => $user->role_created_at,
                'updated_at' => $user->role_updated_at,
            ];
        }
        return array_values($newCollection);
    }
}
