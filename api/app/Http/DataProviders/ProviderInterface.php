<?php


namespace App\Http\DataProviders;

interface ProviderInterface
{

    public static function getPath(): string;

    public function getId(): string;

    public function getCurrency(): string;

    public function getStatus(): string;

    public function getAmount(): float;

    public function getCreatedDate(): string;

    public function getEmail(): string;

    public function mapAttributes(array $provider): void;

    public function read(): array;

    public function toArray(): array;

}
