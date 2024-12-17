@extends('layouts.app')

@section('title', $title)

@section('content')

<div class="content-body">
  <div class="container-fluid">
        <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Clients</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un client</a></li>
					</ol>
        </div>
                <!-- row -->
        <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Ajouter un client </h4>
                            </div>
                            <div class="card-body">
                              <div id="smartwizard" class="form-wizard order-create">
                                <ul class="nav nav-wizard">
                                  <li><a class="nav-link" href="#client_detail_1"> 
                                    <span>1</span> 
                                  </a></li>
                                  <li><a class="nav-link" href="#client_detail_2">
                                    <span>2</span>
                                  </a></li>
                                  <li><a class="nav-link" href="#client_detail_3">
                                    <span>3</span>
                                  </a></li>
                                  <li><a class="nav-link" href="#ayant_droit">
                                    <span>4</span>
                                  </a></li>
                                </ul>
                                <form action="{{route('customer.save_edit')}}" class="edit_customer">
                                  @csrf
                                  <input type="hidden" name="id" value="{{$customer->id}}">
                                  <input type="hidden" name="user_id" value="{{$customer->user_id}}">
                                  <div class="tab-content mt-4">
                                    <div id="client_detail_1" class="tab-pane" role="tabpanel">
                                      <div class="row">
                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Genre  <span class="text-danger">*</span></label>
                                            <select name="genre" class="form-control default-select form-control-sm mb-3">
                                              <option value="Monsieur"> Monsieur </option>
                                              <option value="Madame"> Madame </option>
                                              <option value="Mademoiselle"> Mademoiselle </option>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Situation matrimoniale  <span class="text-danger">*</span></label>
                                            <select name="etat_matrimonial" class="form-control default-select form-control-sm mb-3">
                                              <option value="Célibataire Majeur"> Célibataire & Majeur </option>
                                              <option value="Marié"> Marié </option>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Nom  <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" value="{{$customer->first_name}}" class="form-control"  required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Prénoms <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control" value="{{$customer->last_name}}" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" value="{{$customer->email}}" class="form-control" required>
                                          </div>
                                        </div>

                                      </div>
                                    </div>

                                    <div id="client_detail_2" class="tab-pane" role="tabpanel">
                                      <div class="row">

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Téléphone <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" value="{{$customer->phone}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Date de naissance <span class="text-danger">*</span></label>
                                            <input type="date" name="date_of_birth" value="{{$customer->date_of_birth}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Lieu de naissance <span class="text-danger">*</span></label>
                                            <input type="text" name="place_of_birth" value="{{$customer->place_of_birth}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Quartier <span class="text-danger">*</span></label>
                                            <input type="text" name="neighborhood" value="{{$customer->neighborhood}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Commune <span class="text-danger">*</span></label>
                                            <input type="text" name="common" value="{{$customer->common}}" class="form-control" required>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div id="client_detail_3" class="tab-pane" role="tabpanel">
                                      <div class="row">

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class="form-label"> Pièce d'identité <span class="text-danger">*</span></label>
                                            <select name="name_doc_client" class="form-control default-select form-control-sm mb-3">
                                              <option value="Carte Nationale d'Identité"> Carte Nationale d'Identité </option>
                                              <option value="Carte consulaire"> Carte consulaire </option>
                                              <option value="Passeport"> Passeport </option>
                                              <option value="Extrait de naissance"> Extrait de naissance  </option>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Identifiant de la pièce d'identité <span class="text-danger">*</span></label>
                                            <input type="text" name="numero_cni" value="{{$customer->numero_cni}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class="form-label"> Date de création pièce d'identité </label>
                                            <input type="date" name="date_start_cni" value="{{$customer->date_start_cni}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class="form-label"> Date d'expiration pièce d'Identité </label>
                                            <input type="date" name="date_end_cni" value="{{$customer->date_end_cni}}" class="form-control" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class="form-label"> Profession <span class="text-danger">*</span></label>
                                            <input type="text" name="work" value="{{$customer->work}}" class="form-control" required>
                                          </div>
                                        </div>
                                        
                                        <div class="col-lg-6 mb-3">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Note </label>
                                            <input type="text" name="note_first" value="{{$customer->note_first}}" class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                    </div>  

                                    <div id="ayant_droit" class="tab-pane" role="tabpanel">
                                      <div class="row">
                                        <div class="col-lg-12 py-4">
                                          <h4> Ayant droit (En cas de décès du client) </h4>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <label class=" form-label"> Genre  <span class="text-danger">*</span></label>
                                          <select name="genre_death" class="form-control default-select form-control-sm mb-3">
                                            <option value="Monsieur"> Monsieur </option>
                                            <option value="Madame"> Madame </option>
                                            <option value="Mademoiselle"> Mademoiselle </option>
                                          </select>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Nom  <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name_death" value="{{$customer->first_name_death}}" class="form-control"  required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class="form-label"> Pièce d'identité <span class="text-danger">*</span></label>
                                            <select name="name_doc" class="form-control default-select form-control-sm mb-3">
                                              <option value="Carte Nationale d'Identité"> Carte Nationale d'Identité </option>
                                              <option value="Carte consulaire"> Carte consulaire </option>
                                              <option value="Passeport"> Passeport </option>
                                              <option value="Extrait de naissance"> Extrait de naissance  </option>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <div class="form-group mb-3">
                                              <label class=" form-label"> Prénoms <span class="text-danger">*</span></label>
                                              <input type="text" name="last_name_death" class="form-control" value="{{$customer->last_name_death}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Identifiant (Pièce d'identité) <span class="text-danger">*</span></label>
                                            <input type="text" name="numero_piece_death" class="form-control" value="{{$customer->numero_piece_death}}" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Date de création (Pièce d'identité) </label>
                                            <input type="date" name="date_start_doc_death" class="form-control" value="{{$customer->date_start_doc_death}}" required>
                                          </div>
                                        </div>
    
                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Date d'expiration (Pièce d'identité) </label>
                                            <input type="date" name="date_end_doc_death" class="form-control" value="{{$customer->date_end_doc_death}}" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Date de naissance <span class="text-danger">*</span></label>
                                            <input type="date" name="date_of_birth_death" class="form-control" value="{{$customer->date_of_birth_death}}" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Lieu de naissance <span class="text-danger">*</span></label>
                                            <input type="text" name="place_of_birth_death" class="form-control" value="{{$customer->place_of_birth_death}}" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Lieu de résidence <span class="text-danger">*</span></label>
                                            <input type="text" name="place_death" class="form-control" value="{{$customer->place_death}}" required>
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Téléphone <span class="text-danger">*</span> </label>
                                            <input type="number" name="phone_number_death" class="form-control" value="{{$customer->phone_number_death}}">
                                          </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                          <div class="form-group mb-3">
                                            <label class=" form-label"> Note </label>
                                            <input type="text" name="note_second" class="form-control" value="{{$customer->note_second}}" required>
                                          </div>
                                        </div>

                                        <div class="col-xl-12 col-xxl-12 col-md-12 mt-3">
                                          <button id="edit_customer" class="btn btn-primary"> Enregistrer </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </form>
                              </div>
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

        $('.edit_customer').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#edit_customer').text();
            var button = $('#edit_customer');

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

                        window.location='{{route("customer.index")}}'
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