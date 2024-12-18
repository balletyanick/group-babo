@extends('layouts.app')

@section('title', "Liste des employés")

@section('content')

<div class="content-body">
  <div class="container-fluid">
      <div class="page-titles">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="javascript:void(0)"> Contrat employé </a></li>
              <li class="breadcrumb-item active"><a href="javascript:void(0)"> Liste contrat employé </a></li>
          </ol>
      </div>
      <!-- row --> 

      <div class="row">
          @if(Auth::user()->permission('LISTE CONTRAT EMPLOYE'))
                <div class="col-lg-12 pb-4 px-4">
                        <a class="btn btn-primary mr-3" href="{{route("contrat-employe.add",['ajouter'])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                            <i class="fa fa-file-text-o mr-2"></i> Créer un contrats 
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
                                        <th> Matricule </th>
                                      <th> Nom & Prénoms </th>
                                      <th> Poste </th>
                                      <th> Salaire (FCFA) </th>
                                      <th> Début du contrat </th>
                                      <th> Durée (Mois)</th>
                                      <th> Date de fin </th>
                                      <th> Status </th>
                                      <th> Note </th>
                                      <th> Actions </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($contratsemployes as $contratsemploye)
                                      <tr>
                                          <td> {{$contratsemploye->employe->mat_employe}} </td>
                                          <td> {{$contratsemploye->employe->first_name}} {{$contratsemploye->employe->last_name}}</td>
                                          <td> {{$contratsemploye->poste}} </td>
                                          <td> {{$contratsemploye->salaire}} </td>
                                          <td>
                                            <span class="badge light badge-success">
                                                {{date('d/m/Y',strtotime($contratsemploye->date_start))}}
                                            </span>
                                           </td>

                                          <td> {{$contratsemploye->time_contrat}} </td>
                                           <td>
                                            <span class="badge light badge-danger">
                                                {{ date('d/m/Y', strtotime("+$contratsemploye->time_contrat months", strtotime($contratsemploye->date_start))) }}
                                            </span>
                                           </td>

                                          <td>

                                            @php
                                                $dateFinTimestamp = strtotime("+$contratsemploye->time_contrat months", strtotime($contratsemploye->date_start));
                                                $todayTimestamp = strtotime(date('Y-m-d'));
                                            @endphp

                                            @if ($dateFinTimestamp < $todayTimestamp && $contratsemploye->status == 0)
                                                <span class="badge badge-danger"> Terminé </span>
                                                
                                            @elseif ($contratsemploye->status == 1)
                                                <span class="badge badge-danger"> Résilié </span>
                                            @else
                                                <span class="badge badge-success"> En cours </span>
                                            @endif

                                          </td>
                                          <td> {{$contratsemploye->note}} </td>
                                          <td>
                                            @if(Auth::user()->permission('EDITION CONTRAT EMPLOYE') || Auth::user()->permission('SUPPRESSION CONTRAT EMPLOYE') || Auth::user()->permission('RESILIATION CONTRAT EMPLOYE'))
                                                <div class="d-flex">
                                                    @if(Auth::user()->permission('EDITION CONTRAT EMPLOYE'))
                                                        <a href="{{route('contrat-employe.edit',[$contratsemploye->id])}}" class="btn btn-primary shadow btn-xs sharp me-1 mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif 

                                                    @if(Auth::user()->permission('SUPPRESSION CONTRAT EMPLOYE') )
                                                        <a href="javascript:void(0);" onclick="deleted('{{$contratsemploye->id}}','{{route('contrat-employe.delete')}}')" id="icone-delete" class="btn btn-danger shadow btn-xs sharp me-1 mr-1">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif

                                                    @if(Auth::user()->permission('RESILIATION CONTRAT EMPLOYE') && ($contratsemploye->status == 0) )
                                                        <a href="javascript:void(0);" onclick="resilier('{{$contratsemploye->id}}','{{route('contrat-employe.resilier')}}')" id="icone-delete" class="btn btn-warning shadow btn-xs sharp me-1 mr-1">
                                                            <i class="fa fa-times"></i>
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
                              @if ($contratsemployes->onFirstPage())
                                  <li class="page-item page-indicator">
                                      <a class="page-link">
                                      <i class="la la-angle-left"></i></a>
                                  </li>
                              @else
                                  <li class="page-item">
                                      <a class="page-link" href="{{ $contratsemployes->previousPageUrl() }}" rel="prev">
                                          <i class="mdi mdi-chevron-left"></i>
                                      </a>
                                  </li>
                              @endif

                              @foreach ($contratsemployes->getUrlRange(1, $contratsemployes->lastPage()) as $page => $url)
                                      @if ($page == $contratsemployes->currentPage())
                                          <li class="page-item active">
                                              <span class="page-link">{{ $page }}</span>
                                          </li>
                                      @else
                                          <li class="page-item">
                                              <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                          </li>
                                      @endif
                              @endforeach

                              @if ($contratsemployes->hasMorePages())
                                      <li class="page-item">
                                          <a href="{{ $contratsemployes->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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