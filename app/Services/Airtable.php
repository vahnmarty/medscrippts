<?php

namespace App\Services;
use Http;

class Airtable{

    protected $token;
    protected $baseId, $tableId;
    protected $url = "https://api.airtable.com/v0";

    public function __construct()
    {
        $this->token = config('services.airtable.token');
        $this->baseId = config('services.airtable.baseId');
        $this->tableId = config('services.airtable.tableId');
    }

    public function getCategories()
    {
        $host = "{$this->url}/{$this->baseId}/{$this->tableId}";
        $res =  Http::withToken($this->token)->get($host);

        return $res->json();
    }
}