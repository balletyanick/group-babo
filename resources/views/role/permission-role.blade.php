@extends('layouts.app')

@section('title', $title)

@section('content')

    

        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)"> Permissions </a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"> {{$title}} </a></li>
                    </ol>
                </div>
                <!-- row -->
        
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{route('set-permission.save')}}" class="set_permission">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input onchange="check_all()" type="checkbox" class="form-check-input" id="all">
                                                        <label class="form-check-label" for="all">TOUT SELECTIONNER</label>
                                                        <input type="hidden" class="form-control" value="{{$role->id}}" name="role_id">
                                                    </div>
                                                    <br><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-md-4">
                                                        <div class="form-check form-switch form-switch-md" dir="ltr">
                                                            <input @if($role->permissions->contains($permission->id)) checked @endif value="{{$permission->id}}" name="permission_id[]" type="checkbox" class="form-check-input" id="{{$permission->id}}">
                                                            <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-lg-3">
                                                <br><br><br>
                                                <button id="add_role" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
        

@endsection

@section('css-link')

    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    
@endsection

@section('script')

    <script>

        function check_all() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var allCheckbox = document.getElementById('all');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = allCheckbox.checked;
            });
        }

        $('.set_permission').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#set_permission').text();
            var button = $('#set_permission');

            button.attr('disabled',true);
            button.text('Veuillez patienter ...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: form,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (result){

                    button.attr('disabled',false);
                    button.text(buttonDefault);

                    if(result.status=="success"){

                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "#4CAF50", // green
                        }).showToast();

                    }else{
                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }
                    window.location.reload();
                },
                error: function(result){

                    button.attr('disabled',false);
                    button.text(buttonDefault);

                    if(result.responseJSON.message){
                        Toastify({
                            text: result.responseJSON.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }else{
                        Toastify({
                            text: "Une erreur c'est produite",
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }

                }
            });
        });

    </script>
   
@endsection