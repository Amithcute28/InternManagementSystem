<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ApplicationForm;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('application_forms', function (Blueprint $table) {
        $table->string('eval_form')->nullable();
        $table->timestamp('eval_form_completed')->nullable();
    });

    $applicationForms = ApplicationForm::all();

    foreach ($applicationForms as $applicationForm) {
        if (!empty($applicationForm->eval_form) && empty($applicationForm->eval_form_completed)) {
            $applicationForm->eval_form_completed = now();
            $applicationForm->save();
        }
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_forms', function (Blueprint $table) {
            //
        });
    }
};
