@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="main-content"> 

        <div class="page-content">
            <div class="container-fluid">
 
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{$title}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utilisateur en agence </a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('utilisateur_agence.save')}}" class="add_utilisateur_agence">
                    @csrf
                    <input type="hidden" name="id" value="{{$agenceUser->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><small>Client</small></h4>
                                            <hr>
                                            <div class="row g-3">
                                                <div class="col-lg-6">

                                                    <div>
                                                        <label class="form-label"> Utilisateur </label>
                                                        <select name="user_id" id="user_id" class="form-control select2">
                                                                @foreach($user as $users)
                                                                    <option value="{{$users->id}}" {{$users->id==$agenceUser->user_id ? 'selected' : ''}}>{{$users->first_name}} {{$users->last_name}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label"> Agence </label>
                                                        <select name="agence_id" id="agence_id" class="form-control select2">
                                                                @foreach($agence as $agences)
                                                                    <option value="{{$agences->id}}" {{$agences->id==$agenceUser->user_id ? 'selected' : ''}}>{{$agences->libelle}} </option>
                                                                @endforeach
                                                        </select>  
                                                    </div>
                                                </div>

                                                <div class="col-lg-12"> 
                                                    <button id="add_utilisateur_agence" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button> 
                                                </div>
                                            </div>
                                        </div>
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
            <!-- container-fluid -->
        </div>

@endsection

@section('css-link')
    
@endsection



@section('script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>

        var data;

        function popup(self){
            data = $(self);
            var input_data =  data.parent().find('.data');
            $('#summernote').summernote('code',input_data.val());
        }

        function save_data(){
            var input_data =  data.parent().find('.data');
            $('.bs-example-modal-center').modal('hide');
            input_data.val($("#summernote").val());
        }

        $(document).ready(function() {
            $('.summernote').summernote({height: 600});
        });

        $('.add_utilisateur_agence').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_utilisateur_agence').text();
            var button = $('#add_utilisateur_agence');

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

                        window.location='{{route("utilisateur_agence.index")}}'
                    }else{
                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }
                    
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