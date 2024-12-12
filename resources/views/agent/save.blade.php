@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Agence</a></li>
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
                            <form action="{{route('agent.save')}}" class="add_agent">
                                @csrf
                                <div class="row form-material">
                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Utilisateur </label>
                                        <select id="mySelect" name="user_id" class="form-control">
                                            @foreach($user as $users)
                                                <option value="{{$users->id}}" {{$users->id==$agenceUser->user_id ? 'selected' : ''}}>{{$users->first_name}} {{$users->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label name="localisation"  class="form-label"> Agence </label>
                                        <select id="mySelect2" name="agence_id" class="form-control">
                                            @foreach($agence as $agences)
                                                <option value="{{$agences->id}}" {{$agences->id==$agenceUser->user_id ? 'selected' : ''}}>{{$agences->libelle}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <button id="add_agent" class="btn btn-primary"> Enregistrer </button>
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#mySelect').select2(); // Remplacez #mySelect par l'ID ou la classe de votre champ
        });
    </script>

<script>
    $(document).ready(function() {
        $('#mySelect2').select2(); // Remplacez #mySelect par l'ID ou la classe de votre champ
    });
</script>





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

        $('.add_agent').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_agent').text();
            var button = $('#add_agent');

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

                        window.location='{{route("agent.index")}}'
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