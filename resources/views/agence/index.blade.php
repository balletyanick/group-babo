@extends('layouts.app')

@section('title', "Liste des agences")

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Agence</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des agences </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUTER AGENCE'))
                    <div class="col-lg-12 py-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('agence.add',['ajouter'])}}">Ajouter une agence <i class="flaticon-381-add-3 mx-1"></i></a>
                    </div>
                @endif
                <div class="col-lg-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Libelle</th>
                                            <th> Localisation</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agences as $agence)
                                            <tr>
                                                <td> {{$agence->libelle}} </td>
                                                <td>
                                                    <span class="badge light badge-success">
                                                        {{$agence->localisation}}
                                                    </span>
                                                </td>
                                                <td> {{$agence->note}} </td>
                                                <td>
                                                    @if(Auth::user()->permission('EDITION AGENCE') || Auth::user()->permission('SUPPRESSION AGENCE'))
                                                        <div class="d-flex">
                                                            @if(Auth::user()->permission('EDITION AGENCE'))
                                                                <a href="{{route('agence.add',[$agence->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            @endif 

                                                            @if(Auth::user()->permission('SUPPRESSION AGENCE'))
                                                                <a href="javascript:void(0);" onclick="deleted('{{$agence->id}}','{{route('agence.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                                    @if ($agences->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $agences->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($agences->getUrlRange(1, $agences->lastPage()) as $page => $url)
                                            @if ($page == $agences->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($agences->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $agences->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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