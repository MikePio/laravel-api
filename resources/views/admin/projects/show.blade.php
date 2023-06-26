@extends('layouts.app')

@section('content')


<div class="container overflow-auto p-5 d-flex flex-column align-items-center" style="max-height: calc(100vh - 70.24px);">

  {{-- @dump($project); --}}
  <h1 class="py-4">{{ $project->name }}
    {{--* button per EDIT (modificare il singolo progetto) --}}
    <a href="{{ route('adminprojects.edit', $project) }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>

    {{--* button per DELETE (eliminare il singolo progetto) --}}
    <form action="{{ route('adminprojects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm deletion of the project: {{ $project->name }} ?')">
      @csrf
      {{--* aggiungere DELETE perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
      @method('DELETE')
      <button type="submit" class="btn btn-danger"><i class="fa-solid fa-eraser"></i></a>
    </form>
  </h1>

  <img src="{{ asset('storage/' . $project->image_path) }}" class="py-2 w-25" alt="{{ $project->name }}">
  <h5 class="py-2"><strong class="text-decoration-underline">Id:</strong> {{ $project->id }}</h5>
  <h5 class="py-2"><strong class="text-decoration-underline">Slug:</strong> {{ $project->slug }}</h5>
  <p class="py-2"><strong class="text-decoration-underline">Description:</strong> {!! $project->description !!}</p>
  <h6 class="py-2"><strong class="text-decoration-underline">Category:</strong> {{ $project->category }}</h6>
  {{-- * senza orario formattato --}}
  {{-- <h6 class="py-2"><strong class="text-decoration-underline">Start date:</strong> {{ $project->start_date }}</h6> --}}
  {{-- <h6 class="py-2"><strong class="text-decoration-underline">End date:</strong> {{ $project->end_date }}</h6> --}}
  {{-- * con orario formattato (in ProjectController) --}}
  <h6 class="py-2"><strong class="text-decoration-underline">Start date:</strong> {{ $start_date_formatted }}</h6>
  <h6 class="py-2"><strong class="text-decoration-underline">End date:</strong> {{ $end_date_formatted}}</h6>
  <h6 class="py-2"><strong class="text-decoration-underline">url:</strong> {{ $project->url }}</h6>
  <h6 class="py-2"><strong class="text-decoration-underline">Produced for:</strong> {{ $project->produced_for }}</h6>
  <h6 class="py-2"><strong class="text-decoration-underline">Collaborators:</strong> {{ $project->collaborators }}</h6>

</div>

@endsection
