<?php


namespace App\Repositories\Client;


use Illuminate\Database\Eloquent\Builder;

/**
 * Class EmailConditions
 * @package App\Repositories\Client
 */
class EmailConditions extends Conditions
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
