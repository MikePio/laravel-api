@extends('layouts.guest')
@section('content')
  <div class="container overflow-auto p-5 text-center" style="max-height: calc(100vh - 70.24px);">

    <h1 class="m-5">Contacts</h1>

    <h3>Developed By: <a class="text-white" href="https://github.com/MikePio">MikePio</a></h3>

		<div class="text-center text-white  mt-5">

			<!-- Grid container -->
			<div class="container pb-0">

        <h3 class="mb-3" >Socials</h3>
				<!-- Section: Social media -->
				<section class="mb-3">

					<!--
            <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="#!" role="button"><i style="padding: 4px 0px;" class="fab fa-facebook-f"></i></a>

            <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="#!" role="button"><i style="padding: 4px 0px;" class="fab fa-twitter"></i></a>

            <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="#!" role="button"><i style="padding: 4px 0px;" class="fab fa-google"></i></a>
          -->

					<!-- Instagram -->
					<a class="btn btn-outline-light btn-floating m-1 rounded-circle"
						href="https://www.instagram.com/michelepiopilla/" role="button"><i style="padding: 4px 0px;"
							class="fab fa-instagram"></i></a>

					<!-- Linkedin -->
					<a class="btn btn-outline-light btn-floating m-1 rounded-circle"
						href="https://www.linkedin.com/in/michele-pilla/" role="button"><i style="padding: 4px 0px;"
							class="fab fa-linkedin-in"></i></a>

					<!-- Github -->
					<a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="https://github.com/MikePio"
						role="button"><i style="padding: 4px 0px;" class="fab fa-github"></i></a>

				</section>
			</div>
		</div>

    <a class="btn btn-primary link-light link-offset-2 link-underline-opacity-75 link-underline-opacity-100-hover text-white me-3 mt-5" href="/">Home</a>

    {{-- <!-- per occupare lo spazio vuoto -->
    <div style="height: 140px;">
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2023 By
      <a class="text-white" href="https://github.com/MikePio">@MikePio</a>
    </div> --}}

  </div>
@endsection
