@include('template.head')

<div class="col-md-4">
    <div class="card mb-3 @if($note->status == 1) text-muted bg-light @endif">
        <div class="card-body">
            <h4 class="card-header">{{ $note->title }}</h4>
            <!-- <h5 class="card-title">{{ $note->title }}</h5> -->
            <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
            <p class="card-text">{{ $note->content }}</p>
            <a href="#" wire:click="markAsDone({{ $note->id }})" class="btn btn-secondary @if($note->status == 1) disabled @endif">Done</a>
        </div>
    </div>
</div>
