<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactListResource extends JsonResource
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
            'serial_number' => $this->serial_number,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'dial_code' => $this->dial_code,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
        ];
    }
}
