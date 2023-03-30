<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use OpenApi\Annotations as OA;


class ApiUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * @OA\Get(
     *      path="/api/all-users",
     *      operationId="getAllUsersList",
     *      tags={"Users"},
     *      summary="Get list of all User",
     *      description="Returns list of Users",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\UserCollection")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized"
     *      )
     *     )
     */
    public function allUsers(Request $request)
    {
        if (auth()->user()->user_type === 1) {
            $sortColumn = $request->input('sort', 'id');
            $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
            $sortColumn = ltrim($sortColumn, '-');
            $users = User::orderBy($sortColumn, $sortDirection)->paginate(10);
            $users = new UserCollection($users);
            return $users;
        }

        return response()->json([
            'data' => [
                'msg' => 'Unauthorized'
            ]
        ],403);
    }

    /**
     * @OA\Put(
     *      path="/api/edit-users/{user_id}",
     *      operationId="updateUsers",
     *      tags={"Users"},
     *      summary="Update existing User",
     *      description="Returns updated User data",
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),


     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\UserResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function editUsers(Request $request, $user_id)
    {
        if (auth()->user()->user_type === 1) {
            $data = $this->validate($request, [
                'activation' => 'required|numeric|in:0,1',
                'user_type' => 'required|numeric|in:0,1'
            ]);

            $user = User::find($user_id);
            $user->update($data);
            $user = new UserResource($user);
            return $user;
        }
        return response()->json([
            'data' => [
                'msg' => 'Unauthorized'
            ]
        ],403);
    }
}
