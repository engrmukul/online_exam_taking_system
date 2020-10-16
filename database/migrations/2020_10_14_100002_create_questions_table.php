<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TableCommonColumn;

class CreateQuestionsTable extends Migration
{
    use TableCommonColumn;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->text('question');
            $table->string('image', 150)->nullable()->default(NULL);
            $this->commonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
