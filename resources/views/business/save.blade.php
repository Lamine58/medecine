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

                <form action="{{route('business.save')}}" class="add_business">
                    @csrf
                    <input type="hidden" name="id" value="{{$business->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="file" name="logo" class="dropify-logo" data-default-file="{{$business->logo!=null ? Storage::url($business->logo) : ''}}">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row g-3">
    
                                                <div class="col-lg-6">
    
                                                    <div>
                                                        <label class="form-label">Raison sociale</label>
                                                        <input type="text" name="legal_name" value="{{$business->legal_name}}" required class="form-control rounded-end" />
                                                    </div>
    
                                                    <div  class="mt-1">
                                                        <label class="form-label">Téléphone</label>
                                                        <input type="text" name="phone" value="{{$business->phone}}"class="form-control rounded-end" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
    
                                                    <div>
                                                        <label class="form-label">Email</label>
                                                        <input type="text" name="email" value="{{$business->email}}"class="form-control rounded-end" />
                                                    </div>
    
                                                    <div  class="mt-1">
                                                        <label class="form-label">Localisation</label>
                                                        <input type="text" name="location" value="{{$business->location}}"class="form-control rounded-end" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button id="add_business" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
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

                @if(!is_null($business->id))

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="table" class="table table-bordered dt-responsive table-reponsive table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Libelle</th>
                                                <th>Horaire</th>
                                                <th>Description</th>
                                                <th>Tarif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($type_exams as $type_exam)
                                                <tr>
                                                    <td>
                                                        <div class="form-check mb-2">
                                                            @if($type_exam->businesses->contains($business->id))
                                                                @php
                                                                    $data = App\Models\TypeExamBusiness::where('business_id',$business->id)->where('type_exam_id',$type_exam->id)->first();
                                                                    $data->availability = json_decode($data->availability)
                                                                @endphp
                                                                <button  onclick="retire('{{$data->id}}','{{route('type_exam_on_business.delete')}}')" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                                                            @else
                                                                <input class="form-check-input selected" type="checkbox" data-id="{{ $type_exam->id }}">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{$type_exam->name}}</td>
                                                    <td class="text-center">
                                                        @if($type_exam->businesses->contains($business->id))
                                                            @if($data->availability->frequence=="evryday")
                                                                <span>Chaque jour à {{$data->availability->evryday_houre}}</span>
                                                            @else
                                                                <span>Chaque {{App\Models\TypeExamBusiness::day($data->availability->day)}} à {{$data->availability->oneday_houre}}</span>
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$type_exam->description}}</td>
                                                    <td>
                                                        {{$type_exam->price_xof}}XOF<br>
                                                        {{$type_exam->price_euro}}EURO<br>
                                                        {{$type_exam->price_usd}}USD<br>
                                                    </td>
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

                @endif


            </div>
            <!-- container-fluid -->
        </div>

        <div id="popupModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="popupModal-close"></button>
                    </div>
                    <form action="{{route('type_exam_on_business.save')}}" class='type_exam_on_business'>
                        @csrf
                        <div class="modal-body">
                            <div class="mt-2">
                                <label for="frequence">Fréquence</label>
                                <select id="frequence" class="form-control rounded-end" name="frequence" required>
                                    <option value="evryday">Quotidien</option>
                                    <option value="oneday">Hebdomadaire</option>
                                </select>
                                <div id="evryday" class="options mt-2">
                                    <label for="heure_quotidien">Heure d'exécution quotidienne</label>
                                    <input class="form-control rounded-end" type="time" id="heure_quotidien" name="evryday_houre">
                                </div>
                                <div id="oneday" class="options mt-2" style="display:none;">
                                    <label for="jour_hebdomadaire">Jour d'exécution hebdomadaire</label>
                                    <select id="jour_hebdomadaire" class="form-control rounded-end" name="day">
                                        <option value="1">Lundi</option>
                                        <option value="2">Mardi</option>
                                        <option value="3">Mercredi</option>
                                        <option value="4">Jeudi</option>
                                        <option value="5">Vendredi</option>
                                        <option value="6">Samedi</option>
                                        <option value="7">Dimanche</option>
                                    </select>
                                    <label for="heure_hebdomadaire" class="mt-2">Heure d'exécution hebdomadaire :</label>
                                    <input type="time" id="heure_hebdomadaire" class="form-control rounded-end" name="oneday_houre">
                                    <input type="hidden" class="form-control rounded-end" name="business_id" value="{{$business->id}}" required>
                                    <input type="hidden" class="form-control rounded-end" id="type_exam_id" name="type_exam_id" value="" required>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                                <button class="btn w-sm btn-success" id="type_exam_on_business">Valider</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        

@endsection

@section('css-link')
    
@endsection

@section('script')

    <script>

        $("#frequence").change(function(){
            var selectedValue = $(this).val();
            $(".options").hide();
            $("#" + selectedValue).show();
        });

        $(".selected").on('click',function(){
            $('#popupModal').modal('show');
            $('#type_exam_id').val($(this).data('id'));
        });

        $('.add_business').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_business').text();
            var button = $('#add_business');

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

                        window.location='{{route("business.index")}}'
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

        
        $('.type_exam_on_business').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#type_exam_on_business').text();
            var button = $('#type_exam_on_business');

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

                        $('#popupModal').modal('hide');
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

        function retire(id,link){

            Swal.fire({
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Êtes-vous sûr?</h4><p class="text-muted mx-4 mb-0">de retirer cet examen du centre ?</p></div></div>',
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
                cancelButtonClass: "btn btn-danger w-xs mb-1",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: link,
                        data: {id:id},
                        dataType: 'json',
                        success: function (result){
                            if(result.status=="success"){
                                Toastify({
                                        text: result.message,
                                        duration: 3000, // 3 seconds
                                        gravity: "top", // Position at the top of the screen
                                        backgroundColor: "#0ab39c", // Background color for success
                                        close: true, // Show a close button
                                    }).showToast();
                                setTimeout(() => {
                                window.location.reload();
                                }, 2000);
                            }else{
                                Toastify({
                                    text: result.message,
                                    duration: 3000, // 3 seconds
                                    gravity: "top", // Position at the top of the screen
                                    backgroundColor: "#e75050", // Background color for success
                                    close: true, // Show a close button
                                }).showToast();
                            }
                        },error: function(){
                            Toastify({
                                text: "Une erreur c'est produite",
                                duration: 3000, // 3 seconds
                                gravity: "top", // Position at the top of the screen
                                backgroundColor: "#e75050", // Background color for success
                                close: true, // Show a close button
                            }).showToast();
                        }
                    });
                }
            });
        }

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