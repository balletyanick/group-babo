@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> Employe </a></li>
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
                            <form action="{{route('employe.save')}}" class="add_employe">
                                @csrf
                                <input type="hidden" name="id" value="{{$employe->id}}">
                                <div class="row form-material">
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                      <label class="form-label"> Note <small> (Facutatif) </small> </label>
                                      <input type="text" class="form-control" name="note" value="{{$employe->note}}">
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Nom <span class="text-danger">*</span> </label>
                                        <input type="text"  name="first_name" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Prénoms <span class="text-danger">*</span>  </label>
                                        <input type="text" name="last_name"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Téléphone <span class="text-danger">*</span>  </label>
                                      <input type="number" name="phone"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Email <span class="text-danger">*</span>  </label>
                                      <input type="email" name="email"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Lieu de naissance <span class="text-danger">*</span>  </label>
                                      <input type="text" name="place_of_birth"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Date de naissance <span class="text-danger">*</span>  </label>
                                      <input type="date" name="date_of_birth"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Lieu d'habitation <span class="text-danger">*</span>  </label>
                                      <input type="text" name="localisation"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Poste <span class="text-danger">*</span>  </label>
                                      <input type="text" name="fonction"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Salaire <span class="text-danger">*</span>  </label>
                                      <input type="number" name="salaire"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Durée du contrat <span class="text-danger">*</span>  </label>
                                      <input type="number" name="month"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Début du contrat <span class="text-danger">*</span>  </label>
                                      <input type="date" name="date_of_start	"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> RIB   </label>
                                      <input type="number" name="rib"  class="form-control">
                                    </div>


                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <label class="form-label"> Note <small> (Facutatif) </small> </label>
                                        <input type="text" class="form-control" name="note" value="{{$employe->note}}">
                                    </div>
                                    
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <button id="add_employe" class="btn btn-primary"> Enregistrer </button>
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

        $('.add_employe').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_employe').text();
            var button = $('#add_employe');

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

                        window.location='{{route("employe.index")}}'
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