<?php

namespace App\Http\Resources;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OwnerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'corporate_name' => $this->corporate_name,
            'contact_no' =>$this->contact_no
        ];
    }
}
