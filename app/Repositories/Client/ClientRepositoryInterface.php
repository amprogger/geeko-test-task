<?php


namespace App\Repositories\Client;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface ClientRepositoryInterface
 * @package App\Repositories\Client
 */
interface ClientRepositoryInterface
{
    /**
     * @param array $data
     * @param array|null $phones
     * @param array|null $emails
     * @param int|null $clientId
     * @return Model|null
     */
    public function updateOrCreate(array $data, ?array $phones, ?array $emails, ?int $clientId): ?Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $id
     * @return Model|null
     */
    public function show(int $id): ?Model;

    /**
     * @param array $params
     * @return Collection
     */
    public function search(array $params): Collection;
}
