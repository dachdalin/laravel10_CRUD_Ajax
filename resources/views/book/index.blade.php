@extends('layouts.app')

@push('add-modal')
{{-- modal for add new book --}}
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="add_book_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-4 bg-light">
            <div class="row">
                <div class="col-lg">
                <label for="name">Name :</label>
                <input type="text" name="name" class="form-control" placeholder="Book Name" required>
                </div>
                <div class="col-lg">
                <label for="year">Year :</label>
                <input type="date" name="year" class="form-control" placeholder="Year" required>
                </div>
            </div>
            <div clasphs="row">
                <div class="my-2 col-lg">
                    <label for="note">Note :</label>
                    <input type="note" name="note" class="form-control" placeholder="Note" required>
                    </div>
                    <div class="my-2">
                        <label for="image">Select Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="add_book_btn" class="btn btn-primary">Add</button>
            </div>
        </form>
        </div>
    </div>
</div>
{{-- modal for edit book --}}
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit New Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="edit_book_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="old_image" id="old_image">
            <div class="modal-body p-4 bg-light">
            <div class="row">
                <div class="col-lg">
                <label for="name">Name :</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-lg">
                <label for="year">Year :</label>
                <input type="date" name="year" id="year" class="form-control" placeholder="Year" required>
                </div>
            </div>
            <div class="row">
                <div class="my-2 col-lg">
                    <label for="note">Note :</label>
                    <input type="note" name="note" id="note" class="form-control" placeholder="Note" required>
                    </div>
                    <div class="my-2">
                        <label for="image">Select Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="mt-2" id="image">

                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="edit_book_btn" class="btn btn-primary">Update</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 ">
            <div class="card shadow">
                <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                <h3 class="text-light">Manage Book</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal"><i
                    class="bi-plus-circle me-2"></i>Add New Book</button>
                </div>
                <div class="card-body" id="show_all_book">
                <h1 class="text-center text-secondary my-5">Loading...</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function(){
            $("#add_book_form").submit(function(e){
                e.preventDefault();
                const form_data = new FormData(this);
                $("#add_book_btn").html('Adding...');
                $.ajax({
                    url: "{{ route('store') }}",
                    method: "POST",
                    data :form_data,
                    cache :false,
                    contentType:false,
                    processData:false,
                    success:function(response){
                        if(response.status == 200){
                            Swal.fire(
                                'Added!',
                                'Your file has been added.',
                                'success'
                            )
                            showAllBook();
                        }
                        $("#add_book_btn").html('Add');
                        $("#add_book_form")[0].reset();
                        $("#addBookModal").modal('hide');
                    }
                });
            });
            // edit form data
            $(document).on('click', '.editIcon', function(e){
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('edit') }}",
                    method: "GET",
                    data :{
                        id:id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response){
                        $("#name").val(response.name);
                        $("#year").val(response.year);
                        $("#note").val(response.note);
                        $("#image").html(
                            '<img src="images/uploads/' + response.image + '" class="img-fluid" width="100" height="100" alt="Responsive image">'
                        );
                        $("#id").val(response.id);
                        $("#old_image").val(response.image);
                    }
                });
            });
            $("#edit_book_form").submit(function(e){
                e.preventDefault();
                const form_data = new FormData(this);
                $("#edit_book_btn").html('Updating...');
                $.ajax({
                    url: "{{ route('update') }}",
                    method: "POST",
                    data :form_data,
                    cache :false,
                    contentType:false,
                    processData:false,
                    success:function(response){
                        if(response.status == 200){
                            Swal.fire(
                                'Updated!',
                                'Your file has been updated.',
                                'success'
                            )
                            showAllBook();
                        }
                        $("#edit_book_btn").html('Add');
                        $("#edit_book_form")[0].reset();
                        $("#editBookModal").modal('hide');
                    }
                });
            });
            $(document).on('click', '.deleteIcon', function(){
                let id = $(this).attr('id');
                let csrf = "{{ csrf_token() }}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete') }}",
                            method: "GET",
                            data :{
                                id:id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response){
                                console.log(response);
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                showAllBook();
                            }
                        });
                    }
                })
            });
            showAllBook();
            function showAllBook() {
            $.ajax({
                url: "{{ route('show') }}",
                method: "GET",
                success: function(response) {
                $("#show_all_book").html(response);
                $("table").DataTable({
                    order: [
                    [0, 'asc']
                    ]
                });
                    
                }
            });
        }

    });
    </script>
@endpush