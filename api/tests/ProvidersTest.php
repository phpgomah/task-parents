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
            "transactionIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a613",
            "transactionAmount" => 200,
            "Currency" => "USD",
            "transactionStatus" => 1
        ];
        $providerX = new DataProviderX();
        $providerX->mapAttributes($attributes);

        $id = $providerX->getId();
        $amount = $providerX->getAmount();
        $currency = $providerX->getCurrency();
        $status = $providerX->getStatus();

        $this->assertSame((string)$attributes["transactionIdentification"], $id);
        $this->assertSame($attributes["Currency"], $currency);
        $this->assertSame((float)$attributes["transactionAmount"], $amount);
        $this->assertSame($status, "paid");

    }

    public function testShouldReturnProviderYAttributes(): void
    {
        $attributes = [
            "id" => "4fc2-a8d1",
            "amount" => 300,
            "currency" => "EGP",
            "status" => 200
        ];

        $providerX = new DataProviderY();
        $providerX->mapAttributes($attributes);

        $id = $providerX->getId();
        $amount = $providerX->getAmount();
        $currency = $providerX->getCurrency();
        $status = $providerX->getStatus();

        $this->assertSame((string)$attributes["id"], $id);
        $this->assertSame($attributes["currency"], $currency);
        $this->assertSame((float)$attributes["amount"], $amount);
        $this->assertSame($status, "pending");

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
        $allProvidersData = [
            [
                "id" => "d3d29d70-1d25-11e3-8591-034165a3a613",
                "amount" => 200,
                "currency" => "USD",
                "status" => "paid"
            ],
            [
                "id" => "4fc2-a8d1",
                "amount" => 300,
                "currency" => "EGP",
                "status" => "pending"
            ],
            [
                "id" => "12345678",
                "amount" => 500,
                "currency" => "EGP",
                "status" => "paid"
            ]
        ];

        $providersService = new ProvidersService();

        $resultFilterStatus = $providersService->findByStatus($allProvidersData, "paid");
        self::assertGreaterThan(0, count($resultFilterStatus));

        $resultFilterCurrency = $providersService->findByCurrency($allProvidersData, "EGP");
        self::assertGreaterThan(0, count($resultFilterCurrency));

        $resultFilterMin = $providersService->findByAmountMin($allProvidersData, 100);
        self::assertGreaterThan(0, count($resultFilterMin));

        $resultFilterMax = $providersService->findByAmountMax($allProvidersData, 500);
        self::assertGreaterThan(0, count($resultFilterMax));

    }
}
