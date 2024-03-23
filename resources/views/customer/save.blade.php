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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Membre</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('customer.save')}}" class="add_customer">
                    @csrf
                    <input type="hidden" name="id" value="{{$customer->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="file" name="avatar" class="dropify" data-default-file="{{$customer->avatar!=null ? Storage::url($customer->avatar) : ''}}">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row g-3">
    
                                                <div class="col-lg-6">

                                                    <div>
                                                        <label class="form-label">Nom</label>
                                                        <input type="text" name="first_name" value="{{$customer->first_name}}" class="form-control rounded-end" />
                                                    </div>
        
                                                    <div  class="mt-3 mb-3">
                                                        <label class="form-label">Prénom</label>
                                                        <input type="text" name="last_name" value="{{$customer->last_name }}" class="form-control rounded-end" />
                                                    </div>
                                                    @if(Auth::user()->account=='ADMINISTRATEUR')
                                                        <div  class="hidden business">
                                                            <label class="form-label">Superviseurs</label>
                                                            <select id="business_id" class="form-control" name="business_id"> 
                                                                @foreach($businesses as $business)
                                                                    <option value="{{$business->id}}" {{$business->id==$customer->business_id ? 'selected' : ''}} >{{$business->legal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="business_id" value="{{Auth::user()->business_id}}">
                                                    @endif
                                                </div>
        
                                                <div class="col-lg-6">
                                                    <div class="">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" value="{{$customer->email}}" class="form-control rounded-end" />
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">Téléphone</label>
                                                        <input type="text" name="phone" id="phone" value="{{$customer->phone}}" class="form-control rounded-end" />
                                                    </div>
                                                    <br>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div class="">
                                                        <label class="form-label">Adresse</label>
                                                        <input type="text" name="location" value="{{$customer->location}}" class="form-control rounded-end" />
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">Poids</label>
                                                        <input type="number" name="weight" value="{{$customer->weight}}" class="form-control rounded-end" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="">
                                                        <label class="form-label">Taille</label>
                                                        <input type="number" name="size" value="{{$customer->size}}" class="form-control rounded-end" />
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">Médecin</label>
                                                        <input type="text" name="medics" value="{{$customer->medics}}" class="form-control rounded-end" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="">
                                                        <label class="form-label">Origine</label>
                                                        <select name="origin" class="form-control rounded-end">
                                                            @if(in_array($customer->origin,['Asian','European','African','North American','South American']))
                                                                @foreach(['Asian','European','African','North American','South American'] as $origin)
                                                                    <option {{$customer->origin==$origin ? 'selected' : ''}} >{{$origin}}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach(['Asiatique','Européenne','Africaine','Nord-Américaine','Sud-Américaine'] as $origin)
                                                                    <option {{$customer->origin==$origin ? 'selected' : ''}} >{{$origin}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">Situation</label>
                                                        <select name="situation" class="form-control rounded-end">
                                                            @if(in_array($customer->situation,['Married','Single','Divorced','Widower']))
                                                                @foreach(['Married','Single','Divorced','Widower'] as $situation)
                                                                    <option {{$customer->situation==$situation ? 'selected' : ''}} >{{$situation}}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach(['Marié','Célibataire','Divorcé','Veuf'] as $situation)
                                                                    <option {{$customer->situation==$situation ? 'selected' : ''}} >{{$situation}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <br>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="">
                                                        <label class="form-label">Activité</label>
                                                        <select name="activity" class="form-control rounded-end">
                                                            @if(in_array($customer->activity,['Student','Worker','Manager','Unemployed','Retir']))
                                                                @foreach(['Student','Worker','Manager','Unemployed','Retir'] as $activity)
                                                                    <option {{$customer->activity==$activity ? 'selected' : ''}} >{{$activity}}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach(['Étudiant','Travailleur','Manager','Chômeur','Retraite'] as $activity)
                                                                    <option {{$customer->activity==$activity ? 'selected' : ''}} >{{$activity}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">diseases</label>
                                                        <textarea  name="diseases" class="form-control rounded-end" rows="4">{{$customer->diseases}}</textarea>
                                                    </div>
                                                    <br>
                                                </div>
                                                
                                                <div class="col-lg-12">
                                                    <button id="add_customer" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
                                                </div>
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

@endsection

@section('script')

    <style>
        .iti {
            position: relative;
            display: inline-block;
            width: 100%;
        }
    </style>

    <script>


        const input = document.querySelector("#phone");
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@20.0.5/build/js/utils.js",
        });

        input.addEventListener("countrychange", function(e) {
            var country = iti.getSelectedCountryData();
            $('#phone').val('+'+country.dialCode);
        });

        $('.add_customer').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_customer').text();
            var button = $('#add_customer');

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

                        window.location='{{route("customer.index")}}'
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