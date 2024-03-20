@extends('layouts.app')

@section('title', "Liste des types d'examens")

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des types d'examens</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">types d'examens</a></li>
                                    <li class="breadcrumb-item active">Liste des types d'examens</li>
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
                                            @if($type == '!ADMINISTRATEUR')
                                                <th>Horaire</th>
                                            @endif
                                            <th>Description</th>
                                            <th>Tarif</th>
                                            @if($type == 'ADMINISTRATEUR')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($type_exams as $type_exam)
                                            <tr>
                                                <td>{{$type_exam->name}}</td>
                                                @if($type == '!ADMINISTRATEUR')
                                                    <td>
                                                        @php
                                                            $data = App\Models\TypeExamBusiness::where('business_id',$business_id)->where('type_exam_id',$type_exam->id)->first();
                                                            $data->availability = json_decode($data->availability)
                                                        @endphp
                                                        @if($data->availability->frequence=="evryday")
                                                            <span>Chaque jour à {{$data->availability->evryday_houre}}</span>
                                                        @else
                                                            <span>Chaque {{App\Models\TypeExamBusiness::day($data->availability->day)}} à {{$data->availability->oneday_houre}}</span>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>{{$type_exam->description}}</td>
                                                <td>
                                                    {{$type_exam->price_xof}}XOF<br>
                                                    {{$type_exam->price_euro}}EURO<br>
                                                    {{$type_exam->price_usd}}USD<br>
                                                </td>
                                                @if($type == 'ADMINISTRATEUR')
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item edit-item-btn" href="{{route('type_exam.add',[$type_exam->id])}}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Modifier</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="deleted('{{$type_exam->id}}','{{route('type_exam.delete')}}')" class="dropdown-item remove-item-btn">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted" ></i> Supprimer
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-separated justify-content-center mb-0">
                                    @if ($type_exams->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $type_exams->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif
                        
                                    @foreach ($type_exams->getUrlRange(1, $type_exams->lastPage()) as $page => $url)
                                        @if ($page == $type_exams->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    @if ($type_exams->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $type_exams->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });
    </script>
@endsection 