@extends('layouts.app')

@section('title', "Liste des contrats")

@section('content')


    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Contrat</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des contrats  </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUT CONTRAT'))
                    <div class="col-lg-12 pb-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('contrat.add',['ajouter'])}}">
                            Ajouter un contrat <i class="flaticon-381-add-3 mx-1"></i>
                        </a>
                    </div>
                @endif
                <div class="col-lg-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th> N Contrat</th>
                                            <th> Client  </th>
                                            <th> Produit & Durée</th>
                                            <th> Methode de Versement </th>
                                            <th> Début du contrat </th>
                                            <th> Paiement mensuelle </th>
                                            <th> Premier Paiement </th>
                                            <th> Dernier  Paiement </th>
                                            <th> Agence </th>
                                            <th> Enregistrer par  </th>
                                            <th> Note  </th>
                                            <th>Status </th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contrats as $contrat)
                                            <tr>
                                                <td> 
                                                    <span class="badge light badge-success">
                                                        {{$contrat->numero_contrat}}
                                                    </span>
                                                </td>

                                                <td> {{$contrat->client->customer->first_name}} {{$contrat->client->customer->last_name}}</td>
                                                <td>{{$contrat->quantite}}  {{$contrat->product->libelle}} - {{$contrat->product->duration_contrat}} Mois</td>
                                                <td>{{$contrat->method_versement}} </td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_day))}}</td>
                                                <td>{{$contrat->product->pay_mensuel * $contrat->quantite}}  FCFA </td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_firt_payment))}}</td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_end_payment))}}</td>
                                                <td>{{$contrat->agence->libelle}} </td>
                                                <td> {{$contrat->user->first_name}} {{$contrat->user->last_name}}</td>
                                                <td>{{$contrat->note}} </td>
                                                
                                                <td>
                                                    @php
                                                        $dure_contrat = $contrat->product->duration_contrat;
                                                        $dateFinTimestamp = strtotime("+$dure_contrat months", strtotime($contrat->date_day));
                                                        $todayTimestamp = strtotime(date('Y-m-d'));
                                                    @endphp

                                                    @if ($dateFinTimestamp < $todayTimestamp && $contrat->status == 0)
                                                        <span class="badge badge-danger"> Terminé </span>
                                                        
                                                    @elseif ($contrat->status == 1)
                                                        <span class="badge badge-danger"> Résilié </span>
                                                    @else
                                                        <span class="badge badge-success"> En cours </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if(Auth::user()->permission('EDITION CONTRAT') || Auth::user()->permission('SUPPRESSION CONTRAT') || Auth::user()->permission('RESILIATION CONTRAT') || Auth::user()->permission('TELECHARGER CONTRAT') || Auth::user()->permission('ENVOYER MESSAGE PERSONNEL'))
                                                        <div class="d-flex">

                                                            @if(Auth::user()->permission('GENERATION CONTRAT'))
                                                                <a href="{{route('contrat.generate_and_save',[$contrat->id])}}" data-bs-toggle="tooltip" 
                                                                data-bs-placement="top"  title="Générer le contrat" class="btn btn-info shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-repeat"></i>
                                                                </a>
                                                            @endif 

                                                            @if(Auth::user()->permission('TELECHARGER CONTRAT'))
                                                                @if($contrat->chemin_file)
                                                                    <a href="{{ route('contrat.download', ['id' => $contrat->id]) }}" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Télécharger" class="btn btn-success shadow btn-xs sharp me-1 mr-2">
                                                                        <i class="fa fa-download mt-1"></i>
                                                                    </a>
                                                                @endif
                                                            @endif 

                                                            @if(Auth::user()->permission('EDITION CONTRAT'))
                                                                <a href="{{route('contrat.edit',[$contrat->id])}}" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Modifier" class="btn btn-primary shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            @endif 
        
                                                            @if(Auth::user()->permission('SUPPRESSION CONTRAT') )
                                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Supprimer" onclick="deleted('{{$contrat->id}}','{{route('contrat.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            @endif

                                                            @if(Auth::user()->permission('RESILIATION CONTRAT') && ($contrat->status == 0) )
                                                                <a href="javascript:void(0);" title="Résilier" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  onclick="resilier('{{$contrat->id}}','{{route('contrat.resilier')}}')" id="icone-delete" class="btn btn-warning shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            @endif

                                                            @if(Auth::user()->permission('ENVOYER MESSAGE PERSONNEL'))
                                                                <a href="{{route('sms.send',[$contrat->id])}}" title="Envoyer un SMS" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  class="btn btn-secondary shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-comment"></i>
                                                                </a>
                                                            @endif 

                                                            @if(Auth::user()->permission('GENERATION FACTURE'))
                                                            <a href="{{route('contrat.generate_facture',[$contrat->id])}}" title="Générer facture" data-bs-toggle="tooltip" 
                                                                data-bs-placement="top"  class="btn btn-secondary shadow btn-xs sharp me-1 mr-2">
                                                                <i class="fa fa-file-text-o"></i>
                                                            </a>
                                                        @endif 
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-gutter justify-content-center mb-0">
                                    @if ($contrats->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $contrats->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($contrats->getUrlRange(1, $contrats->lastPage()) as $page => $url)
                                            @if ($page == $contrats->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($contrats->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $contrats->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                    @else
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="mdi mdi-chevron-right"></i></span>
                                            </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-- End Page-content -->


@endsection

@section('script')

<!-- Info Bulle -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

</script>

<script>
    $(document).ready(function() {
        new DataTable("#produit", {
            dom: "Bfrtip",
            paging: false,
            buttons: ["excel"],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json"
            }
        });
    });
</script>
@endsection