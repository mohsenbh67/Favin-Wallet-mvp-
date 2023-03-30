<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Auth"},
     *      summary="Login User",
     *      description="Returns User data",
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass User credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="1234@gmail.com"),
     *       @OA\Property(property="password", type="string", format="paswword", example="123456"),
     *    ),
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\UserResource")
     *       ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {

            return response()->json([
                'data' => [
                    'status' => 'error',
                    'msg' => 'Sorry, wrong email address or password. Please try again',
                ]
            ],422);
        }

        $user = Auth::user();
        return response()->json([
            'data' => [
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        ]);
    }


     /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="registerUser",
     *      tags={"Auth"},
     *      summary="Register User",
     *      description="Returns User data",
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass User credentials",
     *    @OA\JsonContent(
     *       required={"first_name","last_name","email","password"},
     *       @OA\Property(property="first_name", type="string", format="text", example="ali"),
     *       @OA\Property(property="last_name", type="string", format="text", example="ali"),
     *       @OA\Property(property="email", type="string", format="email", example="1234@gmail.com"),
     *       @OA\Property(property="password", type="string", format="paswword", example="123456"),
     *    ),
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\UserResource")
     *       ),
     * )
     */

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|min:1|max:20',
            'last_name' => 'required|string|min:1|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'activation' => 1,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'data' => [
                'status' => 'success',
                'msg' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        ],200);
    }



         /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logoutUser",
     *      tags={"Auth"},
     *      summary="logout User",
     *      description="Returns User data",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successfully logged out",
     *          @OA\JsonContent(ref="App\Http\Resources\UserResource")
     *       ),
     * )
     */

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'data' => [
                'status' => 'success',
                'msg' => 'Successfully logged out',
            ]
        ],200);
        
    }

     /**
     * @OA\Post(
     *      path="/api/refresh",
     *      operationId="refreshUserToken",
     *      tags={"Auth"},
     *      summary="Refresh User Token",
     *      description="Returns User token",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\UserResource")
     *       ),
     * )
     */
    public function refresh()
    {

        return response()->json([
            'data' => [
                'status' => 'success',
                'user' => Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]
        ],200);
    }
}
