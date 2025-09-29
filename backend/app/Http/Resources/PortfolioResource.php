<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'symbol' => $this->symbol,
            'shares' => $this->shares,
            'purchase_price' => $this->purchase_price,
            'current_value' => $this->current_value,
            'profit_loss' => $this->profit_loss,
            'user' => [
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
            'index_fund' => new IndexFundResource($this->whenLoaded('indexFund')),
        ];
    }
}