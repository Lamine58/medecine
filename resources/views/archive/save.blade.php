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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Patient</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('archive.save')}}" class="add_archive">
                    @csrf
                    <input type="hidden" name="id" value="{{$archive->id}}">
                    <input type="hidden" name="customer_id" value="{{$customer_id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="file" required name="file" class="dropify" data-default-file="{{$archive->file!=null ? Storage::url($archive->file) : ''}}">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row g-3">
    
                                                <div class="col-lg-6">
    
                                                    <div>
                                                        <label class="form-label">Examen</label>
                                                        <select  name="other_exam_id" required class="form-control rounded-end" >
                                                            @foreach($other_exams as $other_exam)
                                                                <option {{$archive->other_exam_id==$other_exam->id}} value="{{$other_exam->id}}">{{$other_exam->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
    
                                                    <div  class="mt-1">
                                                        <label class="form-label">Date</label>
                                                        <input type="date" name="date" value="{{$archive->date}}" class="form-control rounded-end" required/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label">Description</label>
                                                        <textarea name="description" class="form-control rounded-end"  rows="4" required>{{$archive->description}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button id="add_archive" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
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

        $('.add_archive').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_archive').text();
            var button = $('#add_archive');

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

                        window.location='{{route("archive.index",[$customer_id])}}'
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