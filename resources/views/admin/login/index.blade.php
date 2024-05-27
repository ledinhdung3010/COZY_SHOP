@extends('admin_layout_login')
@section('title','ADMIN-login')
@section('content')
@php
    use Illuminate\Support\Facades\Crypt;    
@endphp
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-group d-block d-md-flex row">
            <div class="card col-md-7 p-4 mb-0">
            <div class="card-body">
                <div class="message_register"></div>
                <h1>Login</h1>
                <p class="text-medium-emphasis">Sign In to your account</p>
                <div class="text_error"></div>
                <div class="login_fail"></div>
                <form method="post" id="inf_login">
                    @csrf
                    <div class="input-group mb-3"><span class="input-group-text">
                       
                        <svg class="icon">
                        <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                        </svg></span>
                    <input class="form-control" name="username" type="text" placeholder="Username" value="">
                    
                    </div>
                    <div class="error-username error"></div>
                    
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                        <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                        </svg></span>
                    <input class="form-control" name="password" type="password" placeholder="Password" value=""> 
                  
                    </div>
                    <div class="error-password error"></div>
                    <div class="col-6">
                       <input type="checkbox" name="remember" id="">
                       <label for="">remember me</label>
                    </div>
                    
                    <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary px-4" id="login_admin" type="submit">Login</button>
                    </div>
                    </div>

                </form>
                <a class="btn btn-primary px-4 mt-4" href="{{route('admin.resetpassword')}}">Reset Password</a>
                <a href="http://127.0.0.1:8000/admin/auth/google" class="btn btn-primary px-4 mt-4" id="login_google">Login Google</a>
                <a class="btn btn-primary px-4 mt-4" href="{{route('admin.login.facebook')}}">Login Facebook</a>
                <a class="btn btn-primary px-4 mt-4" href="{{route('admin.register')}}">Resgiter</a>
              
                <form action="{{route('admin.excelRegister')}}" method="post" enctype="multipart/form-data">
                    <input type="file" name="file_user">
                    <input type="file" name="list_image[]" class="form-control" id=""  multiple>
                    <button class="btn btn-primary px-4 mt-4" type="submit">import</button>
                </form>
                
            </div>
            </div>
        </div>
        </div>
  </div>
  @endsection
@push('javascript')
    <script>
        $(document).ready(function(){
            if (localStorage.getItem('jwt_token')) {
                // Nếu không có token, chuyển hướng người dùng về trang đăng nhập
                window.location.href = 'http://127.0.0.1:8000/admin/dashboard';
            } 
            if(localStorage.getItem('message_success')){
                $('.message_register').append('<div class="alert alert-success">\
                                                <p>'+localStorage.getItem('message_success')+'</p>\
                                            </div>')
                localStorage.removeItem('message_success');
            }
            if(localStorage.getItem('message_error')){
                $('.message_register').append('<div class="alert alert-danger">\
                                                <p>'+localStorage.getItem('message_error')+'</p>\
                                            </div>')
                localStorage.removeItem('message_error');
            }
        });

        $(document).on('click','#login_admin',function(event){
            event.preventDefault();
            $('.error').empty();
            var formData = $('#inf_login').serialize();
           $.ajax({
                type:'POST',
                url:'http://127.0.0.1:8000/admin/handle-login',
                data:formData,
                success: function(response) {
                    if(response.code=='200'){
                        localStorage.setItem('jwt_token', response.access_token);
                        localStorage.setItem('username', response.user.username);
                        localStorage.setItem('avatar', response.user.avatar);
                        window.location.href="http://127.0.0.1:8000/admin/dashboard"
                       
                    }else{
                        if(response.code=='422'){
                         $.each(response.data,function(key,value){
                            $('.error-'+key).append('<div class="alert alert-danger">\
                                                    <p>'+value+'</p>\
                                                </div>')
                         })
                        }else{
                            $('.text_error').empty();
                            $('.text_error').append('<div class="alert alert-danger">\
                                                    <p>'+response.message+'</p>\
                                                </div>')
                        }
                    }
                    
                  
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                       console.log(errors);
                       console.log('====================================');
                    }
                    } else {
                        if(xhr.status==401){
                            var error = xhr.responseJSON.error;
                            $('.login_fail').append('<div class="alert alert-danger">\
                                                    <p>'+error+'</p>\
                                                </div>')
                        }
                    }
                }
           })
        })
    </script>
    <script>
        $('#login_google').click(function(){
            $.ajax({
                type:'GET',
                url:'http://127.0.0.1:8000/admin/auth/google/callback',
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    
                }
           })
        })

    </script>
@endpush