{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ToDo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        body{
            background-color: #f0f2f5;
        }
        .invalid-feedback{
            color: red;
        }
    </style>
    <style>
        .invalid{
            border-color:red;
        }
        .alert-danger, .modal-danger {
             background-color: #dd4b3900 !important;
             border-color: #dd4b3900;
             color: #d73925 !important;
         }
        .alert{
            padding: 0px;
        }
    </style>

</head>
<body>
<div class="lg:flex max-w-5xl min-h-screen mx-auto px-6 justify-content-center">
    <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">
        <div class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full">


            <form method="POST" id="user-register" class="user_register p-6 space-y-4 relative bg-white shadow-lg rounded-lg form-group" onsubmit="return validateRegisterform(this.id)">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="color: red">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input  type="name" name="name" id="name" value="{{old('name')}}" placeholder="Name"  class="with-border form-control required">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                <input  type="email" name="email" id="email" value="{{old('email')}}" placeholder="Email"  class="email_login with-border form-control required">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                <input type="password" id="password" name="password" value="{{old('password')}}" placeholder="Password" class="with-border form-control required">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Confirm Password" class="with-border form-control required">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                <div class="">
                    <button type="submit" class="bg-blue-600 font-semibold mx-auto px-8 py-2 rounded-md text-center text-white">
                        Sign Up
                    </button>
                </div>
            </form>
            @if (Route::has('login'))
                                    <a class="" href="{{ route('login') }}">Already?{{ __('Login') }}</a>
                            @endif
        </div>

    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    function validateRegisterform(formid) {
            var isValid = true;
            var form = $("form#" + formid);
            form.find('input.required').each(function() {
                if ($(this).val() === null || $(this).val() === "") {
                    $(this).addClass('invalid');
                    isValid = false;
                }
            });
            $('form input.required').on('focus', function() {
                $(this).removeClass('invalid');
            });
            if (!(isValid)) {
                return false;
            } else {
                return true;
            }
            return isValid;
    }

        $('.user_register').on('submit', function(e){
            e.preventDefault();
            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let password_confirmation = $('#password_confirmation').val();
            $.ajax({
              url: "/api/user/register",
              type:"POST",
              data:{
                "_token": "{{ csrf_token() }}",
                name:name,
                email:email,
                password:password,
                password_confirmation:password_confirmation,
              },
              success:function(response){
                // var  token = response.data;
                // localStorage.setItem('token', JSON.stringify(token));
                localStorage.setItem('token', response.data);
                if(response.success == 'true'){
                    location.href = '/home', toastr.success(response['message']);
                }
                else{
                    toastr.error(response['message']);
                }

              }
            });
        });
</script>
</body>
</html>
