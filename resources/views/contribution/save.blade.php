@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{$title}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Cotisations</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('contribution.save')}}" class="add_contribution">
                    @csrf
                    <input type="hidden" name="id" value="{{$contribution->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <div class="mt-2">
                                                        <label class="form-label">Libellé</label>
                                                        <input type="text" name="name" value="{{$contribution->name}}" required class="form-control rounded-end" />
                                                    </div>
    
                                                    <div  class="mt-2">
                                                        <label class="form-label">Description</label>
                                                        <textarea rows="5" name="description" class="form-control rounded-end" >{{$contribution->description}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    @if(Auth::user()->account=='ADMINISTRATEUR')
                                                        <div  class="mt-2">
                                                            <label class="form-label">Superviseurs</label>
                                                            <select id="business_id" class="form-control" name="business_id"> 
                                                                @foreach(App\Models\Business::all() as $business)
                                                                    <option value="{{$business->id}}" {{$business->id==$contribution->business_id ? 'selected' : ''}} >{{$business->legal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <label class="form-label">Periodicité</label>
                                                        <select name="period" id="period" class="form-control rounded-end" >
                                                            <option value="day">Journalier</option>
                                                            <option value="month">Mensuel</option>
                                                            <option value="year">Annuel</option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Montant</label>
                                                        <input type="number" name="amount" placeholder="Montant" value="{{$contribution->amount}}" class="form-control rounded-end" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button id="add_contribution" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </form>


            </div>
            <!-- container-fluid -->
        </div>
        

@endsection

@section('css-link')
    
@endsection

@section('script')

    <script>

        $('.add_contribution').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_contribution').text();
            var button = $('#add_contribution');

            button.attr('disabled',true);
            button.text('Veuillez patienter ...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: form,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (result){

                    button.attr('disabled',false);
                    button.text(buttonDefault);

                    if(result.status=="success"){

                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "#4CAF50", // green
                        }).showToast();

                        window.location='{{route("contribution.index")}}'
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

    </script>
   
@endsection