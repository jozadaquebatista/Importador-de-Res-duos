<?php

use Illuminate\Database\Seeder;

use App\Waste;

class WasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Waste::create([
			'residuo' => 'Papelão Cinza',
			'tipo' => 'Construção Civil',
			'categoria' => 'Reciclável',
			'tratamento' => 'Aterro Comum',
			'classe' => 'A',
			'unidade' => 'kg',
			'peso' => 100.5
		]);

		Waste::create([
			'residuo' => 'Alumínio Marrom',
			'tipo' => 'Metal Não Ferroso',
			'categoria' => 'Reciclável',
			'tratamento' => 'Reciclagem',
			'classe' => 'A',
			'unidade' => 'ton',
			'peso' => 525.134
		]);

		Waste::create([
			'residuo' => 'Copos Plásticos Verdes',
			'tipo' => 'Plásticos',
			'categoria' => 'Não Reciclável',
			'tratamento' => 'Aterro Comum',
			'classe' => 'A',
			'unidade' => 'un',
			'peso' => 10
		]);
    }
}
