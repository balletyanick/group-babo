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
              <div class="col-lg-12 pb-4 px-4">
                  <a class="btn btn-primary" style="font-size:15px" href="{{route('user.add',['ajouter'])}}">Ajouter un client <i class="flaticon-381-add-3 mx-1"></i></a>
              </div>
          @endif
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="user" class="table table-bordered table-responsive-sm">
                              <thead>
                                  <tr>
                                      <th> Genre </th>
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
                                      <th> Note 1  </th>
                                      <th> Note 2 </th>
                                      <th> Actions </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($users as $user)
                                      <tr>
                                          <td> {{$user->genre}}</td>
                                          <td> {{$user->first_name}} {{$user->last_name}}</td>
                                          <td> {{$user->email}}</td>
                                          <td>
                                            <span class="badge light badge-success">
                                                {{$user->phone}}
                                            </span>
                                           </td>
                                          <td> {{date('d/m/Y',strtotime($user->date_of_birth))}}</td>
                                          <td> {{date('d/m/Y',strtotime($user->place_of_birth))}}</td>
                                          <td> {{$user->neighborhood}}</td>
                                          <td> {{$user->common}}</td>
                                          <td> {{$user->name_doc_client}}</td>
                                          <td> {{$user->numero_cni}}</td>
                                          <td> {{date('d/m/Y',strtotime($user->date_start_cni))}}</td>  
                                          <td> {{date('d/m/Y',strtotime($user->date_end_cni))}}</td>
                                          <td> {{$user->genre_death}}</td>
                                          <td> {{$user->first_name_death}} {{$user->last_name_death}}</td>
                                          <td>
                                                <span class="badge light badge-success">
                                                    {{ $user->phone_number_death }}
                                                </span>
                                           </td>
                                          <td> {{$user->name_doc}}</td>
                                          <td> {{$user->numero_piece_death}}</td>
                                          <td> {{date('d/m/Y',strtotime($user->date_start_doc_death))}}</td>
                                          <td> {{date('d/m/Y',strtotime($user->date_end_doc_death))}}</td>
                                          <td> {{date('d/m/Y',strtotime($user->date_of_birth_death))}}</td>
                                          <td> {{$user->place_of_birth_death}}</td>
                                          <td> {{$user->place_death}}</td>
                                          <td> {{$user->note_first}}</td>
                                          <td> {{$user->note_second}}</td>
                                          <td>
                                            @if(Auth::user()->permission('EDITION CLIENT') || Auth::user()->permission('SUPPRESSION CLIENT'))
                                                <div class="d-flex">
                                                    @if(Auth::user()->permission('EDITION CLIENT'))
                                                        <a href="{{route('customer.edit',[$user->id])}}" data-bs-toggle="tooltip" 
                                                            data-bs-placement="top"  title="Modifier" class="btn btn-primary shadow btn-xs sharp me-1 mr-2">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif 

                                                    @if(Auth::user()->permission('SUPPRESSION CLIENT'))
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
      new DataTable("#user", {
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