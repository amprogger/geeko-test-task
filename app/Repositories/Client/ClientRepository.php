<?php


namespace App\Repositories\Client;


use App\Client;
use App\ClientEmail;
use App\ClientPhone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientRepository
 * @package App\Repositories\Client
 */
class ClientRepository implements ClientRepositoryInterface
{

    /**
     * @var string[]
     */
    private $conditionClasses = [
         'all' => AllConditions::class,
         'name' => NameConditions::class,
         'email' => EmailConditions::class,
         'phone' => PhoneConditions::class
     ];

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
     * @param string $type
     * @param string $term
     * @return Collection
     */
    public function search(string $type, string $term): Collection
    {
        $dbQuery = Client::query();
        return app($this->conditionClasses[$type])->getGetConditions($dbQuery, $term)
            ->with('phones', 'emails')->get();
    }
}
