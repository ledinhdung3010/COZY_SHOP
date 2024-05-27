@extends('frontend_layout')
@section('title','CHECKOUT')
@section('content')
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="{{route('frontend.home')}}" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="#" class="stext-109 cl8 hov-cl1 trans-04">
            Product
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
           Checkout
        </span>
    </div>
</div>

<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="col-sm-12 col-md-6 error_pay">
            
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('error_pay_vnpay'))
                    <div class="alert alert-danger">
                        <p>{{Session::get('error_pay_vnpay')}}</p>
                    </div>
                @endif
                <h5>Customer information</h5>
                <form class="border p-3" id="inf_your" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="">Full name</label>
                        <input type="text" name="full_name" id="" class="form-control">
                        <span class="text-danger error-message" id="full_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Phone</label>
                        <input type="text" name="phone" id="" class="form-control">
                        <span class="text-danger error-message" id="phone_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" id="" class="form-control">
                        <span class="text-danger error-message" id="email_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Address</label>
                        <input type="text" name="address" id="" class="form-control">
                        <span class="text-danger error-message" id="address_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Not</label>
                        <input type="text" name="nots" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Thanh toan khi nhan hang</label>
                        <input type="radio" name="pay" id="" class="form-control" value="1">
                    </div>
                    <div class="mb-3">
                        <label for="">Thanh toan VNPAY</label>
                        <input type="radio" name="pay" id="" class="form-control" value="2">
                    </div>
                    <div class="mb-3">
                        <label for="">Thanh toan PAYPAL</label>
                        <input type="radio" name="pay" id="" class="form-control" value="3">
                    </div>
                    <span class="text-danger error-message" id="pay_error"></span>
                    <button class="btn btn-primary btn-block btn-pay" name="pay" type="submit">Payment</button>
                </form>
            </div>
       
            <div class="col-sm-12 col-md-6">
                <div class="header-cart-content flex-w js-pscroll">
                    <ul class="header-cart-wrapitem w-full" id="list-cart">
                        {{-- @foreach ($data['cart'] as $item)
                            <li class="header-cart-item flex-w flex-t m-b-12" data-id="{{$item->rowId}}">
                                <div class="header-cart-item-img">
                                    <img src="{{URL::to('/')}}/upload/images/product/{{$item->options->image}}" alt="IMG">
                                </div>
        
                                <div class="header-cart-item-txt p-t-8">
                                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                        {{$item->name}}
                                    </a>
        
                                    <span class="header-cart-item-info"  data-product-id="{{$item->id.''.$item->options->size.''.$item->options->color}}">
                                        {{$item->price.'          X           '.$item->qty}} 
                                    </span>
                                </div>
                            </li>
                        @endforeach --}}
                        
                    </ul>
                    
                    <div class="w-full">
                        <div class="header-cart-total w-full p-tb-40 total">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</section>
@endsection
@push('javascript')
    <script>
        // su ly cart
        function getApi(){
            $.get('http://127.0.0.1:8000/Cart',function(res){
                    getCart(res.cart,res.total);
            })
        }
        function getCart(product,total){
            $.each(product, function(index, product){
                $('#list-cart').append('<li class="header-cart-item flex-w flex-t m-b-12" data-id="'+product.rowId+'">\
                                <div class="header-cart-item-img">\
                                    <img src="{{URL::to('/')}}/upload/images/product/'+product.options.image+'" alt="IMG">\
                                </div>\
                                <div class="header-cart-item-txt p-t-8">\
                                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">\
                                        '+product.name+'\
                                    </a>\
                                    <span class="header-cart-item-info"  data-product-id="'+product.id+''+product.options.size+''+product.options.color+'">\
                                        '+product.options.price_sell+'                 X                    '+product.qty+'\
                                    </span>\
                                </div>\
                            </li>')
            })
            $('.total').append('Total: '+total+'')
        }
        
        $(document).ready(function(){
            getApi()
            var urlParams = new URLSearchParams(window.location.search);
            if(urlParams.has('message')){
                var message= urlParams.get('message');
                message=message.replace(/\+/g, ' ');
                $('.error_pay').append('<div class="alert alert-danger">\
                                            <h3>'+message+'</h3>\
                                        </div>')
            }
        })
    </script>
    <script>
        $('.btn-pay').click(function(event){
            event.preventDefault();
            $('.error-message').text('');
            var formData = $('#inf_your').serialize();
            var pay=$('input[name="pay"]:checked').val();
            formData += '&checkpay=true&payment='+pay;
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route('frontend.order.payment')}}',
                data: formData,
                success: function(response) {
                    if(response.data.pay=='code'){
                        window.location.href = 'http://127.0.0.1:8000/order_detail?extrs_code='+response.data.extrs_code+'&id='+response.data.id;
                    }else{
                        window.location.href=response.data.url;
                    }
                    
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        // Hiển thị các tin nhắn lỗi
                        $.each(errors, function(key, value) {
                            $('#'+key+'_error').text(value)
                        });
                    }
                    } else {
                        console.log('Có lỗi không xác định xảy ra.');
                    }
                }
            });
        });
    </script>
@endpush