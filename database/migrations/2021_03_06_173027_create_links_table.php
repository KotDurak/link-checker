<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->string('donor_page');
            $table->string('target_url')->nullable();
            $table->string('anchor')->nullable();
            $table->tinyInteger('link_status')->nullable();
            $table->enum('type', ['html', 'img'])->nullable();
            $table->boolean('rel_nofollow')->nullable();
            $table->boolean('rel_sponsored')->nullable();
            $table->boolean('rel_ugc')->nullable();
            $table->boolean('content_noindex')->nullable();
            $table->boolean('content_nofollow')->nullable();
            $table->boolean('content_none')->nullable();
            $table->boolean('content_noarchive')->nullable();
            $table->boolean('noindex')->nullable();
            $table->boolean('redirect_donor_page')->nullable();
            $table->boolean('redirect_target_url')->nullable();
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
        Schema::dropIfExists('links');
    }
}
