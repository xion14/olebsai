<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'stock'       => $this->stock,
            'total_sells' => $this->total_sells,
            'status'      => $this->status,
        ];
    }
}
