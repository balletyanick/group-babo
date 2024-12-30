@extends('layouts.app')

@section('title', "Liste des factures")

@section('content')


    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Facture</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des factures  </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUT facture'))
                    <div class="col-lg-12 pb-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('contrat.add',['ajouter'])}}">
                            Ajouter un contrat <i class="flaticon-381-add-3 mx-1"></i>
                        </a>
                    </div>
                @endif
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
                                            <th> N Facture</th>
                                            <th> N Contrat  </th>
                                            <th> Client  </th>
                                            <th> Produit  </th>
                                            <th> Montant  </th>
                                            <th> Date de création  </th>
                                            <th> Note </th>
                                            <th> Créer par </th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($factures as $facture)
                                            <tr>
                                                <td> 
                                                    <span class="badge light badge-success">
                                                        {{$facture->numero_facture}}
                                                    </span>
                                                </td>
                                                <td> {{$facture->contrat->numero_contrat}} </td>
                                                <td> {{$facture->customer->first_name}} {{$facture->customer->last_name}}</td>
                                                <td> {{$facture->product->libelle}} - {{$facture->product->duration_contrat}} Mois </td>
                                                <td> {{$facture->product->amout_global}} FCFA </td>
                                                <td>{{date('d/m/Y',strtotime($facture->contrat->date_day))}}</td>
                                                <td> {{$facture->note}}</td>
                                                <td> {{$facture->user->first_name}} {{$facture->user->last_name}}</td>
                                                <td>
                                                    @if(Auth::user()->permission('SUPPRESSION FACTURE') || Auth::user()->permission('TELECHARGER FACTURE') )
                                                        <div class="d-flex">
        
                                                            @if(Auth::user()->permission('SUPPRESSION FACTURE') )
                                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Supprimer" onclick="deleted('{{$facture->id}}','{{route('facture.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp me-1 mr-2">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            @endif

                                                            @if(Auth::user()->permission('TELECHARGER FACTURE'))
                                                                    <a href="{{ route('facture.download', ['id' => $facture->id]) }}" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Télécharger" class="btn btn-success shadow btn-xs sharp me-1 mr-2">
                                                                        <i class="fa fa-download mt-1"></i>
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
                                    @if ($factures->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $factures->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($factures->getUrlRange(1, $factures->lastPage()) as $page => $url)
                                            @if ($page == $factures->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($factures->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $factures->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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