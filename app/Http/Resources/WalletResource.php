<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'user' => $this->user->full_name,
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status($this->status),
                'amount' => $this->amount,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'transactions' => $this->when($request->get('include') == 'transactions', TransactionResource::collection($this->transactions))
        ];
    }
}
