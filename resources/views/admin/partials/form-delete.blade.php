{{-- * Utilizzato il modal di bootstrap --}}
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#project{{ $project->id }}" title="Delete project">
{{-- OPPURE --}}
{{-- <button type="button" class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Delete project" style="padding: 6px 12px; width: 42px; height: 38px; display: inline-block;"> --}}
  <i class = "fa-solid fa-trash d-inline"></i>
</button>

<!-- Modal -->
<div class="modal fade text-black" id="project{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
{{-- OPPURE --}}
{{-- <div class="modal fade text-black" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete project "<strong>{{ $project->name }}</strong>"</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this project?
      </div>
      <div class="modal-footer">
        <button title="Return back" type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Return back">Back</button>
        {{--* button per DELETE (eliminare il singolo progetto) --}}
        <form action = "{{ route('adminprojects.destroy', $project) }}" method = "POST" class="d-inline">
          @csrf
          {{--* aggiungere DELETE perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
          @method('DELETE')
          <button type = "submit" class = "btn btn-danger" title="Delete project">Delete</a>
        </form>
      </div>
    </div>
  </div>
</div>
