<?php

namespace App\Http\Controllers;

use App\Models\User;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as TokenExpired;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as TokenInvalid;
use Tymon\JWTAuth\Exceptions\JWTException as TokenNotProvided;



class AuthController extends Controller
{
    //Register
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully register',
            'data' => $user,
        ]);
    }

    // Login
    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'Successfully login',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // logout
    public function logout()
    {
        try {
            $refresh = JWTAuth::parseToken()->invalidate();
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (TokenExpired $err) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalid $err) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (TokenNotProvided $err) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
    }

    // refresh
    public function refresh()
    {
        try {
            $refresh = JWTAuth::parseToken()->refresh();
            return response()->json([
                'access_token' => $refresh,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        } catch (TokenExpired $err) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalid $err) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (TokenNotProvided $err) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
    }

    // get data
    public function data()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(compact('user'));
        } catch (TokenExpired $err) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalid $err) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (TokenNotProvided $err) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAuthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function show(Auth $auth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function edit(Auth $auth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAuthRequest  $request
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthRequest $request, Auth $auth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auth $auth)
    {
        //
    }
}
