<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="store">
        <div class="form-group">
            <label for="name">Nombre del Autor</label>
            <input type="text" class="form-control" id="name" wire:model="name">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    <h2 class="mt-4">Lista de Autores</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>
                        <button wire:click="edit({{ $author->id }})" class="btn btn-sm btn-warning">Editar</button>
                        <button wire:click="delete({{ $author->id }})" class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
