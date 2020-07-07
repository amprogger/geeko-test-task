<?php


namespace App\Repositories\Client;


use Illuminate\Database\Eloquent\Builder;

/**
 * Class AllConditions
 * @package App\Repositories\Client
 */
class AllConditions extends Conditions
{

    /**
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    function getGetConditions(Builder $query, string $term): Builder
    {
        $query = $this->getJoins($query);
        $query->where('first_name', 'like', "%$term%")
            ->orWhere('last_name', 'like', "%$term%")
            ->orWhere('phone', 'like', "%$term%")
            ->orWhere('email', 'like', "%$term%");
        return $this->getSelect($query);
    }
}
