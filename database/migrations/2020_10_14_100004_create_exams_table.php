<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TableCommonColumn;

class CreateExamsTable extends Migration
{
    use TableCommonColumn;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->string('exam_title', 255);
            $table->date('exam_date');
            $table->smallInteger('noq')->default(10)->comment('noq = number of question');
            $table->string('start_time', 20);
            $table->string('end_time',20);
            $table->enum('exam_status', ['not_start','on_going','expire'])->default('not_start');
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
        Schema::dropIfExists('exams');
    }
}
