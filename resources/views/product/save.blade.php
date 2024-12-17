@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="content-body">
            <div class="container-fluid">
				<div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Produit</a></li>
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
                                <form action="{{route('product.save')}}" class="add_product">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <div class="row form-material">
                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label"> Libelle Produit </label>
                                            <input type="text"  name="libelle" value="{{$product->libelle}}" class="form-control" required>
                                        </div>

                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label"> Durée du contrat <small> (En mois) </small> </label>
                                            <input type="number" name="duration_contrat" value="{{$product->duration_contrat}}" class="form-control" required>
                                        </div>

                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label"> Type de vehicule </label>
                                            <select class="default-select wide form-control" id="type" name="type">
                                                <option value="Trycile"> Trycile </option>
                                                <option value="Electrique"> Electrique </option>
                                                <option value="Electrique"> Aloba </option>
                                                <option value="Electrique"> KTM </option>
                                            </select>
                                        </div>

                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label"> Restutition du véhicule </label>
                                            <select class="default-select wide form-control" name="moto_restitue" id="moto_restitue">
                                                <option value="N'est pas restituée"> N'est pas restituée </option>
                                                <option value="Est restitué"> Est restitué </option>
                                            </select>
                                        </div>

                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label"> Description <small> (Facutatif) </small> </label>
                                            <input type="text" class="form-control" name="description" value="{{$product->description}}">
                                        </div>

                                        <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                            <label class="form-label"> Note <small> (Facutatif) </small> </label>
                                            <input type="text" class="form-control" name="note" value="{{$product->note}}">
                                        </div>
                                        <div class="col-xl-12 col-xxl-12 col-md-12 mb-3">
                                            <button id="add_product" class="btn btn-primary"> Enregistrer </button>
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

        $('.add_product').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_product').text();
            var button = $('#add_product');

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

                        window.location='{{route("product.index")}}'
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