<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;
use OpenApi\Annotations as OA;


class ApiTransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * @OA\Get(
     *      path="/api/all-transactions",
     *      operationId="getAllTransactionsList",
     *      tags={"Transactions"},
     *      summary="Get list of all Transactions",
     *      description="Returns list of Transactions",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\TransactionCollection")
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

    public function allTransactions(Request $request)
    {
        if (auth()->user()->user_type === 1) {
            $sortColumn = $request->input('sort', 'id');
            $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
            $sortColumn = ltrim($sortColumn, '-');
            $transactions = Transaction::orderBy($sortColumn, $sortDirection)->paginate(10);
            $transactions = new TransactionCollection($transactions);
            return $transactions;
        }

        return response()->json([
            'data' => [
                'msg' => 'Unauthorized'
            ]
        ], 403);
    }

    /**
     * @OA\Get(
     *      path="/api/user-transactions",
     *      operationId="getAllUserTransactionsList",
     *      tags={"Transactions"},
     *      summary="Get list of all User Transactions",
     *      description="Returns list of User Transactions",
     *      security={ {"bearer": {} }},

     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\TransactionCollection")
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
     *          description="No Transactions Found"
     *      )
     *     )
     */
    public function userTransactions(Request $request, $user_id)
    {
        if (auth()->user()->user_type === 1) {
            $sortColumn = $request->input('sort', 'id');
            $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
            $sortColumn = ltrim($sortColumn, '-');
            $user = User::where('id', $user_id)->first();
            $transactions = $user->transactions()->orderBy($sortColumn, $sortDirection)->paginate(10);
            if ($transactions == null) {
                return response()->json([
                    'data' => [
                        'msg' => 'No Transactions Found'
                    ]
                ], 404);
            }
            $transactions = new TransactionCollection($transactions);
            return $transactions;
        }


        return response()->json([
            'data' => [
                'msg' => 'Unauthorized'
            ]
        ], 403);
    }

    /**
     * @OA\Get(
     *      path="/api/my-transactions",
     *      operationId="getMyTransactionsList",
     *      tags={"Transactions"},
     *      summary="Get list of all My Transactions",
     *      description="Returns list of My Transactions",
     *      security={ {"bearer": {} }},

     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\TransactionCollection")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No Transactions Found"
     *      )
     *     )
     */

    public function myTransactions(Request $request)
    {
        $sortColumn = $request->input('sort', 'id');
        $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
        $sortColumn = ltrim($sortColumn, '-');
        $user = Auth::user();
        $transactions = $user->transactions()->orderBy($sortColumn, $sortDirection)->paginate(10);
        $transactions = new TransactionCollection($transactions);
        if ($transactions == null) {
            return response()->json([
                'data' => [
                    'msg' => 'No Transactions Found'
                ]
            ], 404);
        }
        return $transactions;
    }

    /**
     * @OA\Get(
     *      path="/api/wallet-transactions/{wallet_id}",
     *      operationId="getWalletTransactionsList",
     *      tags={"Transactions"},
     *      summary="Get list of all wallet Transactions",
     *      description="Returns list of wallet Transactions",
     *      security={ {"bearer": {} }},

     *         @OA\Parameter(
     *          name="wallet_id",
     *          description="Wallet id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\TransactionCollection")
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
     *          description="No Transactions Found"
     *      )
     *     )
     */
    public function walletTransactions(Request $request, $wallet_id)
    {
        $sortColumn = $request->input('sort', 'id');
        $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
        $sortColumn = ltrim($sortColumn, '-');
        $transactions = Transaction::where('wallet_id', $wallet_id)->orderBy($sortColumn, $sortDirection)->paginate(10);
        $transactions = new TransactionCollection($transactions);
        if (auth()->user()->user_type === 1) {
            if ($transactions == null) {
                return response()->json([
                    'data' => [
                        'msg' => 'No Transactions Found'
                    ]
                ], 404);
            }
            return $transactions;
        }
        $wallet = Wallet::where('id', $wallet_id)->first();
        if (!Gate::allows('wallet', $wallet)) {
            return response()->json([
                'data' => [
                    'msg' => 'Unauthorized'
                ]
            ], 403);
        }
        if ($transactions == null) {
            return response()->json([
                'data' => [
                    'msg' => 'No Transactions Found'
                ]
            ], 404);
        }
        return $transactions;
    }



         /**
     * @OA\Post(
     *      path="/api/transactions",
     *      operationId="storeTransactions",
     *      tags={"Transactions"},
     *      summary="Store new Transaction",
     *      description="Returns Transaction data",
     *      security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Transaction credentials",
     *    @OA\JsonContent(
     *       required={"title","status", "amount", "published_at"},
     *       @OA\Property(property="title", type="string", format="text", example="new wallet"),
     *       @OA\Property(property="status", type="string", format="text", example="deposit"),
     *       @OA\Property(property="amount", type="string", format="text", example="1000"),
     *       @OA\Property(property="published_at", type="date", format="text", example="2023-01-01 11:00:00"),
     *    ),
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App\Http\Resources\TransactionResource")
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
    public function store(Request $request, $wallet_id)
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
            'amount' => 'required|numeric|max:100000000|min:1000',
            'status' => 'in:deposit,withdraw',
            'published_at' => 'required|date',
        ]);
        if ($wallet->status === 1) {
            $published_at = strtotime($data['published_at']);
            $amount = $wallet->amount;
            $inputs = [
                'wallet_id' => $wallet->id,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'amount' => $data['amount'],
                'published_at' => date("Y-m-d H:i:s", (int) $published_at),
            ];
            if ($request->status === 'deposit') {
                $inputs['status'] = '0';
                $transaction = Transaction::create($inputs);
                $amount =   $amount + $data['amount'];
                $wallet->update([
                    'user_id' => Auth::user()->id,
                    'amount' => $amount,
                ]);
            } else {
                if ($data['amount'] > $amount) {
                    return response()->json([
                        'data' => [
                            'msg' => 'Transaction failed'
                        ]
                    ],400);
                } else {
                    $inputs['status'] = '1';
                    $transaction = Transaction::create($inputs);
                    $amount =   $amount - $data['amount'];
                    $wallet->update([
                        'user_id' => Auth::user()->id,
                        'amount' => $amount,
                    ]);
                }
            }
            return new TransactionResource($transaction);
        }
    }
}
