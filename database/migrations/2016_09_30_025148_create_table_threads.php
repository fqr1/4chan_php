<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableThreads extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('threads', function (Blueprint $table) {
      $table->increments('id');
      $table->string("thread_id")->nullable()->default(null);
      $table->string('board')->nullable()->default(null);
      $table->string("reply_id")->nullable()->default(null);; // as no.
      $table->string("now")->nullable()->default(null);
      $table->string("name")->nullable()->default(null);
      $table->text("com")->nullable()->default(null);
      $table->string("filename")->nullable()->default(null);
      $table->string("ext")->nullable()->default(null);
      $table->string("w")->nullable()->default(null);
      $table->string("h")->nullable()->default(null);
      $table->string("tn_w")->nullable()->default(null);
      $table->string("tn_h")->nullable()->default(null);
      $table->string("tim")->nullable()->default(null);
      $table->string("time")->nullable()->default(null);
      $table->string("md5")->nullable()->default(null);
      $table->string("fsize")->nullable()->default(null);
      $table->string("resto")->nullable()->default(null);
      $table->string("bumplimit")->nullable()->default(null);
      $table->string("imagelimit")->nullable()->default(null);
      $table->string("semantic_url")->nullable()->default(null); //only the first thread
      $table->string("replies")->nullable()->default(null);
      $table->string("images")->nullable()->default(null);
      $table->string("unique_ips")->nullable()->default(null);
      $table->string("url_data")->nullable()->default(null);  //as http://i.4cdn.org/b/1475202719449.jpg b=> board number=>tim extension=>ext


      $table->unique(['thread_id', 'reply_id','board']);

      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('threads');
  }
}
