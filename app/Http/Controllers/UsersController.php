<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::query()
                ->when(request('query'), function ($query, $searchQuery) {
                    $query->where('name', 'like', "%{$searchQuery}%");
                })->latest()->get();
        $users = $users->map(function ($user) {
            return [
                'id' => $user->id ?? null,
                'name' => $user->name ?? null,
                'email' => $user->email ?? null,
                'created_at' => $user->created_at->format(config('app.date_format')) ?? null,
            ];
        });
        return $this->response(200,'users list',$users);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validation->fails()) {
            return $this->response(422, $validation->messages(),null);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return $this->response(200,'user created',$user);
    }

    public function update(Request $request,$user)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|unique:users,email,'.$user,
            'password' => 'string|min:8',
        ]);
        if ($validation->fails()) {
            return $this->response(422, $validation->messages(),null);
        }
        $user = User::find($user);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password ? $request->password : $user->password;
        $user->update();
        return $this->response(200,'user updated',$user);
    }

    public function destroy($user)
    {
        $user = User::find($user);
        $user->delete();
        return $this->response(200,'user deleted',null);
    }

    public function bulkDelete(Request $request)
    {
        // dd($request->ids);
        $user = User::whereIn('id',$request->ids)->delete();
        return $this->response(200,'seleted user deleted',null);
    }

}
