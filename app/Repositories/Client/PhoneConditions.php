<?php


namespace App\Repositories\Client;


use Illuminate\Database\Eloquent\Builder;

/**
 * Class PhoneConditions
 * @package App\Repositories\Client
 */
class PhoneConditions extends Conditions
{

    /**
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    function getGetConditions(Builder $query, string $term): Builder
    {
        $query = $this->getJoins($query);
        $query->where('phone', 'like', "%$term%");
        return $this->getSelect($query);
    }
}
