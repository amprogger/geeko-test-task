<?php


namespace App\Repositories\Client;


use Illuminate\Database\Eloquent\Builder;

/**
 * Class NameConditions
 * @package App\Repositories\Client
 */
class NameConditions extends Conditions
{

    /**
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    function getGetConditions(Builder $query, string $term): Builder
    {
        $query->where('first_name', 'like', "%$term%")
            ->orWhere('last_name', 'like', "%$term%");
        return $this->getSelect($query);
    }
}
