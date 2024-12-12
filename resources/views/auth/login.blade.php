@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
    <!-- auth page content -->
    
    <div class="authincation h-100"> 
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="#">
                                            <img src="{{asset('assettes/images/babo-white.png')}}" style="height: 100px;border-radius:10px" alt="">
                                        </a>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">ESPACE D'ADMINISTRATION</h4>
                                    <form class="needs-validation user_login" novalidate action="{{route('auth')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email</strong></label>
                                            <input type="email" name="email" id="email" placeholder="Entrer votre email" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Mot de passe</strong></label>
                                            <input type="password" name="password"  class="form-control" placeholder="Enter votre mot de passe" required>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" id="user_login" class="btn text-white btn-block" style="background-color: #cf0013;">CONNEXION</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- end auth page content -->
@endsection

@section('script')

    <script>

        $('.user_login').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#user_login').text();
            var button = $('#user_login');

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

                        window.location='{{route("dashboard")}}'
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