<?php

namespace App\Http\DataProviders;

class DataProviderX extends DataProvider implements ProviderInterface
{
    private string $id;
    private float  $amount;
    private string $currency;
    private string $status;
    private string $created_at;
    private string $email;

    public static function getPath(): string
    {
        return 'DataProviderX.json';
    }


    public function mapAttributes(array $provider): void
    {

        $this->id = $provider['parentIdentification'];
        $this->amount = $provider['parentAmount'];
        $this->currency = $provider['Currency'];
        $this->email = $provider['parentEmail'];
        $this->created_at = $provider['registerationDate'];
        $this->status = match ($provider['statusCode']) {
            1 => 'authorised',
            2 => 'decline',
            3 => 'refunded',
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
