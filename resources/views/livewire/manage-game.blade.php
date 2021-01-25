<div>
    @if($game->currentRound())
    <div class="flex flex-row items-center border-2 rounded border-gray-800 p-2 mt-2">
        The Current Round is Round {{$game->currentRound()->round_number}}
    </div>
    @endif
    <div class="grid grid-cols-3 gap-8">
        <div>
            <h2>Players</h2>
            <div class="flex flex-col mt-2">
                @forelse($game->players as $player)
                    <div class="bg-{{ optional($player->team())->color ?? 'gray-700' }} px-2 py-1 rounded flex flex-row justify-between items-center my-1">
                        <span>{{ $player->user->name }}</span>
                        <span class="text-xs text-gray-200">{{ $player->alias }}</span>
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
                    <div class="px-2 py-1 rounded flex flex-row justify-between items-center my-1 {{ optional($game->currentRound())->id === $round->id ? 'bg-gray-600 border border-gray-200' : 'bg-gray-800'}}">
                        <span>Round {{ $round->round_number }}</span>
                        <div>
                            <span class="text-xs text-gray-500">{{ $round->timeDiff() }}</span>
                            @if(optional($game->nextRound())->id === $round->id)
                                <button class="bg-gray-500 rounded text-xs p-1" wire:click="startRound({{ $round->id }})">Start</button>
                            @endif
                        </div>
                    </div>
                @empty
                    No rounds? This seems broken.
                @endforelse
            </div>
        </div>
    </div>

    <x-slot name="game_title">{{ $game->name }}</x-slot>
</div>
