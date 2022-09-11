<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Activity;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualtrics_survey_links', function (Blueprint $table) {
            $table->id();
            $table->string('email', 254);
            $table->text('link');
            $table->foreignIdFor(Activity::class);

            $table->unique(['email', 'activity_id'], 'activity_email_unique');

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
        Schema::dropIfExists('qualtrics_survey_links');
    }
};
