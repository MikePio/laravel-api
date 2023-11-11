@extends('layouts.app')

@section('content')

<div class="container overflow-auto px-5 pt-5 pb-4 text-center" style="max-height: calc(100vh - 70.24px);">
  <h1>Dashboard</h1>
  <h5 class="py-3">Number of projects present: <strong>{{ $n_projects }}</strong></h5>

  {{-- * se esiste almeno un progetto --}}
  @if ($last_project)
    <h1 class="pb-3">Last project added</h1>
    <div class="d-flex align-items-center justify-content-center">
      <h2 class="py-4 me-3">{{ $last_project->name }}
        {{--* button per EDIT (modificare il singolo progetto) --}}
          <a href="{{ route('adminprojects.edit', $last_project) }}" class="btn btn-primary me-1"><i class="fa-solid fa-pencil"></i></a>

        {{--* button per DELETE (eliminare il singolo progetto) --}}
        <form action="{{ route('adminprojects.destroy', $last_project) }}" method="POST" class="d-inline-block mt-0" onsubmit="return confirm('Confirm deletion of the project: {{ $last_project->name }} ?')">
          @csrf
          {{--* aggiungere DELETE perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
          @method('DELETE')
          <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
        </form>

      </h2>
    </div>

    <img src="{{ $last_project->image_path ? asset('storage/' . $last_project->image_path) : Vite::asset('resources/img/placeholder-img.png') }}" class="py-2 w-25" alt="{{ $last_project->image_path == false ? "No image" : $last_project->name }}">
    <h5 class="py-2"><strong class="text-decoration-underline">Id:</strong> {{ $last_project->id }}</h5>
    <h5 class="py-2"><strong class="text-decoration-underline">Slug:</strong> {{ $last_project->slug }}</h5>
    <p class="py-2"><strong class="text-decoration-underline">Description:</strong> {!! $last_project->description !!}</p>
    <h6 class="py-2"><strong class="text-decoration-underline">Category:</strong> {{ $last_project->category }}</h6>
    {{-- * senza orario formattato --}}
    {{-- <h6 class="py-2"><strong class="text-decoration-underline">Start date:</strong> {{ $last_project->start_date }}</h6> --}}
    {{-- <h6 class="py-2"><strong class="text-decoration-underline">End date:</strong> {{ $last_project->end_date }}</h6> --}}
    {{-- * con orario formattato (in ProjectController) --}}
    <h6 class="py-2"><strong class="text-decoration-underline">Start date:</strong> {{ $start_date_formatted }}</h6>
    <h6 class="py-2"><strong class="text-decoration-underline">End date:</strong> {{ $end_date_formatted}}</h6>
    <h6 class="py-2"><strong class="text-decoration-underline">url:</strong> {{ $last_project->url }}</h6>
    <h6 class="py-2"><strong class="text-decoration-underline">Produced for:</strong> {{ $last_project->produced_for }}</h6>
    <h6 class="py-2"><strong class="text-decoration-underline">Collaborators:</strong> {{ $last_project->collaborators }}</h6>

  @elseif (!$last_project)
    <h2 class="py-4">No projects created yet</h2>
  @endif

    <a href="{{ route('adminprojects.create') }}" class="btn btn-primary mt-2">Add a new project</i></i></a>
</div>


{{-- </div> --}}

@endsection
