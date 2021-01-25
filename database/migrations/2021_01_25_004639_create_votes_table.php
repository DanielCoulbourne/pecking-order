<?php

use App\Models\Player;
use App\Models\Round;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class, 'voter_id');
            $table->foreignIdFor(Player::class, 'target_id');
            $table->foreignIdFor(Round::class, 'round_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
