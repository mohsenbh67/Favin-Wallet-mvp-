<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\WalletResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'national_code' => $this->national_code,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email_verified_at' => $this->email_verified_at,
            'activation' => $this->userActivations($this->activation),
            'user_type' => $this->userTypes($this->user_type),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'wallets' => $this->when($request->get('include') == 'wallets', WalletResource::collection($this->wallets))

        ];
    
    }
}
