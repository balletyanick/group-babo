@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Utilisateurs</a></li>
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
                            <form action="{{route('user.save')}}" class="add_user">
                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="row form-material">

                                    <div class="col-md-2 mb-4">
                                        <a href="javascript:void()" style="padding: 40px;padding-right: 45px !important;padding-left: 45px !important;font-size: 25px;" class="btn btn-primary light mr-1 px-3" data-toggle="modal" data-target="#cameraModal"><i class="fa fa-camera"></i> </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="cameraModal">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"> Televerser image</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">Televerser</span>
                                                    </div>
                                                    <div class="custom-file">
                                                    <input type="file" name="avatar" class="custom-file-input dropify" data-default-file="{{$user->avatar!=null ? Storage::url($user->avatar) : ''}}">
                                                    <label class="custom-file-label" data-browse="Parcourir"> Photo de profil </label>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-10 mt-4">
                                        
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Type de compte  </label>
                                        <select name="role_id" id="role_id" class="form-control default-select form-control-sm">
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" {{$role->id==$user->role_id ? 'selected' : ''}}>{{$role->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                   
                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Fonction </label>
                                        <input type="text" class="form-control" name="fonction" value="{{$user->fonction}}">
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Nom  </label>
                                        <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Téléphone </label>
                                        <input type="text" class="form-control" name="phone" value="{{$user->phone}}" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Prénoms </label>
                                        <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Email </label>
                                        <input type="text" name="email" value="{{$user->email}}"  class="form-control">
                                    </div>

                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <h4 style="font-weight:700"> Les accès</h4> 
                                        <hr>

                                        <div class="row form-material"> 
                                            <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                                <label class="form-label"> Mot de passe  </label>
                                                <input type="text" class="form-control" name="password">
                                            </div>
        
                                            <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                                <label class="form-label"> Confirmer mot de passe </label>
                                                <input type="text" name="password_confirmation" class="form-control">
                                            </div> 
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <button id="add_user" class="btn btn-primary"> Enregistrer </button>
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

        $('.add_user').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_user').text();
            var button = $('#add_user');

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

                        window.location='{{route("user.index")}}'
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