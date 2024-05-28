@extends('admin_layout_login')
@section('title','login')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-group d-block d-md-flex row">
            <div class="card col-md-7 p-4 mb-0">
            <div class="card-body">
                <h1>Login</h1>
                <p class="text-medium-emphasis">Sign In to your account</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('error_login'))
                        <div class="alert alert-danger">
                            <p>{{Session::get('error_login')}}</p>
                        </div>
                    @endif
                <form  method="post" id="inf_login">
                    <div class="input-group mb-3"><span class="input-group-text">
                        @csrf
                        <svg class="icon">
                        <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                        </svg></span>
                    <input class="form-control" name="username" type="text" placeholder="Username">
                    </div>
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                        <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                        </svg></span>
                    <input class="form-control" name="password" type="password" placeholder="Password">
                    </div>
                    <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary px-4 btn-submit" type="submit">Login</button>
                    </div>
                    </div>

                </form>
            </div>
            </div>
            
        </div>
        </div>
  </div>
  @endsection
  @push('javascript')
      <script>
        $('.btn-submit').click(function(event){
            event.preventDefault();
            var formData = $('#inf_login').serialize();
            $.ajax({
                            url:"http://127.0.0.1:8000/handle-login",
                            type:"Post",
                            data:formData,
                            success:function(data,textStatus,xhr){
                               if(xhr.status==200&&data.role=="user"){
                                localStorage.setItem('jwt_token', data.access_token);
                                localStorage.setItem('username', data.user.username);
                                window.location.href="http://127.0.0.1:8000/home/index?page=1"
                               }
                            },
                            error: function(xhr) {
                                
                            }
                    })
                
        })
      </script>
  @endpush
