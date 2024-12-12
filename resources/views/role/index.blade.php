@extends('layouts.app')

@section('title', 'Liste des rôles')

@section('content')


<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Rôles</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"> Liste des rôles </a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            @if(Auth::user()->permission('AJOUT ROLE'))
                <div class="col-lg-12 py-4 px-4">
                    <a class="btn btn-primary" style="font-size:15px" href="{{route('role.add',['ajouter'])}}">Ajouter un rôle <i class="flaticon-381-add-3 mx-1"></i></a>
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
                                        <th> Permissions </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td> {{$role->name}} </td>
                                            <td> 
                                                @if(Auth::user()->permission('AJOUT ROLE'))
                                                    <a href="{{route('role.permissions',[$role->id])}}" class="btn btn-primary btn-sm">Permissions</a>
                                                @endif 
                                            </td>

                                            <td>  
                                                @if(Auth::user()->permission('EDITION PRODUIT') || Auth::user()->permission('SUPPRESSION PRODUIT'))
                                                    <div class="d-flex">
                                                        @if(Auth::user()->permission('EDITION PRODUIT'))
                                                            <a href="{{route('role.add',[$role->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        @endif 

                                                        @if(Auth::user()->permission('SUPPRESSION PRODUIT'))
                                                            <a href="javascript:void(0);" onclick="deleted('{{$role->id}}','{{route('role.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                                @if ($roles->onFirstPage())
                                    <li class="page-item page-indicator">
                                        <a class="page-link">
                                        <i class="la la-angle-left"></i></a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $roles->previousPageUrl() }}" rel="prev">
                                            <i class="mdi mdi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                                        @if ($page == $roles->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                @endforeach

                                @if ($roles->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $roles->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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