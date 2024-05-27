@extends('admin_layout')
@section('title','ChangePassword')
@section('breadcrumb-item-1','ChangePassword')
@section('breadcrumb-item-2','Account')
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h5 class="text-center">Change Password</h5>
        <div class="message-success"></div>
       
        {{-- @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        {{-- @if(Session::has('update_success'))
            <div class="alert alert-success">
                <p>{{Session::get('update_success')}}</p>
            </div>
        @endif --}}
        <form class="border p-3 form-data" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                        <label for="">Old Password</label>
                        <input type="password" class="form-control " name="oldpassword" value="">
                        <div class="oldpassword-error error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Your Password</label>
                        <input type="password" class="form-control " name="yourpassword" value="">
                        <div class="yourpassword-error error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control " name="confirmpassword" value="">
                        <div class="confirmpassword-error error"></div>
                    </div>
                    <button  type="submit" class="btn btn-primary btn-lg btn-change">Submit</button>
                </div> 
            </div>
        </form>
    </div>
</div>
@endsection
@push('javascript')
    <script>
        $('.btn-change').on('click',function(event){
            event.preventDefault();
            $('.error').empty();
            var formData=$('.form-data').serialize();
            $.ajax({
                type:'POST',
                url:'http://127.0.0.1:8000/admin/changePassword/update',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                data:formData,
                success: function(data,textStatus,xhr) {
                    if(xhr.status==200){
                        $('.message-success').append(' <p class="alert alert-success">'+data.message+'</p>')
                        $('.form-data input').val('');
                    }
                },
                error: function(xhr) {
                    if(xhr.status==422){
                        var errors= xhr.responseJSON.errors;
                        $.each(errors,function(key,value){
                            $('.'+key+'-error').append('<p class="alert alert-danger">'+value+'</p>')
                        })
                    }
                }
           })
        })
    </script>
@endpush