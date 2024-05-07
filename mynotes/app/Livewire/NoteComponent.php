<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;

class NoteComponent extends Component
{
    public $title;
    public $content;
    public $notes;

    protected $rules = [
        'title' => 'required|string|min:3|unique:notes',
        'content' => 'required|string',
    ];

    public function mount()
    {
        $this->notes = Note::orderBy('status')->orderBy('created_at', 'desc')->get();
    }


    public function save()
    {
        $this->validate();

        Note::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->title = '';
        $this->content = '';

        session()->flash('message', 'Note created successfully!');
        $this->mount(); 
    }

    public function markAsDone($id)
    {
        $note = Note::findOrFail($id);
        $note->status = 1; // 1 means done
        $note->save();
        session()->flash('message', 'Note marked as done!');
        $this->mount(); 
    }

    public function render()
    {
        return view('livewire.note-component');
    }
}
