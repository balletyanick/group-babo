@extends('layouts.app')

@section('title', "Liste des paiements")

@section('content')


    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Paiement</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Historique </a></li>
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
                                            <th> N Contrat  </th>
                                            <th> Client  </th>
                                            <th> Téléphone  </th>
                                            <th> Date de la demande</th>
                                            <th> Montant </th>
                                            <th> Mode de paiement  </th>
                                            <th> Status </th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paiements as $paiement)
                                            <tr>
                                                <td> {{$paiement->contrat->numero_contrat}}</td>
                                                <td> {{$paiement->user->first_name}} {{$paiement->user->last_name}}</td>
                                                <td> {{$paiement->client->customer->phone}}</td>
                                                <td>{{date('d/m/Y',strtotime($paiement->date_demande))}}</td>
                                                <td> 
                                                    <span class="badge light badge-success">
                                                        {{$paiement->amount}} FCFA
                                                    </span>
                                                </td>
                                                <td> {{$paiement->mode_paiement}}</td>
                                                <td>
                                                    @if ($paiement->status == 0)
                                                        <span class="badge badge-warning"> En cours </span>
                                                        
                                                    @elseif ($paiement->status == 1)
                                                        <span class="badge badge-success"> Validé </span>
                                                    @else
                                                        <span class="badge badge-danger"> Refusé </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-gutter justify-content-center mb-0">
                                    @if ($paiements->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paiements->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
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