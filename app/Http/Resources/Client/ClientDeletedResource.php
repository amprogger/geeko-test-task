<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ClientDeletedResource
 * @package App\Http\Resources\Client
 */
class ClientDeletedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'message' => 'Success. Client has been deleted.',
            'client' => []
        ];
    }
}
