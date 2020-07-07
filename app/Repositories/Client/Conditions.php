<?php


namespace App\Repositories\Client;


use Illuminate\Database\Eloquent\Builder;

/**
 * Class Conditions
 * @package App\Repositories\Client
 */
abstract class Conditions
{
    /**
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    abstract function getGetConditions(Builder $query, string $term): Builder;

    /**
     * @param Builder $query
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function getJoins(Builder $query)
    {
        return $query->leftJoin('client_phones', 'client_phones.client_id', '=', 'clients.id')
            ->leftJoin('client_emails', 'client_emails.client_id', '=', 'clients.id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function getSelect(Builder $query)
    {
        return $query->groupBy('clients.id')->select(
            'clients.id', 'clients.first_name', 'clients.last_name', 'clients.created_at', 'clients.updated_at');
    }
}
