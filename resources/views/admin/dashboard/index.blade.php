@extends('admin_layout')
@section('title','dashboard')
@section('breadcrumb-item-1','Home')
@section('breadcrumb-item-2','Dashboard')
@push('javascript')
    <script>
       $(document).ready(function(){
            if (!localStorage.getItem('jwt_token')) {
                // Nếu không có token, chuyển hướng người dùng về trang đăng nhập
                window.location.href = 'http://127.0.0.1:8000/admin/login';
            } 
        });

    </script>
@endpush
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h5>this is dashboard</h5>
    </div>
</div>
@endsection
