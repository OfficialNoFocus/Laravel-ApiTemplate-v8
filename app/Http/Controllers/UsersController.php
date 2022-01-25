<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('sanctum')->user();

        return(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $user = new User();
        $user->fill($request->toArray());
        $user->password = bcrypt(request('password'));

        $user->save();
        // $user->attachRole($request->role);

        //$token = $user->createToken('ApiAuth')->plainTextToken;
        //['token' => $token],
        return($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = Auth::guard('sanctum')->user();

        $user = User::find($user);
        if($user === null)
        {
            return $this->sendError('Empty or does not exist.');
        }
        else
        {
            return $this->sendResponse(['user' => $user], 'User has been successfully pulled');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::guard('sanctum')->user();
        
        $user->fill($request->toArray());
        $user->save();

        return($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = Auth::guard('sanctum')->user();

        User::destroy($user->id);

        return('Successfully deleted.');
    }
}
