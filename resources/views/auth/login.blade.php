@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
    <!-- auth page content -->
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4 auth-one-bg h-100">
                                    <div class="bg-overlay"></div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div>
                                        <img src="{{asset('assets/images/logo-marvel-blue.png')}}" style="width:200px" alt="">
                                        <br><br>
                                        <p class="text-muted">Espace d'administration</p>
                                    </div>

                                    <div class="mt-4">
                                        <form class="needs-validation user_login" novalidate action="{{route('auth')}}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email" required id="email" placeholder="Email" >
                                            </div>
        
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Mot de passe <span class="text-danger">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" name="password" required class="form-control pe-5 password-input" >
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>
        
                                            <div class="mb-4">
                                                <p class="mb-0 fs-12 text-muted"><a href="">Mot de passe oublié?</a></p>
                                            </div>
        
                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" id="user_login" style="background: #e35310;border-color: #e35310;" type="submit">Connexion</button>
                                            </div><br>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
@endsection

@section('script')

    <script>

        $('.user_login').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#user_login').text();
            var button = $('#user_login');

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