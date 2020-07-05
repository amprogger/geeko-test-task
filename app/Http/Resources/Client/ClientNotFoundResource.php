<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * Class ClientNotFoundResource
 * @package App\Http\Resources\Client
 */
class ClientNotFoundResource extends JsonResource
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
            'message' => 'fail',
            'errors'  => ['Client does not found'],
            'client' => []
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param Request $request
     * @param  Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('X-PHP-Response-Code', 404);
    }

}
