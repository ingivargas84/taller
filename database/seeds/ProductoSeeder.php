<?php

use Illuminate\Database\Seeder;
use App\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('codigo' => 'DB500',
                'nombre' => 'Computadora Samsung',
                'observaciones' => 'ninguna...',
                'stock_minimo' => '1',
                'stock_maximo' => '10',
                'precio_venta' => '3000'),

            array('codigo' => 'DT100',
                'nombre' => 'Escritorio de oficina',
                'observaciones' => 'ninguna...',
                'stock_minimo' => '1',
                'stock_maximo' => '10',
                'precio_venta' => '1500'),
        );

        Producto::insert($data);
    }
}
