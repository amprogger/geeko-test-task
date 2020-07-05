<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CreateOrUpdateClientRequest;
use App\Http\Requests\SearchRequest;
use App\Services\Client\ClientServiceInterface;
use \Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ClientsController
 * @package App\Http\Controllers\Api
 */
class ClientsController
{
    /**
     * @var ClientServiceInterface
     */
    protected $service;

    /**
     * ClientsController constructor.
     * @param ClientServiceInterface $service
     */
    public function __construct(ClientServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param SearchRequest $request
     * @return JsonResource
     */
    public function search(SearchRequest $request)
    {
        return $this->service->search($request);
    }

    /**
     * @param $id
     * @return JsonResource
     */
    public function show($id)
    {
        return $this->service->show($id);
    }

    /**
     * @param CreateOrUpdateClientRequest $request
     * @return JsonResource
     */
    public function createOrUpdate(CreateOrUpdateClientRequest $request)
    {
        return $this->service->createOrUpdate($request);
    }

    /**
     * @param $id
     * @return JsonResource
     */
    public function delete($id)
    {
        return $this->service->delete($id);
    }

}
