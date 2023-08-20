<?php

namespace Tests;

use App\Http\DataProviders\DataProviderX;
use App\Http\DataProviders\DataProviderY;
use App\Http\Services\ProvidersService;

class ProvidersTest extends TestCase
{
    public function testShouldReturnProviderXAttributes(): void
    {
        $attributes = [
            "parentAmount" => 200, 
            "Currency" => "USD", 
            "parentEmail" => "parent1@parent.eu", 
            "statusCode" => 1, 
            "registerationDate" => "2018-11-30", 
            "parentIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a613" 
         ];
        $providerX = new DataProviderX();
        $providerX->mapAttributes($attributes);

        $id = $providerX->getId();
        $amount = $providerX->getAmount();
        $currency = $providerX->getCurrency();
        $status = $providerX->getStatus();

        $this->assertSame((string)$attributes["parentIdentification"], $id);
        $this->assertSame($attributes["Currency"], $currency);
        $this->assertSame((float)$attributes["parentAmount"], $amount);
        $this->assertSame($status, "authorised");

    }

    public function testShouldReturnProviderYAttributes(): void
    {
        $attributes = [
            "balance" => 300, 
            "currency" => "AED", 
            "email" => "parent2@parent.eu", 
            "status" => 100, 
            "created_at" => "22/12/2018", 
            "id" => "4fc2-a8d1" 
        ]; 
        

        $providerX = new DataProviderY();
        $providerX->mapAttributes($attributes);

        $id = $providerX->getId();
        $amount = $providerX->getAmount();
        $currency = $providerX->getCurrency();
        $status = $providerX->getStatus();

        $this->assertSame((string)$attributes["id"], $id);
        $this->assertSame($attributes["currency"], $currency);
        $this->assertSame((float)$attributes["balance"], $amount);
        $this->assertSame($status, "authorised");

    }

    public function testProviderReader(): void
    {
        $instanceX = new DataProviderX();
        $readX = $instanceX->read();
        $this->assertIsArray($readX);

        $instanceY = new DataProviderY();
        $readY = $instanceY->read();
        $this->assertIsArray($readY);

    }

    public function testProviderServiceFilteration(): void
    {
        $allProvidersData =[
            [
                "id" => "d3d29d70-1d25-11e3-8591-034165a3a613", 
                "email" => "parent1@parent.eu", 
                "amount" => 200, 
                "currency" => "USD", 
                "status" => "authorised", 
                "created_at" => "2018-11-30" 
            ], 
            [
                 "id" => "4fc2-a8d1", 
                   "email" => "parent2@parent.eu", 
                   "amount" => 300, 
                   "currency" => "AED", 
                   "status" => "authorised", 
                   "created_at" => "22/12/2018" 
            ] 
       ]; 
        
        
        $providersService = new ProvidersService();

        $resultFilterStatus = $providersService->findByStatus($allProvidersData, "authorised");
        self::assertGreaterThan(0, count($resultFilterStatus));

        $resultFilterCurrency = $providersService->findByCurrency($allProvidersData, "USD");
        self::assertGreaterThan(0, count($resultFilterCurrency));

        $resultFilterMin = $providersService->findByAmountMin($allProvidersData, 100);
        self::assertGreaterThan(0, count($resultFilterMin));

        $resultFilterMax = $providersService->findByAmountMax($allProvidersData, 500);
        self::assertGreaterThan(0, count($resultFilterMax));

    }
}
