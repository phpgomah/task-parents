<?php

namespace App\Http\Controllers;

use App\Http\DataProviders\DataProviderX;
use App\Http\DataProviders\DataProviderY;
use App\Http\Services\ProvidersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersProvidersController extends Controller
{
    public function __construct(private ProvidersService $providersService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $response = $this->findByProvider($request->get('provider') ?? "all");

        if ($request->get('statusCode')) {
            $response = $this->findByStatus($response, $request->get('statusCode'));
        }
        if ($request->get('balanceMin')) {
            $response = $this->findByAmountMin($response, (float)$request->get('balanceMin'));
        }
        if ($request->get('balanceMax')) {
            $response = $this->findByAmountMax($response, (float)$request->get('balanceMax'));
        }
        if ($request->get('currency')) {
            $response = $this->findByCurrency($response, $request->get('currency'));
        }

        return response()->json($response);

    }


    private function findByProvider($provider): array
    {

        return match ($provider) {
            'DataProviderX' => $this->providersService->fetchProvidersData([new DataProviderX()]),
            'DataProviderY' => $this->providersService->fetchProvidersData([new DataProviderY()]),
            default => $this->providersService->fetchProvidersData([new DataProviderX(), new DataProviderY()]),
        };
    }

    private function findByStatus($collection, $status): array
    {
     return $this->providersService->findByStatus($collection,$status);
    }

    private function findByCurrency($collection, $currency): array
    {
        return $this->providersService->findByCurrency($collection,$currency);
    }

    private function findByAmountMin($collection, $min): array
    {
       return $this->providersService->findByAmountMin($collection,$min);
    }

    private function findByAmountMax($collection, $max): array
    {
       return $this->providersService->findByAmountMax($collection,$max);

    }

}
