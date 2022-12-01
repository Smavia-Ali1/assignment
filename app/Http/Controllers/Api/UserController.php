<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|unique:users|max:255',
                    'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'min:8',
                ]);
                if ($validator->fails()) {
                    return response(['errors' => $validator->errors()->all()], 422);
                }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('LaravelAuthApp')->accessToken;

            $response = ["message" => 'You are Successfully Registered!', 'status' => 201, 'data' => $token];
            return response($response, 201);
        } catch (Throwable $e) {
            return response(403, 'Unauthorized action.');
        }
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 422);
            }
            if (empty($request->email)){
                $response = ["message" => "Please Enter Email"];
                return response($response, 422);
            }
            $user =  User::where(function ($q) use ($request) {
                if ($request->email) $q->where('email', '=', $request->email);
            })->first();
            if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        $token = $user->createToken('Laravel Password Grant Client')->accessToken; //'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI3IiwianRpIjoiM2Q2YjUyMzk4N2NiMzBkMjc1MjFhNDc0YWY4ODA1YTU0ZmM2NTdjNGUzZTBlMWJjOGYyNTNkZTllNDkwM2FjNzVmZmM3NzQwYzlhMTljYTAiLCJpYXQiOjE2MzY1NDE4MzguMDMyNDI1LCJuYmYiOjE2MzY1NDE4MzguMDMyNDMzLCJleHAiOjE2NjgwNzc4MzcuODc4MTc2LCJzdWIiOiI5MiIsInNjb3BlcyI6W119.kbjumLIR4cJ4cROZRzuKP6hCQ-ktHf9hcDSYEIjpMP0hy5JRUT0driaPKgCIpRqoG7cQeywRKaU1uNYiVXJjHghdxSG6T0VplJ__uIOjkraw2BTYjMS4DIu8Yu_TrF4q39bh6txIEbBq0cUm_2iDrkxFh7VY0NretGfma4goEIup5C2PAfXXqIURvpwNSIUCfIVXW-l3jhKfj__3JKUu2-lYs7hlt7NxuDjdUvnR-3mE3Hrf58kk6LUvROmGRwmgd_vzvF_i1Ok7dgiBMMYvBdZ6y9c4GOkwzeCMolVxw5zkEwGgG4pee3WqI4--ELBvnhsh5AOtJAWUy2cybg2dj0XKEReb3DdoDBZzqaT4IT72jU8jCBNRD_25hCQ4DWqrLY0jIjzvUc_zjIrppX_A4OJtWZs0APvzUOxuP-9nepn80sYS5uuES-YpYEmKeWqbB42BqBnAALAsseb35SZcvB32xEN_G0BmDzLru4rzBbAW--4OZa026JTWE4sX0VTUqDJy7XCx8TKt92vzcGjZw9hrNEWUdRmoPWPD1W6YuTL1SJ-FB4S4LWfQ77OTq0L6h7EeyCj1akzvkaYIt0xlFKC_QroDiszO_X9Ck687EdOCzAMrsJAGLXpsZtvHDqkUOX5za1VhxfRfy_zPnMDnFUwLCq9lUPpCBCYwW6YhPtQ' ; //$user->createToken('Laravel Password Grant Client')->accessToken;
                        // return view('/home', compact('token'));
                        $response = ["message" => 'You are Login!', 'status' => 201, 'data' => $token];
                        return response($response, 201);
                    } else {
                        $response = ["message" => "Password mismatch"];
                        return response($response, 422);
                    }
                } else {
                    $response = ["message" =>'User does not exist'];
                    return response($response, 422);
                }
        } catch (Throwable $e) {
            return response('Unauthorized action.', 403);
        }

    }
}
