@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> Contrat employé </a></li>
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
                            <form action="{{route('contrat-employe.save_edit')}}" class="edit_contratsemploye">
                                @csrf
                                <input type="hidden" name="id" value="{{$contratsemploye->id}}">
                                <input type="hidden" name="employe_id" value="{{$contratsemploye->employe_id}}">
                                <div class="row form-material">
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <label  class="form-label"> Employé </label>
                                        <input type="text" class="form-control bg-light" value="{{$contratsemploye->employe->first_name}} {{$contratsemploye->employe->last_name}}" readonly>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Poste <span class="text-danger">*</span> </label>
                                        <input type="text" value="{{$contratsemploye->poste}}" name="poste" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Date début  <span class="text-danger">*</span>  </label>
                                        <input type="date" value="{{$contratsemploye->date_start}}" name="date_start"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Salaire <span class="text-danger">*</span>  </label>
                                      <input type="number" value="{{$contratsemploye->salaire}}" name="salaire"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Durée du contrat <span class="text-danger">*</span>  </label>
                                        <input type="number" value="{{$contratsemploye->time_contrat}}" name="time_contrat"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <label class="form-label"> Note </label>
                                        <input type="text" value="{{$contratsemploye->note}}" class="form-control" name="note">
                                    </div>
                                    
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mt-3">
                                        <button id="edit_contratsemploye" class="btn btn-primary"> Enregistrer </button>
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

        $('.edit_contratsemploye').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#edit_contratsemploye').text();
            var button = $('#edit_contratsemploye');

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

                        window.location='{{route("contrat-employe.index")}}'
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