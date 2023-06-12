<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class crudBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataSet =[
            [
            'nama_produk' => 'produkA',
            'harga' => 100000,
            'kategori' => "coffe"],
            ['nama_produk' => 'produkB',
            'harga' =>150000,
            'kategori' => "makanan ringan"],
            ['nama_produk' => 'produkC',
            'harga' =>250000,
            'kategori' => "makanan berat"],
        ];

    
        foreach ($dataSet as $key => $data) 
        {
            DB::table('crudBarang')->insert($data);
        }
    }
}