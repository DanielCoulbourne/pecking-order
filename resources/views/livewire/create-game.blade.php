<div>
    @if(!$game->exists())
        <input type="text" wire:model="game.name" placeholder="Name your Game" />
        <button wire:click="saveGame">Create Game</button>
    @else
        <h2>{{ $game->name }}</h2>

        <div class="flex flex-row items-center">
            <label>
                Discord Username
                <input type="text" wire:model="temp_user.discord_name" placeholder="Littlefinger#1234" />
            </label>

            <label>
                Nice Name
                <input type="text" wire:model="temp_user.discord_name" placeholder="Boston Rob" />
            </label>

            <button wire:click="saveTempUser">Add</button>
        </div>

    @endif
</div>
