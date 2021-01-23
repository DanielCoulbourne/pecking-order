<div class="text-gray-200">
    @unless($game && $game->exists)
        <input type="text" class="bg-gray-800" wire:model="game.name" placeholder="Name your Game" />
        <button wire:click="saveGame">Create Game</button>
    @else
        <x-slot name="game_title">{{ $game->name }}</x-slot>

        <div class="mb-4">
            <h2>Players</h2>
            <div class="flex flex-col border-2 rounded border-gray-800 p-2 mt-2">
                @forelse($game->players as $player)
                    <div class="bg-gray-700 px-2 py-1 rounded flex flex-row justify-between items-center my-1">
                        <span>{{ $player->user->name }}</span>
                        <span class="text-xs text-gray-500">{{ $player->user->discord_username }}</span>
                    </div>
                @empty
                    No players yet. Try adding some?
                @endforelse
            </div>
        </div>

            <div class="mb-4">
                @if($game->players->count() < 15)
                    <h2>Add a Player</h2>

                    <div class="flex flex-row items-center border-2 rounded border-gray-800 p-2 mt-2">
                        <label class="block flex flex-col flex-1 mr-2">
                            <span class="text-xs text-gray-700">Discord Username</span>
                            <input type="text" class="bg-gray-700 px-2 py-1 rounded text-gray-200" wire:model="temp_user.discord_username" placeholder="Littlefinger#1234" />
                        </label>

                        <label class="block flex flex-col flex-1 mr-2">
                            <span class="text-xs text-gray-700">Nice Name</span>
                            <input type="text" class="bg-gray-700 px-2 py-1 rounded text-gray-200" wire:model="temp_user.name" placeholder="Boston Rob" />
                        </label>

                        <button class="border-2 rounded border-gray-800 py-1 px-2 mt-2 self-end" wire:click="saveTempUser">Add</button>
                    </div>
                @else
                    <div class="flex flex-row items-center border-2 rounded border-gray-800 p-2 mt-2">
                        You've added 12 players, which is our maximum supported number.
                    </div>
                @endif
            </div>

        @error('temp_user.discord_username')<span class="error">{{ $message }}</span>@enderror
        @error('temp_user.name')<span class="error">{{ $message }}</span>@enderror

        @if($game->players->count() < 6)
            <p>Please add at least 6 players to start the round</p>
        @else
            <p class="text-xs mt-2 text-gray-500">This will lock the player list and schedule the first round to start at 12:00PM (EST)</p>
            <button class="border-2 rounded border-gray-800 py-1 px-2 mt-2 self-end" wire:click="startGame">Start Game</button>
        @endif
    @endif
</div>

