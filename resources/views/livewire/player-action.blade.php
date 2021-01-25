<div>
    <div class="mb-8">
        <h2>Team</h2>

        <div class="flex flex-col border-2 rounded border-gray-800 p-2 mt-2">
            <p>You are on team <span class="p-1 bg-{{ optional($player->team())->color ?? 'gray-700' }}">{{ $player->team()->name }}</span>.</p>

            @if($round->tribe_swap)
                <div class="flex flex-row">
                    <p>On this round you may change your tribe if you like.</p>
                        <select class="bg-gray-700 p-1 ml-2" wire:model="new_team">
                            @foreach($round->teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                </div>
            @endif
        </div>
    </div>

    <div class="mb-8" x-data="initializeVotes()">
        <h2>Vote</h2>
        <p>You have
            <span class="p-1 rounded bg-gray-700"><span x-text="remainingVotes()"></span> <span x-text="remainingVotes() === 1 ? 'vote' : 'votes'"></span></span>
        remaining. You may vote for players below.</p>

        <template x-for="target in targets">
            <div class="flex flex-row items-center justify-between rounded p-2 bg-gray-800 mt-2">
                <span x-text="target.name"></span>

                <div>
                    <button class="bg-gray-500 rounded mr-2 px-2 disabled:opacity-20" @click="target.votes--" x-bind:disabled="target.votes <= 0">-</button>
                    <input class="p-1 bg-gray-700 w-12 text-center" type="text" disabled x-model="target.votes" />
                    <button class="bg-gray-500 rounded ml-2 px-2 disabled:opacity-20" @click="target.votes++" x-bind:disabled="remainingVotes() <= 0">+</button>
                </div>
            </div>
        </template>
    </div>

    <div class="flex flex-row justify-between items-center">
        <button class="bg-gray-700 px-4 py-2 rounded" wire:click="submit">Submit Vote(s)</button>
        <em>This is your last chance. Submitting your votes is final.</em>
    </div>

</div>

<script>
    function initializeVotes()
    {
        return {
            maxVotes: {{$this->maxSpendableVotes()}},
            targets: [
                @foreach($player->targets() as $target)
                {
                    id: {{ $target->id }},
                    name: '{{ $target->user->name }}',
                    votes: 0,
                },
                @endforeach
            ],

            remainingVotes() {
                return this.maxVotes - this.targets.reduce(
                    ((total, target) => total + target.votes),
                    0
                )
            }
        }
    }
</script>
