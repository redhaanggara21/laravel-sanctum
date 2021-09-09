<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $penjualan = $this->whenLoaded('penjualans');

        return [
            'id' => $this->id,
            'penjualan' => new PenjualanResource($penjualan),
        ];
    }
}
