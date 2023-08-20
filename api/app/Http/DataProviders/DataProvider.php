<?php

namespace App\Http\DataProviders;

class DataProvider
{

    /*
     * send request to fetch the provider data based on pre-defined path in each provider class
     * @return array of un mapped keys
     */
    public function read(): array
    {
        try {

            $client = new \GuzzleHttp\Client();

            $res = $client->request('GET', 'http://localhost:8001/providers/' . $this->getPath());

            return json_decode($res->getBody(), true);

        } catch (\Exception $exception) {

            throw new \Exception($exception->getMessage());

        }

    }

    /*
     * this function get the mapped array after mapProperties has done
     * by using these methods because the class properties is private
    */
    public function toArray(): array
    {
        return [
            'id' => (string)$this->getId(),
            'email' => $this->getEmail(),
            'amount' => (float)$this->getAmount(),
            'currency' => $this->getCurrency(),
            'status' => (string)$this->getStatus(),
            'created_at' => $this->getCreatedDate(),
        ];

    }


}
