<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateShopThemesTable extends Migration { public function up() { Schema::create('shop_themes', function (Blueprint $sp3c6e67) { $sp3c6e67->increments('id'); $sp3c6e67->string('name', 128)->unique(); $sp3c6e67->string('description')->nullable(); $sp3c6e67->text('options')->nullable(); $sp3c6e67->text('config')->nullable(); $sp3c6e67->boolean('enabled')->default(true); }); \App\ShopTheme::freshList(); } public function down() { Schema::dropIfExists('shop_themes'); } }