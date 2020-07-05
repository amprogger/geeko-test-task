<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientEmail
 * @package App
 */
class ClientEmail extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['email', 'client_id'];
}
