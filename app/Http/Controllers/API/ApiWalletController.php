<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletCollection;
use OpenApi\Annotations as OA;


class ApiWalletController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * @OA\Get(
     *      path="/api/all-wallets",
     *      operationId="getAllWalletsList",
     *      tags={"Wallets"},
     *      summary="Get list of all Wallets",
     *      description="Returns list of Wallets",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\WalletCollection")
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
    public function allWallets(Request $request)
    {
        if (auth()->user()->user_type === 1) {
            $sortColumn = $request->input('sort', 'id');
            $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
            $sortColumn = ltrim($sortColumn, '-');
            $wallets = Wallet::orderBy($sortColumn, $sortDirection)->paginate(10);
            $wallets = new WalletCollection($wallets);
            return $wallets;
        }

        return response()->json([
            'data' => [
                'msg' => 'Unauthorized'
            ]
        ], 403);
    }



    /**
     * @OA\Get(
     *      path="/api/user-wallets",
     *      operationId="getAllUserWalletsList",
     *      tags={"Wallets"},
     *      summary="Get list of all User Wallets",
     *      description="Returns list of User Wallets",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\WalletCollection")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No Wallets Found"
     *      )
     *     )
     */

    public function userWallets(Request $request, $user_id)
    {

        $sortColumn = $request->input('sort', 'id');
        $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
        $sortColumn = ltrim($sortColumn, '-');
        $wallets = Wallet::where('user_id', $user_id)->orderBy($sortColumn, $sortDirection)->paginate(10);
        if (auth()->user()->user_type === 1) {
            $wallets = new WalletCollection($wallets);
            return $wallets;
        }
        foreach ($wallets as $wallet) {
            if (!Gate::allows('wallet', $wallet)) {
                return response()->json([
                    'data' => [
                        'msg' => 'Unauthorized'
                    ]
                ], 403);
            }
        }
        if ($wallets === null) {
            return response()->json([
                'data' => [
                    'msg' => 'No Wallets Found'
                ]
            ], 404);
        }
        $wallets = new WalletCollection($wallets);
        return $wallets;
    }

    /**
     * @OA\Post(
     *      path="/api/wallets",
     *      operationId="storeWallets",
     *      tags={"Wallets"},
     *      summary="Store new Wallet",
     *      description="Returns Wallet data",
     *      security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Wallet credentials",
     *    @OA\JsonContent(
     *       required={"title","status"},
     *       @OA\Property(property="title", type="string", format="text", example="new wallet"),
     *       @OA\Property(property="description", type="string", format="text", example="new wallet"),
     *       @OA\Property(property="status", type="integer", format="number", example="1"),
     *    ),
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\WalletResource")
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
     *          description="Unauthorized"
     *      )
     * )
     */


    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'title' => 'required|string|max:120|min:1',
            'description' => 'nullable|max:120|min:1',
            'status' => 'required|numeric|between:0,2'
        ]);
        $data['user_id'] = Auth::user()->id;
        $wallet = Wallet::create($data);
        return new WalletResource($wallet);
    }

    public function update(Request $request, $wallet_id)
    {
        $wallet = Wallet::where('id', $wallet_id)->first();
        if (!Gate::allows('wallet', $wallet)) {
            return response()->json([
                'data' => [
                    'msg' => 'Unauthorized'
                ]
            ],403);
        }
        $data = $this->validate($request, [
            'title' => 'required|string|max:120|min:1',
            'description' => 'nullable|max:120|min:1',
            'status' => 'required|numeric|between:0,2'
        ]);
        $wallet->update($data);
        return new WalletResource($wallet);
    }
}
