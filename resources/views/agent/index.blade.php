@extends('layouts.app')

@section('title', "Liste des agents")

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Agent</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des agents </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUT AGENT'))
                    <div class="col-lg-12 pb-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('agent.add',['ajouter'])}}">Ajouter un agent <i class="flaticon-381-add-3 mx-1"></i></a>
                    </div>
                @endif
                <div class="col-lg-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th> Nom & Prénoms </th>
                                            <th> Agence </th>
                                            <th> Localisation </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agenceUsers as $agenceUser)
                                            <tr>
                                                <td> {{$agenceUser->user->first_name}} {{$agenceUser->user->last_name}}</td>
                                                <td>
                                                    <span class="badge light badge-success">
                                                        {{$agenceUser->agence->localisation}}
                                                    </span>
                                                </td>
                                                <td> {{$agenceUser->agence->libelle}} </td>
                                                <td>
                                                    @if(Auth::user()->permission('SUPPRESSION AGENT'))
                                                        <div class="d-flex">
                                                            @if(Auth::user()->permission('SUPPRESSION AGENT'))
                                                                <a href="javascript:void(0);" onclick="deleted('{{$agenceUser->id}}','{{route('agent.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                                    @if ($agenceUsers->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $agenceUsers->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($agenceUsers->getUrlRange(1, $agenceUsers->lastPage()) as $page => $url)
                                            @if ($page == $agenceUsers->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($agenceUsers->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $agenceUsers->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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