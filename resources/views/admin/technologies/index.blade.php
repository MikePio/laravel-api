@extends('layouts.app')

@section('content')

<div class="container overflow-auto p-5 d-flex flex-column align-items-center" style="max-height: calc(100vh - 70.24px);">

<h1 class="py-4">Technologies</h1>

@if (session('message'))
  <div class="alert alert-success" role="alert">
    {{ session('message') }}
  </div>
@endif

<p class="text-center fs-6">On this page, you can add a technology, edit a technology name and/or delete a technology. <br>Remember to save the edited technology name.</p>

<form action="{{ route('admintechnologies.store') }}" method="POST">
  <div class="input-group mb-3">
    @csrf
    <input name="name" type="text" class="form-control" placeholder="Enter a technology name" aria-label="Enter a technology name">
    <button class="btn btn-primary" type="submit">Add Technology</button>
  </div>
</form>

<table class="table table-hover">
  <thead class="thead-dark">
    <tr class="">
      <th scope="col">#ID</th>
      <th scope="col">Name</th>
      <th scope="col">Number of projects</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($technologies as $technology)

      <tr>
        <td>{{ $technology->id }}</td>
        <td>
          {{-- ogni id deve essere univoco per ogni form ecco perché si aggiunge l'id del singolo elemento ad edit_form --> id="edit_form{{ $technology->id }}" --}}
          <form action="{{ route('admintechnologies.update', $technology) }}" method="POST" id="edit_form{{ $technology->id }}">
            @csrf
            @method('PUT')
            <input name="name" class="border-0" type="text" value="{{ $technology->name }}">
          </form>
          </td>
            {{-- * numero progetti appartenenti ad un technology di tutti gli utenti  --}}
            {{-- <td>{{ count($technology->projects) }}</td> --}}
            {{-- * numero progetti appartenenti ad un technology dell'utente che ha fatto il login --}}
            <td>{{ $technology->projects->where('user_id', Auth::id())->count() }}</td>

          <td>
          {{--* button per salvare l'EDIT (la modifica del singolo technology) tramite la funzione submitEditForm --}}
          <button onclick="submitEditForm({{ $technology->id }})" title="Save and Update the Technology" class="btn btn-primary" onclick="return confirm('Confirm the edit of this technology: {{ $technology->name }}?')"><i class="fa-solid fa-floppy-disk"></i></button>

          {{--* button per DELETE (eliminare il singolo technology) --}}
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#technology{{ $technology->id }}" title="Delete technology">
          {{-- OPPURE --}}
          {{-- <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Delete technology" style="padding: 6px 12px; width: 42px; height: 38px; display: inline-block;"> --}}
            <i class = "fa-solid fa-trash d-inline"></i>
          </button>

          <!-- Modal -->
          <div class="modal fade text-black" id="technology{{ $technology->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          {{-- OPPURE --}}
          {{-- <div class="modal fade text-black" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Delete technology "<strong>{{ $technology->name }}</strong>"</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this technology?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Return back">Back</button>
                  {{--* button per DELETE (eliminare il singolo progetto) --}}
                  <form action = "{{ route('admintechnologies.destroy', $technology) }}" method = "POST" class="d-inline">
                    @csrf
                    {{--* aggiungere DELETE perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" title="Delete technology">Delete</button>
                  </form>
                </div>
              </div>
            </div>

        </td>
      </tr>

    @endforeach


  </tbody>
</table>

<div>
  {{ $technologies->links() }}
</div>

</div>

<script>
  // * funzione per fare l'edit del form tramite un button fuori dal tag <form></form>
  function submitEditForm(id){
    const form = document.getElementById('edit_form' + id);
    form.submit();
  }
</script>

@endsection
