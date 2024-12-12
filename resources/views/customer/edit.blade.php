@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="main-content"> 

        <div class="page-content">
            <div class="container-fluid">
 
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{$title}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Clients</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('customer.save')}}" class="add_customer">
                    @csrf
                    <input type="hidden" name="id" value="{{$customer->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><small>Client</small></h4>
                                            <hr>
                                            <div class="row g-3">
                                                <div class="col-lg-6">

                                                    <div>
                                                        <label class="form-label"> Genre</label>
                                                        <select name="genre" id="genre" class="form-control select2">
                                                            <option> Monsieur </option>
                                                            <option> Madame </option>
                                                            <option> Mademoiselle </option>
                                                        </select>
                                                    </div>
        
                                                    <div class="mt-3">
                                                        <label class="form-label"> Nom </label>
                                                        <input type="text" name="first_name" value="{{ $customer->first_name }}" class="form-control rounded-end" required />
                                                    </div>

                                                    <div class="mt-3">
                                                        <label class="form-label"> Prenoms </label>
                                                        <input type="text" name="last_name" value="{{ $customer->last_name }}" class="form-control rounded-end" required />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    
                                                    <div>
                                                        <label class="form-label">Date de naissance</label>
                                                        <input type="date" name="date_of_birth" value="{{ $customer->date_of_birth }}" class="form-control rounded-end" required />
                                                    </div>

                                                    <div  class="mt-3">
                                                        <label class="form-label">Numero CNI </label>
                                                        <input type="text" name="numero_cni" value="{{ $customer->numero_cni }}" class="form-control rounded-end" required/>
                                                    </div>

                                                    <div  class="mt-3">
                                                        <label class="form-label">Numero de téléphone </label>
                                                        <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control rounded-end"/>
                                                    </div>

                                                </div>

                                                <div class="col-lg-12"> 
                                                    <div>
                                                        <label class="form-label"> Note <small>(Facultatif)</small> </label>
                                                        <input type="text" name="note" value="{{ $customer->note }}" class="form-control rounded-end"/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12"> 
                                                    <button id="add_customer" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </form>
            </div>
            <!-- container-fluid -->
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

        $('.add_customer').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_customer').text();
            var button = $('#add_customer');

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