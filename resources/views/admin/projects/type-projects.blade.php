@extends('layouts.app')

@section('content')

<div class="container overflow-auto p-5 d-flex flex-column align-items-center" style="max-height: calc(100vh - 70.24px);">

<h1 class="py-4">Types And Projects</h1>

<table class="table table-hover">
  <thead class="thead-dark">
    <tr class="">
      <th scope="col">#ID</th>
      <th scope="col">Type</th>
      <th scope="col">Projects</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($types as $type)

      <tr>
        <td>{{ $type->id }}</td>
        <td>{{ $type->name }}</td>
        <td class=" py-0 my-0">
          <ul class="list-unstyled py-0 my-0">
            @forelse ($type->projects as $project)
              {{-- * progetti appartenenti ad un type di tutti gli utenti ma grazie alla query nel controller vengono mostrati solo quelli dell'utente loggato --}}
              <li class="@if (!$loop->first) border-top @endif h-100 py-2 my-0">- <a href="{{ route('adminprojects.show', $project) }}" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{{ $project->name }}</a></li>
              {{--* soluzione alternativa peggiore - facendo una query che ottiene tutti i progetti, si ottiene numero progetti appartenenti ad un type dell'utente che ha fatto il login (non compare il messaggio "There are not projects" se non ci sono progetti associati al type) --}}
              {{-- @if ($project->user_id === Auth::id())
                <li class="h-100 py-2 my-0">- <a href="{{ route('adminprojects.show', $project) }}" class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{{ $project->name }}</a></li>
              @endif --}}
            @empty
              <li class="py-2 my-0">There are not projects</li>
            @endforelse
          </ul>
        </td>
      </tr>

    @endforeach


  </tbody>
</table>

<div>
  {{ $types->links() }}
</div>

</div>

@endsection
