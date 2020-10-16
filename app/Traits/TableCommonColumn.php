<?php

namespace App\Traits;

/**
 * Trait TableCommonColumn
 * @package App\Traits
 */
trait TableCommonColumn
{
    public function commonColumns($table)
    {
        $table->enum('status', ['active','inactive'])->default('active');
        $table->timestamps();
        $table->softDeletes();
        $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
        $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('cascade');
        $table->foreignId('deleted_by')->nullable()->references('id')->on('users')->onDelete('cascade');
    }
}
