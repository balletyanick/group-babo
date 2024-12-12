@extends('layouts.app')

@section('title', 'Liste des permissions')

@section('content')

    <div class="main-content">

        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)"> Permissions </a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"> Liste des permissions </a></li>
                    </ol>
                </div>
                <!-- row -->
        
                <div class="row">
                    @if(Auth::user()->permission('AJOUT PERMISSION'))
                        <div class="col-lg-12 py-4 px-4">
                            <a class="btn btn-primary" style="font-size:15px" href="{{route('permission.add',['ajouter'])}}">Ajouter une permission <i class="flaticon-381-add-3 mx-1"></i></a>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="produit" class="table table-bordered table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th> Rôles </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td> {{$permission->name}} </td>
        
                                                    <td>  
                                                        @if(Auth::user()->permission('EDITION PERMISSION') || Auth::user()->permission('SUPPRESSION PERMISSION'))
                                                            <div class="d-flex">
                                                                @if(Auth::user()->permission('EDITION PERMISSION'))
                                                                    <a href="{{route('permission.add',[$permission->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                @endif 
        
                                                                @if(Auth::user()->permission('SUPPRESSION PERMISSION'))
                                                                    <a href="javascript:void(0);" onclick="deleted('{{$permission->id}}','{{route('permission.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                                        @if ($permissions->onFirstPage())
                                            <li class="page-item page-indicator">
                                                <a class="page-link">
                                                <i class="la la-angle-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $permissions->previousPageUrl() }}" rel="prev">
                                                    <i class="mdi mdi-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif
        
                                        @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                                                @if ($page == $permissions->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                    </li>
                                                @endif
                                        @endforeach
        
                                        @if ($permissions->hasMorePages())
                                                <li class="page-item">
                                                    <a href="{{ $permissions->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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