@extends('layouts.app')

@section('title', 'Liste des utilisateurs')

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Utilisateurs</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Liste des utilisateurs </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                @if(Auth::user()->permission('AJOUT UTILISATEUR'))
                    <div class="col-lg-12 py-4 px-4">
                        <a class="btn btn-primary" style="font-size:15px" href="{{route('user.add',['ajouter'])}}">Ajouter un utilisateur <i class="flaticon-381-add-3 mx-1"></i></a>
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
                                            <th> Nom & prénoms</th>
                                            <th>Téléphone</th>
                                            <th>Email</th>
                                            <th>Type de compte</th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td><img width="50" style="border-radius: 50px" src="{{ $user->avatar!='' ? Storage::url($user->avatar) : asset('/images/user.jpeg')}}" alt=""></td>
                                                <td> {{$user->first_name}} {{$user->last_name}}</td>
                                                <td>
                                                    <span class="badge light badge-success">
                                                        {{$user->phone}}
                                                    </span>
                                                </td>
                                                <td> {{$user->email}} </td>
                                                <td>{{$user->role->name}}</td>
                                                <td>
                                                    @if(Auth::user()->permission('EDITION UTILISATEUR') || Auth::user()->permission('SUPPRESSION UTILISATEUR'))
                                                        <div class="d-flex">
                                                            @if(Auth::user()->permission('EDITION UTILISATEUR'))
                                                                <a href="{{route('user.add',[$user->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            @endif 

                                                            @if(Auth::user()->permission('SUPPRESSION UTILISATEUR'))
                                                                <a href="javascript:void(0);" onclick="deleted('{{$user->id}}','{{route('user.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                                    @if ($users->onFirstPage())
                                        <li class="page-item page-indicator">
                                            <a class="page-link">
                                            <i class="la la-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            @if ($page == $users->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                    @endforeach

                                    @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $users->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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