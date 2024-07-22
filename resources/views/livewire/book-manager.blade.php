<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Selección del Autor y Botón de Filtro -->
    <div class="form-group">
        <label for="filter_author">Filtrar por Autor</label>
        <select class="form-control" id="filter_author" wire:model="selected_author_id">
            <option value="">Todos los autores</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>
    </div>
    <button wire:click="applyFilter" class="btn btn-primary">Aplicar Filtro</button>

    <!-- Formulario para Agregar o Editar Libros -->
    <form wire:submit.prevent="store">
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" wire:model="title">
        </div>
        <div class="form-group">
            <label for="genre">Género</label>
            <input type="text" class="form-control" id="genre" wire:model="genre">
        </div>
        <div class="form-group">
            <label for="publication_year">Año de Publicación</label>
            <input type="number" class="form-control" id="publication_year" wire:model="publication_year">
        </div>
        <div class="form-group">
            <label for="author_id">Autor</label>
            <select class="form-control" id="author_id" wire:model="author_id">
                <option value="">Sin asignar</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    <!-- Tabla de Libros -->
    <h2 class="mt-4">Lista de Libros</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Género</th>
                <th>Año de Publicación</th>
                <th>Autor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->genre }}</td>
                    <td>{{ $book->publication_year }}</td>
                    <td>{{ $book->author ? $book->author->name : 'Sin asignar' }}</td>
                    <td>
                        <button wire:click="edit({{ $book->id }})" class="btn btn-sm btn-warning">Editar</button>
                        <button wire:click="delete({{ $book->id }})" class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
