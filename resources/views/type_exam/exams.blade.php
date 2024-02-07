@extends('layouts.app')

@section('title', "Liste des examens")

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des examens</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">examens</a></li>
                                    <li class="breadcrumb-item active">Liste des examens</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table" class="table table-bordered dt-responsive table-reponsive table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Examen</th>
                                            <th>Utilisateur</th>
                                            <th>Code</th>
                                            <th>Documents</th>
                                            <th>(Passeport / Carte d'identité / Insu)</th>
                                            <th>Visualiser les documents</th>
                                            <th>Resultat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exams as $exam)
                                            @php
                                                $files = $exam->files ?? $exam->card
                                            @endphp
                                            <tr>
                                                <td>{{$exam->type_exam->name}}</td>
                                                <td>{{$exam->customer->first_name}} {{$exam->customer->last_name}}</td>
                                                <td>{{$exam->code}}</td>
                                                <td>{{$exam->files==null ? 'Non' : 'Oui'}}</td>
                                                <td>{{$exam->card==null ? 'Non' : 'Oui'}}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm btn-block" onclick="openFile([
                                                        @foreach(json_decode($files) as $file)
                                                        {
                                                            src: '{{Storage::url($file)}}',
                                                        },
                                                        @endforeach()
                                                    ])">Visualiser <i class="ri-search-2-line"></i></button>
                                                </td>
                                                <td>
                                                    @if(!is_null($exam->results))
                                                        <button class="btn btn-primary btn-sm btn-block" onclick="openFile([
                                                            @foreach(json_decode($exam->results) as $file)
                                                            {
                                                                src: '{{Storage::url($file)}}',
                                                            },
                                                            @endforeach()
                                                        ])">Voir le resultat <i class="ri-search-2-line"></i></button>
                                                    @else
                                                        <form action="{{route('type_exam.result')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$exam->id}}">
                                                            <div class="input-group">
                                                                <input required name="files[]" class="form-control" type="file" id="formFileMultiple" multiple>
                                                                <button class="btn btn-outline-success material-shadow-none"  id="inputGroupFileAddon04">Valider</button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-separated justify-content-center mb-0">
                                    @if ($exams->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $exams->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif
                        
                                    @foreach ($exams->getUrlRange(1, $exams->lastPage()) as $page => $url)
                                        @if ($page == $exams->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    @if ($exams->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $exams->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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
    <!-- Fancybox CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        function openFile(files){
            $.fancybox.open(files);
        }
    </script>
@endsection 