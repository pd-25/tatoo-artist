<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('loginUser')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'msg' => 'Artist logged in successfully',
                    'data' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'These credentials do not match our records.'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'msg' => $th->getMessage()
            ]);
        }
    }


    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'type' => $validatedData['type'],
        ]);

        $timeData = [
            "sunday_from" => "09:00",
            "sunday_to" => "17:00",
            "monday_from" => "09:00",
            "monday_to" => "17:00",
            "tuesday_from" => "09:00",
            "tuesday_to" => "17:00",
            "wednesday_from" => "09:00",
            "wednesday_to" => "17:00",
            "thrusday_from" => "09:00",
            "thrusday_to" => "17:00",
            "friday_from" => "09:00",
            "friday_to" => "17:00",
            "saterday_from" => "09:00",
            "saterday_to" => "17:00",
        ];

        //Updating default slots for registered user
        $user->timeData()->create($timeData);

        // $token = $user->createToken('loginUser')->plainTextToken;
        if($user) {
            return response()->json([
                'status' => true,
                'msg' => 'Artist Registered Successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'msg' => 'Some Error Occured!'
            ]);
        }
        
    }
}
