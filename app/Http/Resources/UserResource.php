<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'name' => $this->name,
            'email' => $this->email,
            'events' => [
                'donations' => DonationResource::collection($this->donations),
                'followers' => $this->followers,
                'merch_sales' => MerchSaleResource::collection($this->merchSales),
                'subscribers' => SubscriberResource::collection($this->subscribers),
            ]
        ];
    }
}
