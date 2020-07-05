<?php


namespace App\Services\Client;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * Interface ClientServiceInterface
 * @package App\Services\Client
 */
interface ClientServiceInterface
{
    /**
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function createOrUpdate(FormRequest $request): JsonResponse;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse;

    /**
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function search(FormRequest $request): JsonResponse;

}
