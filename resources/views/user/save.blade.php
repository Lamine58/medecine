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

                <form action="{{route('user.save')}}" class="add_user">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="file" name="avatar" class="dropify" data-default-file="{{$user->avatar!=null ? Storage::url($user->avatar) : ''}}">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row g-3">
    
                                                <div class="col-lg-6">
                                            
                                                    <div >
                                                        <label class="form-label">Type de compte</label>
                                                        <select name="account" id="account" class="form-control">
                                                            @if(Auth::user()->account=='ADMINISTRATEUR')
                                                                <option {{$user->account=="ADMINISTRATEUR" ? 'selected' : ''}} >ADMINISTRATEUR</option>
                                                                <option {{$user->account=="CENTRE DE SANTE" ? 'selected' : ''}}>CENTRE DE SANTE</option>
                                                            @else
                                                                <option {{$user->account=="CENTRE DE SANTE" ? 'selected' : ''}}>CENTRE DE SANTE</option>
                                                            @endif
                                                        </select>
                                                    </div>
        
                                                    @if(Auth::user()->account=='ADMINISTRATEUR')
                                                        <div  class="mt-3 hidden business">
                                                            <label class="form-label">Centre de santé</label>
                                                            <select id="business_id" class="form-control" name="business_id"> 
                                                                @foreach($businesses as $business)
                                                                    <option value="{{$business->id}}" {{$business->id==$user->business_id ? 'selected' : ''}} >{{$business->legal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="business_id" value="{{Auth::user()->business_id}}">
                                                    @endif
        
                                                    <div class="mt-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" name="email" value="{{$user->email}}" class="form-control rounded-end" />
                                                    </div>
                                                </div>
        
                                                <div class="col-lg-6">
        
                                                    <div>
                                                        <label class="form-label">Nom</label>
                                                        <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control rounded-end" />
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">Prénom</label>
                                                        <input type="text" name="last_name" value="{{$user->last_name }}" class="form-control rounded-end" />
                                                    </div>
        
                                                    <div  class="mt-3">
                                                        <label class="form-label">Téléphone</label>
                                                        <input type="text" name="phone" value="{{$user->phone}}" class="form-control rounded-end phone" />
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="col-lg-12 row">
                                                    <h4><small>Accès</small></h4>
                                                    <hr>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Mot de passe</label>
                                                        <input type="text" name="password" class="form-control rounded-end" />
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Confirmer  le mot de passe</label>
                                                        <input type="text" name="password_confirmation" class="form-control rounded-end" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button id="add_user" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button>
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
    
@endsection

@section('script')

    <script>

        $('#account').on('change',()=>{

            if($('#account').val()=='CENTRE DE SANTE' || $('#account').val()=='ENQUETEUR'){
                $('.business').removeClass('hidden');
            }else{
                $('.business').addClass('hidden');
            }

        });

        $('.add_user').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_user').text();
            var button = $('#add_user');

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

                        window.location='{{route("user.index")}}'
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