<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Qualtrics\MailingList;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualtrics_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact_id')->unique();
            $table->boolean('unsubscribed')->default(false);
            $table->foreignIdFor(MailingList::class);
            $table->foreignIdFor(User::class);
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
        Schema::dropIfExists('qualtrics_contacts');
    }
};
