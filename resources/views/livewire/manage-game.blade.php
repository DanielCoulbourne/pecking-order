<div>
    <div class="grid grid-cols-3 gap-8">
        <div>
            <h2>Players</h2>
            <div class="flex flex-col mt-2">
                @forelse($game->players as $player)
                    <div class="bg-gray-700 px-2 py-1 rounded flex flex-row justify-between items-center my-1">
                        <span>{{ $player->user->name }}</span>
                        <span class="text-xs text-gray-500">{{ $player->alias }}</span>
                    </div>
                @empty
                    No players yet. Try adding some?
                @endforelse
            </div>
        </div>

        <div>
            <h2>Rounds</h2>
            <div class="flex flex-col mt-2">
                @forelse($game->rounds as $round)
                    <div class="bg-gray-700 px-2 py-1 rounded flex flex-row justify-between items-center my-1">
                        <span>Round {{ $round->number }}</span>
                        <span class="text-xs text-gray-500">{{ $round->timeDiff() }}</span>
                    </div>
                @empty
                    No rounds? This seems broken.
                @endforelse
            </div>
        </div>
    </div>

    <x-slot name="game_title">{{ $game->name }}</x-slot>
</div>
