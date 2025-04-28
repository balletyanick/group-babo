@extends('layouts.app')

@section('title', "Liste des prêts")

@section('content')


    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> Prêt </a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des prets   </a></li>
                </ol>
            </div> 
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUT PRET'))
                    <div class="col-lg-12 pb-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('pret.add',['ajouter'])}}">
                            Demander un prêt <i class="flaticon-381-add-3 mx-1"></i>
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
                                            <th> Client </th>
                                            <th> Contrat </th>
                                            <th> Date demande </th>
                                            <th> Duréé </th>
                                            <th> Montant prêt </th>
                                            <th> Montant des intérêts </th>
                                            <th> Total à remboursé </th>
                                            <th> Montant remboursé par mois </th>
                                            <th> Début du remboursement  </th>
                                            <th> Fin du remboursement </th>
                                            <th> Status </th>
                                            <th> Note  </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prets as $pret)
                                            <tr>
                                                <td> {{ $pret->contrat->user->first_name }} {{ $pret->contrat->user->last_name }} </td>
                                                <td> 
                                                    <span class="badge light badge-success">
                                                        {{ $pret->contrat->numero_contrat }} 
                                                    </span>
                                                </td>
                                                <td>{{date('d/m/Y',strtotime($pret->date_day))}}</td>
                                                <td> {{ $pret->duration }} Mois </td>
                                                <td> {{ $pret->amount }} FCFA </td>

                                                <td> {{ number_format($pret->amount * 18 / 100, 0, ',', '.') }} FCFA </td>
                                                <td> {{ number_format($pret->amount * 18 / 100 + $pret->amount, 0, ',', '.') }} FCFA </td>

                                                <td> 
                                                    {{ number_format(($pret->amount * 18 / 100 + $pret->amount) / $pret->duration, 0, ',', '.') }} 
                                                    FCFA sur <span class="badge light badge-danger"> {{ $pret->duration }} Mois </span>
                                                </td>
                                                <td>{{date('d/m/Y',strtotime($pret->date_start))}}</td>
                                                <td>{{date('d/m/Y',strtotime($pret->date_end))}}</td>
                                                
                                                <td>
                                                    @if ($pret->status == 0)
                                                        <span class="badge badge-warning"> En cours </span>
                                                    @elseif ($pret->status == 1)
                                                        <span class="badge badge-success"> Validé </span>
                                                    @else
                                                        <span class="badge badge-danger"> Refusé </span>
                                                    @endif
                                                </td>

                                                <td> {{ $pret->note }}  </td>

                                                <td>
                                                    @if(Auth::user()->permission('LISTE MENSUALITE PRET'))
                                                        <div class="d-flex">
                                                            @if(Auth::user()->permission('LISTE MENSUALITE PRET'))
                                                                <a href="{{route('pret.mensualite',[$pret->id])}}" data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"  title="Voir" class="btn btn-primary shadow btn-xs sharp me-1 mr-2">
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
                                    @if ($prets->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $prets->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($prets->getUrlRange(1, $prets->lastPage()) as $page => $url)
                                            @if ($page == $prets->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($prets->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $prets->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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