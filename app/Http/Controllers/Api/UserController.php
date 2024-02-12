<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\Handler;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */  
     public function index()
    //For get the active data use $flag in index($flag)
    //Then use the 2
    {
        //1.For getting All Data From Users Table. Use this $data variable
        $data = User::latest()->get();

        //if flag is 0 (Active)
        //if Flag is 1 (All)
        //2.For getting Specific Data From Users Table use this.
        // $data = User::select('email', 'name' , 'pincode' , 'address' )->where('status' , 1)->get();
        
        //If count condition.
        if (count($data) > 0) //If data is grater than 0.
        {
            //Then return this json value from database.
            return response()->json([
                'success' => true,
                'message' => 'Data Retrived Succesfully',
                'data' => count($data) . " Users Found",
                'users' => $data,
            ], 200);
        }
        else
        { //If not data is greater than 0 ,Then return custom message in json.
            return response()->json([
                'success' => False,
                'message' => 'The Database has no data.Try to post some users then try again.THank You.',
            ], 400);
        }
        //Returning the json value normal way.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validating the requested all data by validator.
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'pincode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // assuming a minimum length of 6 characters for the password
        ]);

        //If the validator fails condition.
        if ($validator->fails()) {
            //If the validator fails then it will return this error.
            return response()->json(['errors' => $validator->errors()], 422); 
        }else{ //If the validator not fails else condition.

            //Get all validated data.
            $data = $request->all();
            //Telling database there is a transiction starting.
            DB::beginTransaction();
            //Try means if data is creating.
             try{
                //Data is creating in $data variable.
                $user = User::create($data);
                //Telling the database that a data is created.
                DB::commit();
             }  
             //catch means if data is not created.
            catch (\Exception $e) {
                //users cant see the runtime error thats why we use this execption message.
                //p($e->getMessage());

                //Get back to same page.
                DB::rollBack();

                //Condition apply for null value stored in user variable.
                $user = null;
            }
            //If the user variable is not in null condition.
            if ($user != null) {
                //Then show this success message.
                return response()->json(['message' => 'User Stored Successfully'], 200);
            }else{
                // Return an error response to a user custom error message.
                return response()->json(['error' => 'Internel Server Error'], 500);
            }
        }
    }
    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        //Findind the specific user id in users table
        $user = User::find($id);
        //If the id not found condition
        if (!$user) 
        {
            //return this by json
            return response()->json(['error' => 'User Nto Found. Enter a valid id'], 500);
        }
        //If the id found else condition
        else{
            //return the user details by json
            return response()->json([
                'success' => true,
                'message' => 'Data Retrived Succesfully',
                'users' => $user,
            ], 200);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Find the user by ID.
    $user = User::find($id);

    // If the user with the given ID is not found.
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Validate the provided data against specific rules.
    $validator = Validator::make($request->all(), [
        'name' => 'string|max:255',
        'contact' => 'string|max:20',
        'pincode' => 'string|max:10',
        'address' => 'string|max:255',
        'email' => 'string|email|max:255|unique:users,email,'.$id,
        'password' => 'string|min:8', // assuming a minimum length of 8 characters for the password
    ]);

    // If the validation fails condition.
    if ($validator->fails()) {
        // Return validation errors.
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Check if any data is provided for updating, excluding 'password'.
    if (!$request->hasAny(['name', 'contact', 'pincode', 'address', 'email', 'password'])) {
        return response()->json(['error' => 'At least one field must be updated'], 422);
    }else{
          //Telling database there is a transiction starting.
          DB::beginTransaction();
          try {
          $user->update($request->all());
          DB::commit();
          return response()->json(['message' => 'User updated successfully'], 200);
          } catch (\Exception $e) {
          // Rollback transaction on error.
          DB::rollBack();
          return response()->json(['error' => 'Internal Server Error,Data cant update'], 500);
          }
    }
    
    // Check the old password is match
    if ($user->password == $request['old_password']) {
        // Then the new password and confirm password match
        if ($request['new_password'] == $request['confirm_password']) {

            $user->password = $request['new_password'];
            //save the new password
            $user->save();
            return response()->json(['message' => 'Password updated successfully'], 200);
        } else {
            return response()->json(['error' => 'New password and confirm password do not match'], 400);
            // Use 400 Bad Request for client-side errors
        }
    }
      
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Findind the specific user id in users table
       $user = User::find($id);
       //If the user found condition
       if ($user) {
        //delete the user
        $user->delete();
        //response a json value
        return response()->json([
            'success' => true,
            'message' => 'User Deleted Succesfully',
        ], 200);
       }
       //if user id not found
       else
       {
        //response a error json value
        return response()->json([
            'success' => false,
            'message' => 'Error! Can"t delete.Try a valid user id.',
        ], 422);
       }
    }
}
