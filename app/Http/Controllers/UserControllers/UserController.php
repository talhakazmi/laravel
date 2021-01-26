<?php

namespace App\Http\Controllers\UserControllers;

use App\Delivery;
use App\DeliveryRepresentative;
use App\Events\NewUserCreated;
use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\UserRequest;
use App\Shop;
use App\ShopRepresentative;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(UserFilter $filters)
    {
        $users = User::sortable()->filter($filters)->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
    	$password = Str::random(10);
        $user = User::make($request->all());
        $user->password = Hash::make($password);
        $user->save();
        $this->attachRelations($user, $request);
        event(new NewUserCreated($user, $password));
        return response()->json(['success' => 'User was added successfully']);
    }

    public function show($userID)
    {
        $user = User::with('roles')->find($userID);
        return response()->json(['user' => $user]);
    }

    public function update(UserRequest $request, $userID)
    {
        $user = User::find($userID)->fill($request->all());
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $this->attachRelations($user, $request);
        return response()->json(['success' => 'User was Updated successfully']);
    }

    public function destroy($userID){
        $user = User::find($userID);
        $user->delete();
        return response()->json(['success' => 'User was deleted successfully']);

    }

    public function getRoles(){
        $roles = Role::all();
        return response()->json($roles);
    }

    private function attachRelations($user,$request)
    {
        if (request('shops_shopID')) {
            $user->Shop()->attach(request('shops_shopID'));
        }
        if (request('deliveries_deliveryID')) {
            $user->Delivery()->attach(request('deliveries_deliveryID'));
        }
        $user->assignRole($request->type);
    }
}
