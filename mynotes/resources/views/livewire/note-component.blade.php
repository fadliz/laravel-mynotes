
<div>
    <form wire:submit.prevent="save">
        <div class="mb-3">
            <input type="text" class="form-control" wire:model="title" placeholder="Title">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <textarea class="form-control" wire:model="content" placeholder="Content"></textarea>
            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card-deck">
        @foreach ($notes as $note)
            @include('livewire.note-card', ['note' => $note])
        @endforeach
    </div>
</div>
