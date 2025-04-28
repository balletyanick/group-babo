@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Prêt</a></li>
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
                            <form action="{{route('pret.save_edit')}}" class="add_pret">
                                @csrf
                                <input type="hidden" name="contrat_id" value="{{$pret->contrat_id}}">
                                <input type="hidden" name="id" value="{{$pret->id}}">
                                <div class="row form-material">
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <label class="form-label"> Client & Contrat <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control bg-light" value="{{$pret->contrat->numero_contrat}} - {{$pret->contrat->user->first_name}} {{$pret->contrat->user->last_name}}" readonly>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Montant du prêt <span class="text-danger">*</span>  </label>
                                        <input type="number" name="amount" value="{{$pret->amount}}" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Durée <small> (Mois) </small> <span class="text-danger">*</span>  </label>
                                        <input type="number" name="duration" value="{{$pret->duration}}"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <label class="form-label"> Note </label>
                                        <input type="text" class="form-control" value="{{$pret->note}}" name="note">
                                    </div>
                                    
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mt-3">
                                        <button id="add_pret" class="btn btn-primary"> Enregistrer </button>
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
        $(document).ready(function() {
            $('#mySelect3').select2(); // Remplacez #mySelect par l'ID ou la classe de votre champ
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

        $('.add_pret').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_pret').text();
            var button = $('#add_pret');

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

                        window.location='{{route("pret.index")}}'
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