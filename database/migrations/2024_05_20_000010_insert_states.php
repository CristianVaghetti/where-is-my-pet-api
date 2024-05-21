<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Instance of Client
     * 
     * @var mixed
     */
    private \GuzzleHttp\Client $client;

    /** 
     * Create a new Migration instance
     * 
     * @return void  */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(["base_uri" => "http://servicodados.ibge.gov.br/api/v1/"]);
    }

    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $response = $this->client->request("GET", "localidades/estados?orderBy=nome");
        if (isset($response)) {
            $collection = collect(\json_decode($response->getBody()->getContents()))->sortBy('sigla');
            $collection->each(function($value) {
                DB::table('states')->insert([
                    'name' => $value->nome,
                    'short' => \mb_strtoupper($value->sigla, "UTF-8"),
                    'ibge' => $value->id
                ]);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('cities')->delete();
        DB::table('states')->delete();
    }
};
