@extends('layouts.app')

@section('content')


<div class="container overflow-auto p-5 d-flex flex-column align-items-center" style="max-height: calc(100vh - 70.24px);">

  <h1>Edit Project: {{ $project->name }}
      {{--* button per DELETE (eliminare il singolo progetto) --}}
      <form action="{{ route('adminprojects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm deletion of the project: {{ $project->name }} ?')">
        @csrf
        {{--* aggiungere DELETE perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-eraser"></i></a>
      </form>
  </h1>

  {{-- {{ $errors }} --}}
  {{-- se $errors->any() è true ci sono degli errori nella sessione  --}}
  @if ($errors->any())

    <div class="alert alert-danger mt-4" role="alert">
      <ul>
        {{-- $errors->all() inserisce gli errori in un array che viene ciclato solo se $errors->any() è true --}}
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>

  @endif

  <form action="{{ route('adminprojects.update', $project) }}" method="POST">
    {{-- //* token IMPORTANTE di verifica validità del form (viene utilizzato per dare una maggiore sicurezza ai dati) --}}
    @csrf
    {{--* aggiungere PUT perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
    @method('PUT')

    <div class="mb-3" style="width: 150vh; max-width: 73vw;">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name Project" value="{{ old('name', $project?->name)}}">
    </div>
    @error('name')
      <p class="text-danger">{{ $message }}</p>
    @enderror
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" placeholder="Category" value="{{ old('category', $project?->category)}}">
    </div>
    @error('category')
      <p class="text-danger">{{ $message }}</p>
    @enderror
    <div class="mb-3">
        <label for="start_date" class="form-label">Start date</label>
        <input type="text" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" placeholder="YYYY-MM-DD" value="{{ old('start_date', $project?->start_date)}}">
    </div>
    @error('start_date')
    <p class="text-danger">{{ $message }}</p>
  @enderror
    <div class="mb-3">
        <label for="end_date" class="form-label">End date</label>
        <input type="text" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" placeholder="YYYY-MM-DD" value="{{ old('end_date', $project?->end_date)}}">
    </div>
    @error('end_date')
    <p class="text-danger">{{ $message }}</p>
  @enderror
    <div class="mb-3">
        <label for="url" class="form-label">url</label>
        <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" placeholder="url" value="{{ old('url', $project?->url)}}">
    </div>
    @error('url')
    <p class="text-danger">{{ $message }}</p>
  @enderror
    <div class="mb-3">
        <label for="produced_for" class="form-label">Produced for</label>
        <input type="text" class="form-control @error('produced_for') is-invalid @enderror" id="produced_for" name="produced_for" placeholder="personal use, name client" value="{{ old('produced_for', $project?->produced_for)}}">
    </div>
    @error('produced_for')
    <p class="text-danger">{{ $message }}</p>
  @enderror
    <div class="mb-3">
        <label for="collaborators" class="form-label">Collaborators</label>
        <input type="text" class="form-control @error('collaborators') is-invalid @enderror" id="collaborators" name="collaborators" placeholder="Collaborators" value="{{ old('collaborators', $project?->collaborators)}}">
    </div>
    @error('collaborators')
    <p class="text-danger">{{ $message }}</p>
  @enderror
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" style="height: 200px;">{{ old('description', $project?->description)}}</textarea>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>

  </form>

</div>

@endsection
