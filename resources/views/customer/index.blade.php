@extends('layouts.app')

@section('title', 'Liste des patients')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des patients</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                    <li class="breadcrumb-item active">Liste des patients</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-md-4">
                        <a href="{{route('customer.add',['ajouter'])}}" id="add" class="btn btn-primary">Ajouter un patient <i class="ri-add-fill"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table" class="table table-bordered dt-responsive table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nom et prénom</th>
                                            <th>Téléphone</th>
                                            <th>Email</th>
                                            <th>Adresse</th>
                                            <th>Poids</th>
                                            <th>Taille</th>
                                            <th>Medecin</th>
                                            <th>Origine</th>
                                            <th>Situation</th>
                                            <th>Activité</th>
                                            <th>Maladie(s)</th>
                                            <th>Examen(s)</th>
                                            <th>PIN</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td><img width="50" src="{{ $customer->avatar!='' ? Storage::url($customer->avatar) : asset('/images/user.jpeg')}}" alt=""></td>
                                                <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                                <td>{{$customer->phone}}</td>
                                                <td>{{$customer->email}}</td>
                                                <td>{{$customer->location}}</td>
                                                <td>{{$customer->weight}}</td>
                                                <td>{{$customer->size}}</td>
                                                <td>{{$customer->medics}}</td>
                                                <td>{{$customer->origin}}</td>
                                                <td>{{$customer->situation}}</td>
                                                <td>{{$customer->activity}}</td>
                                                <td>{{$customer->diseases}}</td>
                                                <td>{{$customer->exams->count()}}</td>
                                                <td>{{$customer->hash=='HASH' ? '****' : $customer->hash }}</td>
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a href="{{route('archive.add',['ajouter',$customer->id])}}" class="dropdown-item remove-item-btn">
                                                                    <i class="ri-add-fill align-bottom me-2 text-muted" ></i> Ajouter une archive medical
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('archive.index',[$customer->id])}}" class="dropdown-item remove-item-btn">
                                                                    <i class="ri-file-list-2-line align-bottom me-2 text-muted" ></i> Liste des archives médicals
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('measure.index',[$customer->id])}}" class="dropdown-item remove-item-btn">
                                                                    <i class="ri-file-list-2-line align-bottom me-2 text-muted" ></i> Historique des relevés
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('customer.add',[$customer->id])}}" class="dropdown-item remove-item-btn">
                                                                    <i class="ri-user-line align-bottom me-2 text-muted" ></i> Mofification du profil patient
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('customer.history',[$customer->id])}}" class="dropdown-item remove-item-btn">
                                                                    <i class="ri-file-list-2-line align-bottom me-2 text-muted" ></i> Historique de modification
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" onclick="deleted('{{$customer->id}}','{{route('customer.delete')}}')" class="dropdown-item remove-item-btn">
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
                                    @if ($customers->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $customers->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
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