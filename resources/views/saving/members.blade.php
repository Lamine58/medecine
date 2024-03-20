@extends('layouts.app')

@section('title', 'Liste des membres')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des membres</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">membres</a></li>
                                    <li class="breadcrumb-item active">Liste des membres</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>Nom et prénom</th>
                                            <th>Téléphone</th>
                                            <th>Email</th>
                                            <th>Superviseurs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            @php
                                                $verify = App\Models\CustomerSaving::isExist($customer->id,$saving->id)
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input style="cursor:pointer" {{$verify===true ? 'checked' : ''}} class="form-check-input selected" type="checkbox" data-id="{{ $saving->id }}" data-customer-id="{{ $customer->id }}">
                                                </td>
                                                <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                                <td>{{$customer->phone}}</td>
                                                <td>{{$customer->email}}</td>
                                                <td>{{$customer->business->legal_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
        

        $(".selected").on('click',function(){

            $.ajax({
                type: 'GET',
                url: '{{route("saving.set_set_customer")}}',
                data: {
                    saving_id:$(this).data('id'),
                    customer_id:$(this).data('customer-id')
                },
                dataType: 'json',
                success: function (result){

                    if(result.status=="success"){

                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "#4CAF50", // green
                        }).showToast();

                        //window.location='{{route("business.index")}}'
                    }else{
                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }
                    
                },
                error: function(result){

                    button.attr('disabled',false);
                    button.text(buttonDefault);

                    if(result.responseJSON.message){
                        Toastify({
                            text: result.responseJSON.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }else{
                        Toastify({
                            text: "Une erreur c'est produite",
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }

                }
            });
        });
        new DataTable("#table", {
            dom: "Bfrtip",
            // paging:false,
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });
    </script>
    
@endsection 