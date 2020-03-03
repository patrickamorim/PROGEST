<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstoquesMateriais extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('materials', function(Blueprint $table) {
            $table->boolean('disponivel');
            $table->integer('sub_item_id')->unsigned();
            $table->foreign('sub_item_id')->references('id')->on('sub_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('materials', function(Blueprint $table) {
            $table->string('qtd');
            $table->string('vl_un');
            $table->string('vl_total');
            $table->dropColumn('qtd_1');
            $table->dropColumn('qtd_2');
            $table->dropColumn('qtd_3');
            $table->dropColumn('qtd_4');
            $table->dropColumn('disponivel');
            $table->dropForeign('sub_item_id');
        });
    }

}
