@extends('layouts.app')

@section('title', "Liste des cotisation")

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des cotisation</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Cotisation</a></li>
                                    <li class="breadcrumb-item active">Liste des cotisation</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table" class="table table-bordered dt-responsive table-reponsive table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Libelle</th>
                                            <th>Description</th>
                                            <th>Montant</th>
                                            <th>Total membre</th>
                                            <th>Périodicité</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contributions as $contribution)
                                            <tr>
                                                <td>{{$contribution->name}}</td>
                                                <td>{{$contribution->description}}</td>
                                                <td>
                                                    {{$contribution->amount}} XOF
                                                </td>
                                                <td>
                                                    {{$contribution->getCustomersForContribution()->count()}}
                                                </td>
                                                <td>{{App\Models\Contribution::period($contribution->period)}}</td>
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item edit-item-btn" href="{{route("contribution.members",[$contribution->id])}}"><i class="ri-user-line align-bottom me-2 text-muted"></i>Liste des membres</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item edit-item-btn" href="#"><i class="ri-coins-line  align-bottom me-2 text-muted"></i>Liste des paiements</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item edit-item-btn" href="{{route('contribution.add',[$contribution->id])}}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Modifier</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" onclick="deleted('{{$contribution->id}}','{{route('contribution.delete')}}')" class="dropdown-item remove-item-btn">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted" ></i> Supprimer
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-separated justify-content-center mb-0">
                                    @if ($contributions->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $contributions->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif
                        
                                    @foreach ($contributions->getUrlRange(1, $contributions->lastPage()) as $page => $url)
                                        @if ($page == $contributions->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    @if ($contributions->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $contributions->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <br>
                        </div>
                    </div><!--end col-->
                    
                </div><!--end row-->

            </div>
            <!-- container-fluid -->
            
        </div>
        <!-- End Page-content -->


@endsection

@section('script')
    <script>
        new DataTable("#table", {
            dom: "Bfrtip",
            paging:false,
            ordering:false,
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });
    </script>
@endsection 