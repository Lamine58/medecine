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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Centres de santés</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('type_exam.save')}}" class="add_type_exam">
                    @csrf
                    <input type="hidden" name="id" value="{{$type_exam->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label">Libellé</label>
                                                        <input type="text" name="name" value="{{$type_exam->name}}" required class="form-control rounded-end" />
                                                    </div>
    
                                                    <div  class="mt-1">
                                                        <label class="form-label">Description</label>
                                                        <textarea rows="5" name="description" class="form-control rounded-end" >{{$type_exam->description}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
    
                                                    <div>
                                                        <label class="form-label">Tarifs</label>
                                                        <input type="number" name="price_xof" placeholder="Prix (XOF)" value="{{$type_exam->price_xof}}"class="form-control rounded-end" />
                                                    </div>
    
                                                    <div  class="mt-1">
                                                        <input type="number" name="price_euro" placeholder="Prix (EURO)" value="{{$type_exam->price_euro}}"class="form-control rounded-end" />
                                                    </div>
                                                    <div  class="mt-1">
                                                        <input type="number" name="price_usd" placeholder="Prix (USD)" value="{{$type_exam->price_usd}}"class="form-control rounded-end" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button id="add_type_exam" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
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

        $('.add_type_exam').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_type_exam').text();
            var button = $('#add_type_exam');

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

                        window.location='{{route("type_exam.index")}}'
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