<?php

use App\Parametros;
use Illuminate\Database\Seeder;

class ParametrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parametros::create([
            'CHAVE_ACCESSKEY' => "NUMERO GRANDAO",
            'USER_ACCOUNT' => "NOME USER CONTAINER",
            'CONTAINER_NAME' => "NOME CONTAINER",
            'VERSION' => "ULTIMA VERSAO"
        ]);
    }
}
