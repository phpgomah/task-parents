<?php

namespace App\Http\DataProviders;

class DataProviderY extends DataProvider implements ProviderInterface
{
    private string $id;
    private float $amount;
    private string $currency;
    private string $status;
    private string $created_at;
    private string $email;

    public static function getPath(): string
    {
        return 'DataProviderY.json';
    }

    public function mapAttributes(array $provider): void
    {

        $this->id = $provider['id'];
        $this->amount = $provider['balance'];
        $this->currency = $provider['currency'];
        $this->email = $provider['email'];
        $this->created_at = $provider['created_at'];
        $this->status = match ($provider['status']) {
            100 => 'authorised',
            200 => 'decline',
            300 => 'refunded',
            default => ''
        };
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function getCreatedDate(): string
    {
        return $this->created_at;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}
