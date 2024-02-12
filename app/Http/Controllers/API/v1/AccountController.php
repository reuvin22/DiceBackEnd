<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\v1\Auth\RegisterRequest;
use App\Http\Requests\api\v1\UpdateRequest;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user['password'] = Hash::make($user['password']);
        if(!$user){
            return response()->failed('Failed to Create User');
        }else {
            return response()->success($user, 'User Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(empty($user)){
            return response()->failed('No User to Show');
        }else {
            return response()->success($user, 'User Fetched Successfully');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $updateId = User::find($id);
        if(empty($id)){
            return response()->failed('No User To Update');
        }
        $updateId->update($request->validated());
        if(!$updateId){
            return response()->failed('Failed to Update Data');
        }else {
            return response()->success($updateId, 'Data Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteId = User::find($id);
        if(empty($deleteId)){
            return response()->failed('No Data to Delete');
        }
        $deleteId->delete();
        if(!$deleteId){
            return response()->failed('Delete User Failed');
        }else {
            return response()->sucess('User Deleted Successfully');
        }
    }
}
