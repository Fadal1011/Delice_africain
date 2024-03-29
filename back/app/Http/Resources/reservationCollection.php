<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class reservationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'tous les reservations' ,
            'status' => true,
            'data' => $this->collection
        ];
    }

    public function paginationInformation($request, $paginate, $default)
    {
        return [
            "links" => $default["meta"]["links"]
        ];
    }
}
