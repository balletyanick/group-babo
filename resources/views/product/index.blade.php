@extends('layouts.app')

@section('title', "Liste des produits")

@section('content')


<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Produit</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des produits</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            @if(Auth::user()->permission('AJOUT PRODUIT'))
                <div class="col-lg-12 pb-4 px-4">
                    <a class="btn btn-primary" style="font-size:15px" href="{{route('product.add',['ajouter'])}}">Ajouter un produit <i class="flaticon-381-add-3 mx-1"></i></a>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="produit" class="table table-bordered table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Libelle Produit & Durée</th>
                                        <th>Durée</th>
                                        <th>Type</th>
                                        <th>Restutition du véhicule</th>
                                        <th>Description</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td> {{$product->libelle}} - {{$product->duration_contrat}} Mois   </td>
                                            <td> {{$product->duration_contrat}} Mois  </td>
                                            <td>{{$product->type}}</td>
                                            
                                            <td>
                                                <span class="badge light {{ $product->moto_restitue == "N'est pas restituée" ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $product->moto_restitue }}
                                                </span>
                                            </td>

                                            <td> {{$product->description}}  </td>
                                            <td> {{$product->note}} </td>
                                            <td>
                                                @if(Auth::user()->permission('EDITION PRODUIT') || Auth::user()->permission('SUPPRESSION PRODUIT'))
                                                    <div class="d-flex">
                                                        @if(Auth::user()->permission('EDITION PRODUIT'))
                                                            <a href="{{route('product.add',[$product->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        @endif 

                                                        @if(Auth::user()->permission('SUPPRESSION PRODUIT'))
                                                            <a href="javascript:void(0);" onclick="deleted('{{$product->id}}','{{route('product.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                                @if ($products->onFirstPage())
                                    <li class="page-item page-indicator">
                                        <a class="page-link">
                                        <i class="la la-angle-left"></i></a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                                            <i class="mdi mdi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                @endforeach

                                @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $products->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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
