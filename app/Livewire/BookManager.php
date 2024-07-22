<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Author;

class BookManager extends Component
{
    public $books, $title, $genre, $publication_year, $author_id, $book_id;
    public $authors, $selected_author_id;

    public function mount()
    {
        $this->authors = Author::all();
        $this->selected_author_id = null;
        $this->filterBooks();
    }

    public function render()
    {
        $this->filterBooks();
        return view('livewire.book-manager');
    }

    public function filterBooks()
    {
        if ($this->selected_author_id) {
            $this->books = Book::where('author_id', $this->selected_author_id)->get();
        } else {
            $this->books = Book::all();
        }
    }

    public function applyFilter()
    {
        $this->filterBooks();
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'genre' => 'required',
            'publication_year' => 'required|integer',
            'author_id' => 'nullable|exists:authors,id'
        ]);

        if ($this->author_id && Book::where('author_id', $this->author_id)->count() >= 2) {
            session()->flash('error', 'Un autor no puede tener más de dos libros.');
            return;
        }

        Book::updateOrCreate(['id' => $this->book_id], [
            'title' => $this->title,
            'genre' => $this->genre,
            'publication_year' => $this->publication_year,
            'author_id' => $this->author_id
        ]);

        $this->resetFields();
        session()->flash('message', $this->book_id ? 'Libro actualizado.' : 'Libro agregado.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $this->book_id = $id;
        $this->title = $book->title;
        $this->genre = $book->genre;
        $this->publication_year = $book->publication_year;
        $this->author_id = $book->author_id;
    }

    public function delete($id)
    {
        Book::find($id)->delete();
        session()->flash('message', 'Libro eliminado.');
    }

    private function resetFields()
    {
        $this->title = '';
        $this->genre = '';
        $this->publication_year = '';
        $this->author_id = '';
        $this->book_id = '';
    }
}
