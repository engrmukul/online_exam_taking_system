<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TableCommonColumn;

class CreateQuestionPapersTable extends Migration
{
    use TableCommonColumn;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->string('question_set', 100);
            $table->string('question_ids')->comment('comma separate question id');
            $table->enum('generate_by', ['machine','custom'])->default('machine');
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
        Schema::dropIfExists('question_papers');
    }
}
