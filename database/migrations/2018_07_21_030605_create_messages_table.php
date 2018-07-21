<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
  public function up()
  {
    Schema::create('messages', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->text('message');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('messages');
  }
}
