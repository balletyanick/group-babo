@extends('layouts.app')

@section('title', "Liste des versements")

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des versements de
                         <span style="color: #cf0013"> {{$contrat->client->customer->first_name}} {{$contrat->client->customer->last_name}} </span> 
                        pour le contrat <span style="color: #cf0013"> {{$contrat->numero_contrat}} </span>  
                    </a></li>
                </ol>
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Date de création
                         <span style="color: #cf0013"> {{date('d/m/Y',strtotime($contrat->date_day))}}</span> 
                    </a></li>
                </ol>

                @if($contrat->type_contrat === 'Promotion')
                    <ol class="breadcrumb mt-3">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"> Paiement Bonus
                            <span style="color: #cf0013"> {{$contrat->premier_pay}} FCFA </span> le  
                            <span style="color: #cf0013"> {{date('d/m/Y',strtotime($contrat->date_firt_payment))}} </span>
                        </a></li>
                    </ol>
                @endif
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>N</th>
                                            <th>Date de paiement </th>
                                            <th>Paiement Mensuel </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($disponibilites as $disponibilite)
                                            <tr>
                                                <td>{{ $disponibilite->compter }}</td>
                                                <td>{{date('d/m/Y',strtotime($disponibilite->date_payment))}}</td>
                                                <td>{{ $disponibilite->amount }} FCFA</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-gutter justify-content-center mb-0">
                                    @if ($disponibilites->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $disponibilites->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($disponibilites->getUrlRange(1, $disponibilites->lastPage()) as $page => $url)
                                            @if ($page == $disponibilites->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($disponibilites->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $disponibilites->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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
                @if(Auth::user()->permission('SUPPRESSION DISPONIBILITE'))
                    <div class="col-lg-12 px-4">
                        <a class="btn btn-primary" style="font-size:15px" onclick="refuser('{{$contrat->id}}','{{route('dispo.delete', ['id' => $contrat->id]) }}')"> Tout Supprimer </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End Page-content -->


@endsection

@section('script')
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