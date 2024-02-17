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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Diagnostiques</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                
                <form action="#" class="#">
                    @csrf
                    <input type="hidden" name="id" value="{{$diagnostic->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Libellé</label>
                                            <input type="text" value="{{$diagnostic->name}}" name="name" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="row py-4 px-2">
                                        <h4>Questionnaires</h4>
                                        <hr>  
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <textarea class="form-control" placeholder="Questions" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="type" id="type" class="form-control rounded-end">
                                                <option>Question à choix unique</option>
                                                <option>Question à choix multiple</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 choice">
                                            <button id="add-choice" type="button"  style="width:100%" class="btn btn-block btn-primary btn-sm mb-1"><i class="ri-add-fill"></i> Ajouter une option</button>
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
        $('#add-choice').on('click',function(){
            $('.choice').append(`
                <div class="row">
                    <div class="col-md-10">
                        <input placeholder="Option de reponse" class="form-control rounded-end mt-1" name="data[]">
                    </div>
                    <div class="col-md-2">
                        <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                    </div>
                </div>
            `);
        });
    </script>

@endsection