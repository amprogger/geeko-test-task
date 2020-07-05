<?php


namespace App\Repositories\Client;


use App\Client;
use App\ClientEmail;
use App\ClientPhone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientRepository
 * @package App\Repositories\Client
 */
class ClientRepository implements ClientRepositoryInterface
{

    /**
     * @param array $data
     * @param array|null $phones
     * @param array|null $emails
     * @param int|null $clientId
     * @return Model
     */
    public function updateOrCreate(array $data, ?array $phones, ?array $emails, ?int $clientId): ?Model
    {
        if (!empty($clientId)) {
            $client = Client::findOrFail($clientId);
            $client->update($data);
        } else {
            $client = Client::create($data);
        }
        $client->phones()->delete();
        $client->emails()->delete();

        if (!empty($phones)) {
            foreach ($phones as $phoneNumber) {
                ClientPhone::create(['phone' => $phoneNumber, 'client_id' => $client->id]);
            }
        }

        if (!empty($emails)) {
            foreach ($emails as $emailsAddress) {
                ClientEmail::create(['email' => $emailsAddress, 'client_id' => $client->id]);
            }
        }
        return $client;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $client = Client::findOrFail($id);
        return $client->delete();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function show(int $id): ?Model
    {
        return Client::findOrFail($id);
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function search(array $params): Collection
    {
        $type = $params['type'] ?? 'all';
        $query = $params['query'];
        $dbQuery = Client::query()
            ->leftJoin('client_phones', 'client_phones.client_id', '=', 'clients.id')
            ->leftJoin('client_emails', 'client_emails.client_id', '=', 'clients.id');
        switch ($type) {
            case "name":
                $dbQuery->where("first_name", "like", "%$query%");
                $dbQuery->Orwhere("last_name", "like", "%$query%");
                break;
            case "phone":
                $dbQuery->where("client_phones.phone", "like", "%$query%");
                break;
            case "email":
                $dbQuery->where("client_emails.email", "like", "%$query%");
                break;
            case "all":
                $dbQuery->where("first_name", "like", "%$query%");
                $dbQuery->oRwhere("last_name", "like", "%$query%");
                $dbQuery->oRwhere("client_phones.phone", "like", "%$query%");
                $dbQuery->oRwhere("client_emails.email", "like", "%$query%");
                break;
        }
        $dbQuery->groupBy('clients.id');
        $results = $dbQuery
            ->selectRaw("
            clients.id,
            clients.first_name,
            clients.last_name,
            clients.created_at,
            clients.updated_at")
            ->with(['phones', 'emails'])
            ->get();
        return $results;
    }
}
