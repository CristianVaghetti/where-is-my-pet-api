<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repository\StateRepository;
use Illuminate\Support\Facades\DB;


class CitiesSeeder extends Seeder
{
    protected StateRepository $state;
    /**
     * Instance of Client
     * 
     * @var mixed
     */
    private \GuzzleHttp\Client $client;

    /** 
     * Create a new Seeder instance
     * 
     * @return void  */
    public function __construct(StateRepository $state)
    {
        $this->client = new \GuzzleHttp\Client(["base_uri" => "http://servicodados.ibge.gov.br/api/v1/"]);
        $this->state = $state;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = $this->state->all(['short', 'asc']);

        $collection->each(function($value) {
            $response = $this->client->request("GET", "localidades/estados/{$value->short}/municipios");
            if (isset($response)) {
                $cidades = collect(\json_decode($response->getBody()->getContents()))->sortBy('sigla');
                $cidades->each($this->_cidadesIterator($value->id));
            }
        });
    }

    /**
     * Método anônimo que carrega as cidades
     * 
     * @param int $stateId 
     * @return \Closure 
     */
    private function _cidadesIterator($stateId)
    {
        return function($value) use ($stateId) {
            DB::table('cities')->insert([
                'state_id' => $stateId,
                'name' => $value->nome,
                'ibge' => $value->id
            ]);
        };
    }
}
