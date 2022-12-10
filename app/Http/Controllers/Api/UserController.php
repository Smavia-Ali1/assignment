<?php

namespace App\Http\Controllers\Api;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Laravel\Passport\RefreshToken;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset as EventsPasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
                    // return response(['errors' => $validator->errors()->all()], 422);
                    return response()->json(['success' =>'false', 'message' => $validator->errors()->all(), 'status' => 422]);
                }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('LaravelAuthApp')->accessToken;

            $response = ["success" => "true" , "message" => 'You are Successfully Registered!', 'status' => 201, 'data' => $token];
            return response($response, 201);
        } catch (Throwable $e) {
            // return response(403, 'Unauthorized action.');
            return response()->json(['success' =>'false', 'message' => $e->getMessage()]);
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
                return response()->json(['success' =>'false', 'message' => $validator->errors()->all(), 'status' => 422]);
            }
            if (empty($request->email)){
                $response = ["message" => "Please Enter Email"];
                // return response($response, 422);
                return response()->json(['success' =>'false', 'message' => $response]);
            }
            $user =  User::where(function ($q) use ($request) {
                if ($request->email) $q->where('email', '=', $request->email);
            })->first();
            if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        $token = $user->createToken('Laravel Password Grant Client')->accessToken; //'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI3IiwianRpIjoiM2Q2YjUyMzk4N2NiMzBkMjc1MjFhNDc0YWY4ODA1YTU0ZmM2NTdjNGUzZTBlMWJjOGYyNTNkZTllNDkwM2FjNzVmZmM3NzQwYzlhMTljYTAiLCJpYXQiOjE2MzY1NDE4MzguMDMyNDI1LCJuYmYiOjE2MzY1NDE4MzguMDMyNDMzLCJleHAiOjE2NjgwNzc4MzcuODc4MTc2LCJzdWIiOiI5MiIsInNjb3BlcyI6W119.kbjumLIR4cJ4cROZRzuKP6hCQ-ktHf9hcDSYEIjpMP0hy5JRUT0driaPKgCIpRqoG7cQeywRKaU1uNYiVXJjHghdxSG6T0VplJ__uIOjkraw2BTYjMS4DIu8Yu_TrF4q39bh6txIEbBq0cUm_2iDrkxFh7VY0NretGfma4goEIup5C2PAfXXqIURvpwNSIUCfIVXW-l3jhKfj__3JKUu2-lYs7hlt7NxuDjdUvnR-3mE3Hrf58kk6LUvROmGRwmgd_vzvF_i1Ok7dgiBMMYvBdZ6y9c4GOkwzeCMolVxw5zkEwGgG4pee3WqI4--ELBvnhsh5AOtJAWUy2cybg2dj0XKEReb3DdoDBZzqaT4IT72jU8jCBNRD_25hCQ4DWqrLY0jIjzvUc_zjIrppX_A4OJtWZs0APvzUOxuP-9nepn80sYS5uuES-YpYEmKeWqbB42BqBnAALAsseb35SZcvB32xEN_G0BmDzLru4rzBbAW--4OZa026JTWE4sX0VTUqDJy7XCx8TKt92vzcGjZw9hrNEWUdRmoPWPD1W6YuTL1SJ-FB4S4LWfQ77OTq0L6h7EeyCj1akzvkaYIt0xlFKC_QroDiszO_X9Ck687EdOCzAMrsJAGLXpsZtvHDqkUOX5za1VhxfRfy_zPnMDnFUwLCq9lUPpCBCYwW6YhPtQ' ; //$user->createToken('Laravel Password Grant Client')->accessToken;
                        $response = ['success' =>'true', "message" => 'You are Login!', 'status' => 201, 'data' => $token];
                        return response($response, 201);
                    } else {
                        return response()->json(['success' =>'false', 'message' => "Password mismatch", 'status' => 422]);
                    }
                } else {
                    return response()->json(['success' =>'false', 'message' => "User does not exist", 'status' => 422]);
                }
        } catch (Throwable $e) {
            // return response('Unauthorized action.', 403);
            return response()->json(['success' =>'false', 'message' => $e->getMessage(), 'status' => 403]);
        }

    }
    public function emailPassword(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                    'email' => 'required| email',
            ]);
            if ($validator->fails()) {
                // return response(['errors' => $validator->errors()->all()], 422);
                return response()->json(['success' =>'false', 'message' => $validator->errors()->all(), 'status' => 422]);
            }
            $user = User::where('email', $request->email)->first();
            if(!empty($user)){
                $token = Str::random(40);
                $domain = URL::to('/api');
                $url =  $domain. '/reset-password/index?token='.$token;
                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on below link to reset your password";

                Mail::send('auth.passwords.mailcontent', ['data' => $data], function($message) use($data){
                    $message->to($data['email'])->subject($data['title']);
                });
                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::insert([
                            'email' => $request->email,
                            'token' => $token,
                            'created_at' => $datetime
                ]);
                // PasswordReset::updateOrCreate(
                //     ['email' => $request->email],
                //     [
                //         'email' => $request->email,
                //         'token' => $token,
                //         'created_at' => $datetime
                //     ]);
                return response()->json(['success' => 'true' , 'message' => 'Password Reset Link sent on your Email', 'status' => 200]);
            }
            else{
                return response()->json(['success' => 'false' , 'message' => 'User Not Found', 'status' => 404]);
            }
        }
        catch(Exception $e){
            return response()->json(['success' =>'false', 'message' => $e->getMessage()]);
        }
    }
    public function logout(Request $request){
    //    $user = request()->user()->token();
    //    $user->revoke();
    //    return response()->json(['message' => 'You are successfully Logged Out', 'status' => 404]);
            $tokens =  request()->user()->token()->pluck('id');
            Token::whereIn('id', $tokens)
             ->update(['revoked'=> true]);
        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
        return response()->json(['message' => 'You are successfully Logged Out', 'status' => 404]);
    }
    public function resetPasswordIndex(Request $request){
        $resetData = PasswordReset::where('token',  $request->token)->pluck('email');
        if(isset($request->token) && $resetData){
            $user= User::where('email', $resetData)->get();
            return view('auth.passwords.reset', compact('user'));
        }
        else{
            return view('auth.passwords.404');
        }
    }
    public function resetPassword(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            ]);
            if ($validator->fails()) {
                // return response(['errors' => $validator->errors()->all()], 422);
                return response()->json(['success' =>'false', 'message' => $validator->errors()->all(), 'status' => 422]);
            }
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email', $user->email)->delete();
            return response()->json(['success' => 'true' , 'message' => 'Password Reset Successfully!']);
        }
        catch(Exception $e){
            return response()->json(['success' =>'false', 'message' => $e->getMessage()]);
        }
    }
}
