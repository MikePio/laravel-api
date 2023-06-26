@extends('layouts.app')

@section('content')

<div class="container overflow-auto px-5 pt-5 pb-4 text-center" style="max-height: calc(100vh - 70.24px);">
    {{-- <h1>Home admin</h1> --}}
    {{-- <h1 class="pb-3">Welcome!</h1> --}}
    <h1 class="pb-3">Welcome to our personal portfolio management platform!</h1>
    <p class="fs-5 text">
      Our application offers you an easy and effective way to create, organize and showcase your personal portfolio online.
      <br>
      <br>
      With our CRUD (Create, Read, Update, Delete) system, you can easily add new projects to your portfolio, view details of existing projects, make changes when needed, and even delete projects you no longer want to show.
      <br>
      <br>
      Our intuitive interface allows you to upload images, provide a detailed description of the projects, enter information such as the title, the skills involved, the realization period and more. You can organize your projects into custom categories to make navigation easier for visitors.
      <br>
      <br>
      Whether you are a designer, developer, photographer or artist, our portfolio management system allows you to showcase your work in a professional and engaging way. You can easily share your portfolio with potential clients, collaborators or just friends and family.
      <br>
      <br>
      {{-- Our platform also ensures the security of your data. All information about your portfolio is securely stored and you can access your account from any device at any time.
      <br>
      <br> --}}
      Start building your own portfolio today with our simple and efficient management platform. Show the world your skills and accomplishments in a professional and creative way!
    </p>

    <a href="{{ route('adminprojects.create') }}" class="btn btn-primary mt-2">Add a new project</i></i></a>

</div>

@endsection
