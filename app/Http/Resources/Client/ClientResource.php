<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ClientResource
 * @package App\Http\Resources\Client
 */
class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $message =  [
            'client' => [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
        foreach ($this->phones as $phone) {
            $message['client']['phones'][] = $phone->phone;
        }
        foreach ($this->emails as $email) {
            $message['client']['emails'][] = $email->email;
        }
        return $message;

    }
}
