<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientPhone
 * @package App
 */
class ClientPhone extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['phone', 'client_id'];
}
