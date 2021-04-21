<div class="space-y-8">
    <div>

        <h2>Team</h2>

        <div class="flex flex-col border-2 rounded border-gray-800 p-2 mt-2">
            <p>You are on team <span class="p-1 bg-{{ optional($player->team)->color ?? 'gray-700' }}">{{ optional($player->team)->name }}</span>.</p>

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

    <h2>
        You have <span class="p-1 mr-1 rounded bg-gray-700">
            {{ $player->available_ballots . ' ' . Str::plural('ballot', $player->available_ballots) }}
        </span> remaining
    </h2>

    @if($player->available_ballots > 0)
    <div x-data="{
            availableBallots: $wire.get('player.available_ballots'),
            upvote: $wire.entangle('upvote').defer,
            downvote: $wire.entangle('downvote').defer,
            castUpvote(id) {
                this.upvote = this.upvote !== id
                    ? id
                    : null
            },
            castDownvote(id) {
                this.downvote = this.downvote !== id
                    ? id
                    : null
            },
            ballotIsCastable() {
                return this.upvote && this.downvote
            }
        }">
        <div class="mt-10 space-y-6">
            <div>
                <h3>Upvote</h3>

                @foreach($this->teammates as $upTarget)
                    <button @click="castUpvote({{ $upTarget->id }})" class="w-full flex flex-row items-center justify-between rounded p-2 bg-gray-800 mt-2">
                        <span>{{ $upTarget->user->name }}</span>
                        <div>
                            <x-heroicon-s-arrow-circle-up x-show="upvote === {{ $upTarget->id }}" class="h-5 w-5 text-green-400" />
                        </div>
                    </button>
                @endforeach
            </div>

            <div>
                <h3>Downvote</h3>

                @foreach($this->targets as $downTarget)
                    <button @click="castDownvote({{ $downTarget->id }})" class="w-full flex flex-row items-center justify-between rounded p-2 bg-gray-800 mt-2">
                        <span>{{ $downTarget->user->name }}</span>
                        <div>
                            <x-heroicon-s-arrow-circle-down x-show="downvote === {{ $downTarget->id }}" class="h-5 w-5 text-green-400" />
                        </div>
                    </button>
                @endforeach
            </div>

            <div class="flex flex-row justify-between items-center">
                <button wire:click="submit" :disabled="!ballotIsCastable()" class="bg-gray-700 px-4 py-2 rounded disabled:opacity-50 disabled:pointer-events-none">Submit Ballot(s)</button>
                <em>This is your last chance. Submitting your ballots is final.</em>
            </div>
        </div>
    </div>
    @endif


</div>
