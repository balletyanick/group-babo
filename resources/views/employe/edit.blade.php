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
                            <form action="{{route('employe.save_edit')}}" class="edit_employe">
                                @csrf
                                <input type="hidden" name="id" value="{{$employe->id}}">
                                <input type="hidden" name="agence_id" value="{{$employe->agence_id}}">
                                <input type="hidden" name="user_id" value="{{$employe->user_id}}">
                                <div class="row form-material">

                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                      <label class="form-label"> Agence <span class="text-danger">*</span> </label>
                                      <input type="text" class="form-control bg-light" value="{{$employe->agence->libelle}}" readonly>
                                    </div>
                                  
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                        <label class="form-label"> Genre <span class="text-danger">*</span> </label>
                                        <select name="genre" class="form-control default-select form-control-sm mb-3">
                                            <option value="Monsieur"> Monsieur </option>
                                            <option value="Madame"> Madame </option>
                                            <option value="Mademoiselle"> Mademoiselle </option>
                                        </select>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Nom <span class="text-danger">*</span> </label>
                                        <input type="text" value="{{$employe->first_name}}" name="first_name" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Prénoms <span class="text-danger">*</span>  </label>
                                        <input type="text" value="{{$employe->last_name}}" name="last_name"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Téléphone <span class="text-danger">*</span>  </label>
                                      <input type="number" value="{{$employe->phone}}" name="phone"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Email <span class="text-danger">*</span>  </label>
                                      <input type="email"  value="{{$employe->email}}" name="email"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Pièce d'identitité <span class="text-danger">*</span>  </label>
                                      <select name="name_doc_client" class="form-control default-select form-control-sm mb-3">
                                        <option value="Carte Nationale d'Identité"> Carte Nationale d'Identité </option>
                                        <option value="Carte consulaire"> Carte consulaire </option>
                                        <option value="Passeport"> Passeport </option>
                                        <option value="Extrait de naissance"> Extrait de naissance  </option>
                                      </select>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Identifiant Pièce d'identitité <span class="text-danger">*</span>  </label>
                                      <input type="text" value="{{$employe->numero_piece}}" name="numero_piece"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Date d'émission de la Pièce d'identitité </label>
                                        <input type="date" value="{{$employe->date_start_doc}}" name="date_start_doc"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Date de d'expiration de la Pièce d'identitité  </label>
                                        <input type="date" value="{{$employe->date_end_doc}}"  name="date_end_doc"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Lieu de naissance <span class="text-danger">*</span>  </label>
                                      <input type="text" value="{{$employe->place_of_birth}}"  name="place_of_birth"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Date de naissance <span class="text-danger">*</span>  </label>
                                      <input type="date" value="{{$employe->date_of_birth}}"  name="date_of_birth"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                      <label class="form-label"> Commune <span class="text-danger">*</span>  </label>
                                      <input type="text" value="{{$employe->common}}"  name="common"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                        <label class="form-label"> Quartier <span class="text-danger">*</span>  </label>
                                        <input type="text" value="{{$employe->neighborhood}}" name="neighborhood"  class="form-control" required>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                      <label class="form-label"> Note </label>
                                      <input type="text" value="{{$employe->note}}" class="form-control" name="note" value="{{$employe->note}}">
                                    </div>
                                    
                                    <div class="col-xl-12 col-xxl-12 col-md-12 mt-3">
                                        <button id="edit_employe" class="btn btn-primary"> Enregistrer </button>
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

        $('.edit_employe').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#edit_employe').text();
            var button = $('#edit_employe');

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