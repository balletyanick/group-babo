@extends('layouts.app')

@section('title', "Liste des paiements")

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des paiements</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contrat</a></li>
                                    <li class="breadcrumb-item active">Liste des paiements</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Display success message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Display error message -->
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
               
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <table id="table" class="table table-bordered dt-responsive table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>N° Contrat</th>
                                            <th>Nom et prenoms</th>
                                            <th> Date de demande</th>
                                            <th> Mode de paiement</th>
                                            <th> Montant </th>
                                            <th> Numéro de téléphone </th>
                                            <th> Date de début </th>
                                            <th> Date de fin </th>
                                            <th> Status </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paiements as $paiement)
                                            <tr>
                                                <td> {{ $paiement->contrat->num_contrat }} </td>
                                                <td> {{ $paiement->customer->user->first_name }} {{ $paiement->customer->user->last_name }}</th>
                                                <td>{{date('d/m/Y',strtotime($paiement->date_demande))}}</td>
                                                <td> {{ $paiement->mode_paiement }} </td>
                                                <td> {{ $paiement->amount }} FCFA</td>
                                                <td> {{ $paiement->contrat->customer->user->phone}} </td>
                                                <td>{{date('d/m/Y',strtotime($paiement->contrat->date_start))}}</td>
                                                <td>{{date('d/m/Y',strtotime($paiement->contrat->date_end))}}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if ($paiement->status == 0) 
                                                            bg-warning  <!-- Orange -->
                                                        @elseif ($paiement->status == 1) 
                                                            bg-success  <!-- Green -->
                                                        @elseif ($paiement->status == 2) 
                                                            bg-danger   <!-- Red -->
                                                        @endif
                                                    ">
                                                        @if ($paiement->status == 0)
                                                            En cours
                                                        @elseif ($paiement->status == 1)
                                                            Accepté
                                                        @elseif ($paiement->status == 2)
                                                            Refusé
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($paiement->status == 0)
                                                        @if(Auth::user()->permission('VALIDER PAIEMENT') || Auth::user()->permission('REFUSER PAIEMENT') )
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                @if(Auth::user()->permission('VALIDER PAIEMENT'))
                                                                    <li>
                                                                        <a class="dropdown-item edit-item-btn"href="{{route('paiement.valider',[$paiement->id])}}" ><i class="ri-check-fill align-bottom me-2 text-muted"></i> Valider</a>
                                                                    </li>
                                                                @endif
                                                                
                                                                @if(Auth::user()->permission('REFUSER PAIEMENT'))
                                                                    <li>
                                                                        <a href="{{route('paiement.refuser',[$paiement->id])}}"  class="dropdown-item remove-item-btn">
                                                                            <i class="ri-close-fill align-bottom me-2 text-muted" ></i> Refuser
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-separated justify-content-center mb-0">
                                    @if ($paiements->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $paiements->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif
                        
                                    @foreach ($paiements->getUrlRange(1, $paiements->lastPage()) as $page => $url)
                                        @if ($page == $paiements->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    @if ($paiements->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $paiements->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <br>
                        </div>
                    </div><!--end col--> 
                    
                </div><!--end row-->

            </div>
            <!-- container-fluid -->
            
        </div>
        <!-- End Page-content -->
    </div>

@endsection

@section('script')
    <script>
        new DataTable("#table", {
            dom: "Bfrtip",
            paging:false,
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });

        new DataTable("#table-insurance", {
            dom: "Bfrtip",
            paging:false,
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });

    </script>
@endsection 