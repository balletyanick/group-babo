@extends('layouts.app')

@section('title', "Liste des client affecter à un utilulisateur")

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Client</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des clients </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUT AGENT'))
                    <div class="col-lg-12 pb-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('client.add',['ajouter'])}}">Affecter un client <i class="flaticon-381-add-3 mx-1"></i></a>
                    </div>
                @endif
                <div class="col-lg-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th> Utilisateur </th>
                                            <th>  Client</th>
                                            <th> Identifiant Pièce (Client) </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td> {{$client->user->first_name}} {{$client->user->last_name}}</td>
                                                <td> {{$client->customer->first_name}} {{$client->customer->last_name}}</td>
                                                <td>
                                                    <span class="badge light badge-success">
                                                        {{$client->customer->numero_cni}}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if(Auth::user()->permission('SUPPRESSION PARTENAIRE'))
                                                        <div class="d-flex">
                                                            @if(Auth::user()->permission('SUPPRESSION PARTENAIRE'))
                                                                <a href="javascript:void(0);" onclick="deleted('{{$client->id}}','{{route('client.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
                                                                    <i class="fa fa-trash"></i>
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
                                    @if ($clients->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $clients->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                                            @if ($page == $clients->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($clients->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $clients->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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