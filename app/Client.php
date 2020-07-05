<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Client
 * @package App
 */
class Client extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['first_name', 'last_name'];

    /**
     * @return HasMany
     */
    public function phones()
    {
        return $this->hasMany(ClientPhone::class, 'client_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function emails()
    {
        return $this->hasMany(ClientEmail::class, 'client_id', 'id');
    }
}
