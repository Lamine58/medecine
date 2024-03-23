@extends('layouts.app')

@section('title', 'Historique de modfication')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Historique de modfication</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{$customer->first_name}} {{$customer->last_name}}</a></li>
                                    <li class="breadcrumb-item active">Historique de modfication</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table" class="table table-bordered dt-responsive table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Anvant modification</th>
                                            <th>Après modification</th>
                                            <th>Utilisateur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history_customers as $history_customer)
                                            @php
                                                $customer_before = json_decode($history_customer->before);
                                                $customer_after = json_decode($history_customer->after);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <p><img height="150" src="{{ $customer_before->avatar!='' ? Storage::url($customer_before->avatar) : asset('/images/user.jpeg')}}" alt=""></p>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Nom</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->first_name}} {{$customer_before->last_name}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Téléphone</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->phone}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Email</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->email}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Adresse</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->location}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Poids</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->weight}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Taille</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->size}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Médicaments</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->medics}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Origine</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->origin}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Situation</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->situation}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Activité</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->activity}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Maladies</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_before->diseases}}</p></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p><img height="150" src="{{ $customer_after->avatar!='' ? Storage::url($customer_after->avatar) : asset('/images/user.jpeg')}}" alt=""></p>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Nom</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->first_name}} {{$customer_after->last_name}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Téléphone</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->phone}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Email</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->email}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Adresse</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->location}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Poids</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->weight}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Taille</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->size}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Médicaments</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->medics}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Origine</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->origin}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Situation</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->situation}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Activité</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->activity}}</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Maladies</p></div>
                                                        <div class="col-md-8" style="font-weight:bolder"><p>{{$customer_after->diseases}}</p></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{$history_customer->user->first_name}} {{$history_customer->user->last_name}} <br>
                                                        {{$history_customer->panel}} <br>
                                                        {{date('d-m-Y H:i:s',strtotime($history_customer->created_at))}}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-separated justify-content-center mb-0">
                                    @if ($history_customers->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $history_customers->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif
                        
                                    @foreach ($history_customers->getUrlRange(1, $history_customers->lastPage()) as $page => $url)
                                        @if ($page == $history_customers->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    @if ($history_customers->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $history_customers->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
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