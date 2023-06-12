<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrudBarang extends Migration
{
    
    public function up()
    {
        Schema::create('crudBarang', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->string('nama_produk');
            $table->string('kategori');
            $table->integer("harga");
        });
    }

    public function down()
    {
        Schema::dropIfExists('crudBarang');
    }
}
