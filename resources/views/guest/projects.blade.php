@extends('layouts.guest')
@section('content')
    <div class="container overflow-auto p-5 text-center" style="max-height: calc(100vh - 70.24px);">
        {{-- <h1>Home guest</h1> --}}
        <h1>Projects</h1>

        <h4 class="mt-4 ms-4">
          The 10 most recently created projects by all users
        </h4>
        <div class="container d-flex flex-wrap align-items-center justify-content-center my-4">

          @foreach ($projects as $project)

              <div class="bg-white rounded-2 text-black my-3 ms-4 me-4" style="width: 460px; max-width: 460px; height: 232px; max-height: 232px">
                <div class="d-flex">
                    <div class="d-flex flex-column d-flex justify-content-center align-items-center">
                        <img src="{{ $project->image_path ? asset('storage/' . $project->image_path) : Vite::asset('resources/img/placeholder-img.png') }}" alt="{{ $project->image_path == false ? "No image" : $project->name }}" class="rounded-start" style="object-fit: cover; height: 232px; width: 232px;">
                    </div>
                    <div class="d-flex flex-column justify-content-start mx-2" style="height: 232px; width: 232px;">
                        <div class="my-3 text-start">
                            <h5>
                                {{ $project->name }}
                            </h5>
                            <p class="badge bg-primary mb-1">{{ $project->type?->name ?? 'No type' }}</p>
                            {{-- <div>{{ $project->category ?? 'No category' }}</div> --}}
                            {{-- @php
                            $date = date_create($project->start_date);
                            @endphp
                            <span>{{ date_format($date, 'd/m/Y') }}</span> --}}
                            {{-- per la prossima volta utilizzare una funzione tipo substr e non una classe css --}}
                            <div class="text-muted custom-card-text" style="width: 205px; height: 75px;">{!! $project->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>

          @endforeach

        </div>

    </div>
@endsection
