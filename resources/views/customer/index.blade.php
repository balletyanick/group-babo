@extends('layouts.app')

@section('title', "Liste des clients")

@section('content')

<div class="content-body">
  <div class="container-fluid">
      <div class="page-titles">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="javascript:void(0)"> Clients </a></li>
              <li class="breadcrumb-item active"><a href="javascript:void(0)"> Liste des clients </a></li>
          </ol>
      </div>
      <!-- row -->

      <div class="row">
          @if(Auth::user()->permission('AJOUT CLIENT'))
              <div class="col-lg-12 py-4 px-4">
                  <a class="btn btn-primary" style="font-size:15px" href="{{route('customer.add',['ajouter'])}}">Ajouter un client <i class="flaticon-381-add-3 mx-1"></i></a>
              </div>
          @endif
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="customer" class="table table-bordered table-responsive-sm">
                              <thead>
                                  <tr>
                                      <th> Nom & Prénoms </th>
                                      <th> Email </th>
                                      <th> Téléphone </th>
                                      <th> Date de naissance </th>
                                      <th> Lieu de naissance </th>
                                      <th> Quartier </th>
                                      <th> Commune </th>
                                      <th> Pièce d'Identité </th>
                                      <th> N° pièce </th>
                                      <th> Création pièce </th>
                                      <th> Expriration pièce </th>
                                      <th> Genre (AD) </th>
                                      <th> Nom & prénoms (AD) </th>
                                      <th> Téléphone (AD) </th>
                                      <th> Pièce d'Identité (AD) </th>
                                      <th> Identifiant pièce (AD) </th>
                                      <th> Création pièce (AD) </th>
                                      <th> Expiration pièce (AD) </th>
                                      <th> Date de naissance (AD) </th>
                                      <th> Lieu de naissance (AD) </th>
                                      <th> Lieu de résidence (AD) </th>
                                      <th> Actions </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($customers as $customer)
                                      <tr>
                                          <td> {{$customer->first_name}} {{$customer->last_name}}</td>
                                          <td> {{$customer->email}}</td>
                                          <td>
                                            <span class="badge light badge-success">
                                                {{$customer->phone}}
                                            </span>
                                           </td>
                                          <td> {{date('d/m/Y',strtotime($customer->date_of_birth))}}</td>
                                          <td> {{date('d/m/Y',strtotime($customer->place_of_birth))}}</td>
                                          <td> {{$customer->neighborhood}}</td>
                                          <td> {{$customer->common}}</td>
                                          <td> {{$customer->name_doc_client}}</td>
                                          <td> {{$customer->numero_cni}}</td>
                                          <td> {{date('d/m/Y',strtotime($customer->date_start_cni))}}</td>  
                                          <td> {{date('d/m/Y',strtotime($customer->date_end_cni))}}</td>
                                          <td> {{$customer->genre_death}}</td>
                                          <td> {{$customer->first_name_death}} {{$customer->last_name_death}}</td>
                                          <td>
                                                <span class="badge light badge-success">
                                                    {{ $customer->phone_number_death }}
                                                </span>
                                           </td>
                                          <td> {{$customer->name_doc}}</td>
                                          <td> {{$customer->numero_piece_death}}</td>
                                          <td> {{date('d/m/Y',strtotime($customer->date_start_doc_death))}}</td>
                                          <td> {{date('d/m/Y',strtotime($customer->date_end_doc_death))}}</td>
                                          <td> {{date('d/m/Y',strtotime($customer->date_of_birth_death))}}</td>
                                          <td> {{$customer->place_of_birth_death}}</td>
                                          <td> {{$customer->place_death}}</td>
                                          <td>
                                            @if(Auth::user()->permission('EDITION CLIENT') || Auth::user()->permission('SUPPRESSION CLIENT'))
                                                <div class="d-flex">
                                                    @if(Auth::user()->permission('EDITION CLIENT'))
                                                        <a href="{{route('customer.add',[$customer->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif 

                                                    @if(Auth::user()->permission('SUPPRESSION CLIENT'))
                                                        <a href="javascript:void(0);" onclick="deleted('{{$customer->id}}','{{route('customer.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                              @if ($customers->onFirstPage())
                                  <li class="page-item page-indicator">
                                      <a class="page-link">
                                      <i class="la la-angle-left"></i></a>
                                  </li>
                              @else
                                  <li class="page-item">
                                      <a class="page-link" href="{{ $customers->previousPageUrl() }}" rel="prev">
                                          <i class="mdi mdi-chevron-left"></i>
                                      </a>
                                  </li>
                              @endif

                              @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                      @if ($page == $customers->currentPage())
                                          <li class="page-item active">
                                              <span class="page-link">{{ $page }}</span>
                                          </li>
                                      @else
                                          <li class="page-item">
                                              <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                          </li>
                                      @endif
                              @endforeach

                              @if ($customers->hasMorePages())
                                      <li class="page-item">
                                          <a href="{{ $customers->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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
      new DataTable("#customer", {
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