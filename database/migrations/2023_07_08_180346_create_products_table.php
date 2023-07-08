<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('attachement')->nullable();
            $table->text('desc')->nullable();
            $table->float('price', 10, 2);
            $table->timestamps();
        });

        $defaultProductsRows = [
            [
                'name'          => 'Barang Pertama',
                'attachement'   => 'https://wallpaperwaifu.com/wp-content/uploads/2023/03/hayase-yuuka-sportswear-blue-archive-thumb.jpg',
                'desc'          => 'ini Barang Pertama yang di input di migration',
                'price'         => '12500.00',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('products')->insert($defaultProductsRows);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
