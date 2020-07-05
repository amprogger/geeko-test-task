<?php


namespace App\Services\Client;


use App\Http\Resources\Client\ClientDeletedResource;
use App\Http\Resources\Client\ClientNotFoundResource;
use App\Http\Resources\Client\ClientResource;
use App\Repositories\Client\ClientRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ClientService
 * @package App\Services\Client
 */
class ClientService implements ClientServiceInterface
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * ClientService constructor.
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function createOrUpdate(FormRequest $request): JsonResponse
    {
        $data = $this->getDataFromRequest($request);
        list($clientId, $clientNames, $phones, $emails) = $data;
        try {
            $client = $this->repository->updateOrCreate($clientNames, $phones, $emails, $clientId);
            if (!empty($clientId)) {
                Log::notice('operation:update', $data);
            } else {
                Log::notice('operation:create', $data);
            }
            return (new ClientResource($client))->response()->setStatusCode(202);
        } catch (ModelNotFoundException $e) {
            return (new ClientNotFoundResource(null))->response()->setStatusCode(404);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $client = $this->repository->delete($id);
            Log::notice('operation:delete', ['id' => $id]);
            return (new ClientDeletedResource($client))->response()->setStatusCode(202);
        } catch (\Exception $e) {
            return (new ClientNotFoundResource(null))->response()->setStatusCode(404);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $client = $this->repository->show($id);
            Log::notice('operation:show', ['id' => $id]);
            return (new ClientResource($client))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            return (new ClientNotFoundResource(null))->response()->setStatusCode(404);
        }
    }

    /**
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function search(FormRequest $request): JsonResponse
    {
        $results = $this->repository->search($request->all());
        Log::notice('operation:search',
            ['type' => $request->get('type'), 'query' => $request->get('query')]);
        return (ClientResource::collection($results))->response()->setStatusCode(200);
    }

    /**
     * @param FormRequest $request
     * @return array
     */
    private function getDataFromRequest(FormRequest $request) : array
    {
        $clientNames = $request->only('first_name', 'last_name');
        $phones = $request->get('phones', null);
        $emails = $request->get('emails', null);
        $clientId = $request->get('client_id', null);
        return [$clientId, $clientNames, $phones, $emails];
    }
}
