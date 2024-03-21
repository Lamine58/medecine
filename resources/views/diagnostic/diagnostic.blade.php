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

                
                <form action="{{route('diagnostic.data')}}" class="save" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$diagnostic->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body question">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Libellé</label>
                                            <input type="text" value="{{$diagnostic->name}}" name="name" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="row py-4 px-2">
                                        <h4>Questions <button id="add-question" type="button"  class="btn btn-primary btn-sm"><i class="ri-add-fill"></i> Ajouter une question</button></h4>
                                        <hr>  
                                    </div>
                                    @php $i=0; @endphp
                                    @foreach($diagnostic->questions ?? [] as $data)
                                        <div class="row data-question">
                                            <div class="col-md-1">
                                                <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                @if($i!=0)
                                                    <select name="condition[]" id="type" class="form-control rounded-end form-control-sm">
                                                        <option value="">Si</option>
                                                        @for($j=1;$j<$i+1;$j++)
                                                            <option {{$data->condition==$j ? 'selected' : ''}} value="{{$j}}">Question {{$j}} égale</option>
                                                        @endfor
                                                    </select>
                                                    <input placeholder="Valeur" value="{{$data->condition_value}}" name="condition_value[]" class="form-control form-control-sm rounded-end mt-1" >
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <textarea class="form-control" name="questions[]" placeholder="Questions" rows="3">{{$data->question}}</textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="types[]" id="type" class="form-control rounded-end">
                                                    <option {{$data->type=='Question à choix unique' ? 'selected' : ''}}>Question à choix unique</option>
                                                    <option {{$data->type=='Question à choix multiple' ? 'selected' : ''}}>Question à choix multiple</option>
                                                </select>
                                                <button onclick="add_option(this)" type="button"  style="width:100%" class="btn btn-block btn-primary btn-sm mt-1"><i class="ri-add-fill"></i> Ajouter une option de reponse</button>
                                            </div>
                                            <div class="col-lg-3 choice">
                                                @foreach($data->responses as $response)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input placeholder="Reponse" value="{{$response->reponse}}" name="responses[{{$i}}][]" class="form-control form-control-sm rounded-end mt-1" >
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input placeholder="Point" value="{{$response->point}}" type="number" class="form-control form-control-sm rounded-end mt-1" name="points[{{$i}}][]">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr class="mt-3 mb-3 mx-3">
                                        </div>
                                        @php $i++ @endphp
                                    @endforeach
                                </div>
                                <div class="card-body analyse">
                                    <div class="row py-2 px-2">
                                        <hr>
                                        <h4>Analyse <button id="add-analyse" type="button"  class="btn btn-primary btn-sm"><i class="ri-add-fill"></i> Ajouter une analyse</button></h4>
                                        <hr>  
                                    </div>
                                    @foreach($diagnostic->analyses  ?? [] as $data)
                                        <div class="row">
                                            <div class="col-md-1">
                                                <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control rounded-end" name=signes[]>
                                                    <option {{$data->signe=='Si supérieur à' ? 'selected' : ''}}>Si supérieur à</option>
                                                    <option {{$data->signe=='Si inférieur à' ? 'selected' : ''}}>Si inférieur à</option>
                                                    <option {{$data->signe=='Si égale à' ? 'selected' : ''}}>Si égale à</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" placeholder="Valeur" name="values[]" value="{{$data->value}}" class="form-control">
                                            </div>
                                            <div class="col-md-5">
                                                <textarea class="form-control" name="analyses[]" placeholder="Conseil" rows="3">{{$data->analyse}}</textarea>
                                            </div>
                                            <hr class="mt-3 mb-3 mx-3">
                                        </div>
                                    @endforeach
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-12">
                            <button id="save" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
                        </div>
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
        function add_option(self){

            var choiceParent = $(self).closest('.row');
            var choices = choiceParent.parent().find('.choice');
            var currentIndex = choices.index(choiceParent.find('.choice'));

            $(self).parent().parent().find('.choice').append(`
                <div class="row">
                    <div class="col-md-6">
                        <input placeholder="Reponse" name="responses[${currentIndex}][]" class="form-control form-control-sm rounded-end mt-1" >
                    </div>
                    <div class="col-md-4">
                        <input placeholder="Point" type="number" class="form-control form-control-sm rounded-end mt-1" name="points[${currentIndex}][]">
                    </div>
                    <div class="col-md-2">
                        <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                    </div>
                </div>
            `);
        }

        $("#add-question").on('click',()=>{
            
            let count_question =  $(".data-question").length;
            let condition = '';

            if(count_question>0){

                let options = '';

                for (var j = 1; j <= count_question; j++) {
                    options += '<option value="' + j + '">Question ' + j + ' égale</option>';
                }

                condition = `<select name="condition[]" id="type" class="form-control rounded-end form-control-sm">
                                <option value="">Si</option>
                                `+options+`
                            </select>
                            <input placeholder="Valeur" name="condition_value[]" class="form-control form-control-sm rounded-end mt-1" >`;
            }

            $(".question").append(`
                <div class="row data-question">
                    <div class="col-md-1">
                        <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                    </div>
                    <div class="col-md-2">
                        `+condition+`
                    </div>
                    <div class="col-md-3">
                        <textarea name="questions[]" class="form-control" placeholder="Questions" rows="3"></textarea>
                    </div>
                    <div class="col-md-3">
                        <select name="types[]" id="type" class="form-control rounded-end">
                            <option>Question à choix unique</option>
                            <option>Question à choix multiple</option>
                        </select>
                        <button onclick="add_option(this)" type="button"  style="width:100%" class="btn btn-block btn-primary btn-sm mt-1"><i class="ri-add-fill"></i> Ajouter une option de reponse</button>
                    </div>
                    <div class="col-lg-3 choice">
                    </div>
                    <hr class="mt-3 mb-3 mx-3">
                </div>
            `);
        });

        $("#add-analyse").on('click',()=>{
            $(".analyse").append(`
                <div class="row mt-1">
                    <div class="col-md-1">
                        <button type="buton" onclick="remove_item(this)" class="btn btn-danger btn-sm"><i class="ri-delete-bin-fill"></i></button>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control rounded-end" name=signes[]>
                            <option>Si supérieur à</option>
                            <option>Si inférieur à</option>
                            <option>Si égale à</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="Valeur" name="values[]" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <textarea class="form-control" name="analyses[]" placeholder="Conseil" rows="3"></textarea>
                    </div>
                    <hr class="mt-3 mb-3 mx-3">
                </div>
            `);
        });

        function remove_item(self){
            $(self).parent().parent().remove();
        }



        $('.save').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#save').text();
            var button = $('#save');

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

                        window.location.reload();
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