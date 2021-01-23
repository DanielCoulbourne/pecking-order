<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Game
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Player[] $players
 * @property-read int|null $players_count
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Player
 *
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 */
	class Player extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Round
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Round newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Round newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Round query()
 */
	class Round extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Team
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vote
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote query()
 */
	class Vote extends \Eloquent {}
}

