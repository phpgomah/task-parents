<?php


namespace App\Http\Services;

use App\Http\DataProviders\Collection;
use App\Http\DataProviders\Collector;
use App\Http\DataProviders\ProviderInterface;

class ProvidersService
{
    public function __construct()
    {
    }

    /*
     * params: array of providers
     * each provider has a class contains methods like read that read json  using http request
     * and has a method mapAttributes that take un mapped array and map it one by one using the loop
     * return: array of mapped array for all passed providers
     */

    public function fetchProvidersData(array $arrayProvidersInstance): array
    {
        $arrayAllProviders = [];
        foreach ($arrayProvidersInstance as $instance) {
            if ($instance instanceof ProviderInterface) {
                $reader = $instance->read();
                foreach ($reader as $item) {
                    $instance->mapAttributes($item);
                    $arrayAllProviders[] = $instance->toArray();
                }
            } else {
                throw new \Exception("Provider Not implementing ProviderInterface! ");
            }
        }
        return $arrayAllProviders;
    }

    public function findByStatus(array $collection,string $status): array
    {
        return array_filter($collection, function ($elm) use ($status) {
            return $elm['status'] == $status;
        });
    }

    public function findByCurrency(array $collection,string $currency): array
    {

        return array_filter($collection, function ($elm) use ($currency) {
            return $elm['currency'] == $currency;
        });
    }
    public function findByAmountMin(array $collection,float $min): array
    {

        return array_filter($collection, function ($elm) use ($min) {
            return $elm['amount'] >= $min;
        });
    }
    public function findByAmountMax(array $collection,float $max): array
    {
        return array_filter($collection, function ($elm) use ($max) {
            return $elm['amount'] <= $max;
        });
    }
}
