<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Author;

class AuthorManager extends Component
{
    public $authors, $name, $author_id;

    public function render()
    {
        $this->authors = Author::all();
        return view('livewire.author-manager');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::updateOrCreate(['id' => $this->author_id], [
            'name' => $this->name,
        ]);

        $this->resetFields();
        session()->flash('message', $this->author_id ? 'Autor actualizado.' : 'Autor agregado.');
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);
        $this->author_id = $id;
        $this->name = $author->name;
    }

    public function delete($id)
    {
        Author::find($id)->delete();
        session()->flash('message', 'Autor eliminado.');
    }

    private function resetFields()
    {
        $this->name = '';
        $this->author_id = '';
    }
}

