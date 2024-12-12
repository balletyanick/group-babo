@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="main-content">

       

        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Permission</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
                    </ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> {{$title}} </h4> 
                            </div>
                            <div class="card-body">
                                <form action="{{route('permission.save')}}" class="add_permission">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$permission->id}}">
                                    <div class="row form-material">
        
                                        <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                            <label class="form-label"> permission </label>
                                            <input type="text"  name="name" value="{{$permission->name}}" class="form-control" required>
                                        </div>
                                       
                                        <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                            <button id="add_permission" class="btn btn-primary"> Enregistrer </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        

@endsection

@section('css-link')
    
@endsection

@section('script')

    <script>

        $('.add_permission').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_permission').text();
            var button = $('#add_permission');

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

                        window.location='{{route("permission.index")}}'
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