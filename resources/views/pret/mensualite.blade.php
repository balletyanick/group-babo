@extends('layouts.app')

@section('title', "Liste des mensualités")

@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des mensualités de
                         <span style="color: #cf0013"> {{$pret->contrat->user->first_name}} {{$pret->contrat->user->last_name}} </span> 
                        pour le contrat <span style="color: #cf0013"> {{$pret->contrat->numero_contrat}} </span>  
                    </a></li> 
                </ol>
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Montant à payer
                            <span style="color: #cf0013"> 
                                {{ number_format(($pret->amount * 18 / 100 + $pret->amount) / $pret->duration, 2, ',', '.') }} 
                                FCFA <span style="color: #04284C"> sur </span>  {{ $pret->duration }} Mois 
                            </span> 
                        </a>
                    </li> 
                </ol>
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Période
                        <span style="color: #cf0013"> {{date('d/m/Y',strtotime($pret->date_start))}}</span>  au 
                        <span style="color: #cf0013"> {{date('d/m/Y',strtotime($pret->date_end))}}</span>
                    </a></li>
                </ol>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produit" class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>N Contrat</th>
                                            <th>Date de prélèvement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Conversion des dates en instances Carbon
                                            $start = \Carbon\Carbon::parse($pret->date_start);
                                            $end   = \Carbon\Carbon::parse($pret->date_end);
                                            $current = $start->copy();
                                        @endphp
                                
                                        {{-- Boucle pour afficher chaque date mensuelle sur une ligne distincte --}}
                                        @while($current <= $end)
                                            <tr>
                                                <td>{{ $pret->contrat->numero_contrat }}</td>
                                                <td>{{ $current->format('d/m/Y') }}</td>
                                            </tr>
                                            @php
                                                $current->addMonthNoOverflow();
                                            @endphp
                                        @endwhile
                                    </tbody>
                                </table>
                                
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