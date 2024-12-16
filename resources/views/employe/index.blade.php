@extends('layouts.app')

@section('title', "Liste des employés")

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
          @if(Auth::user()->permission('AJOUT EMPLOYE'))
              <div class="col-lg-12 pb-4 px-4">
                    <a class="btn btn-primary mr-3" style="font-size:15px" href="{{route('employe.add',['ajouter'])}}">Employés Cocody 1
                    </a>
                    <a class="btn btn-primary mr-3" style="font-size:15px" href="{{route('employe.add',['ajouter'])}}">Employés Yopougon  
                    </a>
                    <a class="btn btn-primary" style="font-size:15px" href="{{route('employe.add',['ajouter'])}}"> Employés Cocody 2 
                    </a>
              </div>
          @endif
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="employe" class="table table-bordered table-responsive-sm">
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
                                      <th> Actions </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($employes as $employe)
                                      <tr>
                                          <td> {{$employe->first_name}} {{$employe->last_name}}</td>
                                          <td> {{$employe->email}}</td>
                                          <td>
                                            <span class="badge light badge-success">
                                                {{$employe->phone}}
                                            </span>
                                           </td>
                                          <td> {{date('d/m/Y',strtotime($employe->date_of_birth))}}</td>
                                          <td> {{date('d/m/Y',strtotime($employe->place_of_birth))}}</td>
                                          <td> {{$employe->neighborhood}}</td>
                                          <td> {{$employe->common}}</td>
                                          <td> {{$employe->name_doc_client}}</td>
                                          <td> {{$employe->numero_cni}}</td>
                                          <td> {{date('d/m/Y',strtotime($employe->date_start_cni))}}</td>  
                                          <td> {{date('d/m/Y',strtotime($employe->date_end_cni))}}</td>
                                          <td> {{$employe->genre_death}}</td>
                                          <td> {{$employe->first_name_death}} {{$employe->last_name_death}}</td>
                                          <td>
                                                <span class="badge light badge-success">
                                                    {{ $employe->phone_number_death }}
                                                </span>
                                           </td>
                                        
                                          <td>
                                            @if(Auth::user()->permission('EDITION CLIENT') || Auth::user()->permission('SUPPRESSION CLIENT'))
                                                <div class="d-flex">
                                                    @if(Auth::user()->permission('EDITION CLIENT'))
                                                        <a href="{{route('employe.edit',[$employe->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif 

                                                    @if(Auth::user()->permission('SUPPRESSION CLIENT'))
                                                        <a href="javascript:void(0);" onclick="deleted('{{$employe->id}}','{{route('employe.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp">
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
                              @if ($employes->onFirstPage())
                                  <li class="page-item page-indicator">
                                      <a class="page-link">
                                      <i class="la la-angle-left"></i></a>
                                  </li>
                              @else
                                  <li class="page-item">
                                      <a class="page-link" href="{{ $employes->previousPageUrl() }}" rel="prev">
                                          <i class="mdi mdi-chevron-left"></i>
                                      </a>
                                  </li>
                              @endif

                              @foreach ($employes->getUrlRange(1, $employes->lastPage()) as $page => $url)
                                      @if ($page == $employes->currentPage())
                                          <li class="page-item active">
                                              <span class="page-link">{{ $page }}</span>
                                          </li>
                                      @else
                                          <li class="page-item">
                                              <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                          </li>
                                      @endif
                              @endforeach

                              @if ($employes->hasMorePages())
                                      <li class="page-item">
                                          <a href="{{ $employes->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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
      new DataTable("#employe", {
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