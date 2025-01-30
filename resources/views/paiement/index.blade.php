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
                <div class="col-lg-12"> 
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th> N Contrat</th>
                                            <th> Client  </th>
                                            <th> Produit & Durée</th>
                                            <th> Début du contrat </th>
                                            <th> Paiement mensuelle </th>
                                            <th> Premier Paiement </th>
                                            <th> Dernier  Paiement </th>
                                            <th>Disponible retrait  </th>
                                            <th> Montant Retiré </th>
                                            <th> Monant Restant </th>
                                            <th> Monant Total </th>
                                            <th>Status </th>
                                            <th> Action  </th>
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
                                                <td>{{date('d/m/Y',strtotime($contrat->date_day))}}</td>
                                                <td>{{$contrat->product->pay_mensuel * $contrat->quantite}}  FCFA </td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_firt_payment))}}</td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_end_payment))}}</td>
                                                <td>{{ $contrat->totalDisponibilite - $contrat->totalPaiementsValides }} FCFA </td>

                                                <td>{{ $contrat->totalPaiementsValides }} FCFA </td>

                                                <td>
                                                    @if($contrat->type_contrat === 'Normal')
                                                        {{ 
                                                            ($contrat->product->duration_contrat * $contrat->product->pay_mensuel * $contrat->quantite) 
                                                            + ($contrat->premier_pay * $contrat->quantite) 
                                                            - $contrat->totalPaiementsValides 
                                                        }} FCFA
                                                    @else
                                                        {{ 
                                                            (($contrat->product->duration_contrat - 1) * $contrat->product->pay_mensuel * $contrat->quantite) 
                                                            + ($contrat->premier_pay * $contrat->quantite) 
                                                            - $contrat->totalPaiementsValides 
                                                        }} FCFA
                                                    @endif
                                                </td>


                                                <td>
                                                    @if($contrat->type_contrat === 'Normal')
                                                        {{ 
                                                            ($contrat->product->duration_contrat * $contrat->product->pay_mensuel * $contrat->quantite) 
                                                            + ($contrat->premier_pay * $contrat->quantite) 
                                                           
                                                        }} FCFA
                                                    @else
                                                        {{ 
                                                            (($contrat->product->duration_contrat - 1) * $contrat->product->pay_mensuel * $contrat->quantite) 
                                                            + ($contrat->premier_pay * $contrat->quantite) 
                                                            
                                                        }} FCFA
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    @php
                                                        $dure_contrat = $contrat->product->duration_contrat;
                                                        $dateFinTimestamp = strtotime("+$dure_contrat months", strtotime($contrat->date_day));
                                                        $todayTimestamp = strtotime(date('Y-m-d'));
                                                    @endphp

                                                    @if ($dateFinTimestamp < $todayTimestamp && $contrat->status == 0)
                                                        <span class="badge badge-success"> Terminé </span>
                                                        
                                                    @elseif ($contrat->status == 1)
                                                        <span class="badge badge-danger"> Résilié </span>
                                                    @else
                                                        <span class="badge badge-warning"> En cours </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(Auth::user()->permission('LISTE VERSEMENT'))
                                                        <div class="d-flex">
                                                            @if(Auth::user()->permission('LISTE VERSEMENT'))
                                                                <a href="{{route('dispo.index',[$contrat->id])}}" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Liste des versements" class="btn btn-primary shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-eye"></i>
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