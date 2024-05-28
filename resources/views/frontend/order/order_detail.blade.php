@extends('frontend_layout')
@section('title','PRODUCT-DETAIL')
@section('content')
<h2 class="text-center mt-3">ĐƠN HÀNG VỪA MUA</h2>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-10 col-xl-7 m-lr-auto ">
            <div class="m-l-25 m-r--38 m-lr-0-xl">
                <h3>FULLNAME: <span class="fullname"></span></h3>
                <h3>EMAIL: <span class="email"></span></h3>
                <h3>PHONE: <span class="phone"></span></h3>
                <h3>ADDRESS: <span class="address"></span></h3>
                <div class="status_order">

                </div>
                {{-- @if ($orders->status==1)
                    <h3>Trạng thái đơn hàng: Đang sử lý</h3>
                    @elseif ($orders->status==2)
                        <h3>Trạng thái đơn hàng: Đã được gửi đi</h3>
                    @else
                        <h3>Trạng thái đơn hàng: Đã bị hủy</h3>
                        <h3>Ly do: {{$orders->nots}}</h3>
                @endif --}}
            </div>
        </div>
    </div>
</div>
<form class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head" style="width:400px">
                                <th class="column-1">Product</th>
                                <th class="column-2"></th>
                                <th class="column-3">Price</th>
                                <th class="column-4">Quantity</th>
                                <th class="column-5">Color</th>
                                <th class="column-6" style="width: 10%;">Size</th>
                                <th class="column-7" style="width: 10%;">SubTotal</th>
                            </tr>
                            
                            {{-- @php
                                $count=0;
                            @endphp
                            @foreach ($products as $item)
                            <tr class="table_row">
                                <td class="column-1">
                                    <div class="how-itemcart1">
                                        <img src="{{URL::to('/')}}/upload/images/product/{{$item->image}}" alt="IMG">
                                    </div>
                                </td>
                                <td class="column-2"><a href="{{route('frontend.product.detail',['slug'=>$item->slug,'id'=>$item->id])}}">{{$item->name}}</a></td>
                                <td class="column-3">{{'$'.$item->price}}</td>
                                <td class="column-4">
                                    {{$item->qtyprice}}
                                </td>
                                <td class="column-5">{{$item->color_name}}</td>
                                <td class="column-6">{{$item->size_name}}</td>
                                <td class="column-7">{{'$'.($item->qtyprice*$item->price)}}</td>
                            </tr>
                            @php
                                $count+=$item->qtyprice*$item->price;
                            @endphp
                            @endforeach --}}
                            
                        </table>
                        <div class="bg-primary text-center py-3 total_money">
                            
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('javascript')
    <script>
         $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
           
                var id = urlParams.get('id');
                var extrsCode = urlParams.get('extrs_code');
            $.ajax({
                type: 'GET',
                headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                url: '{{ route('frontend.order_detail') }}',
                data: {
                    id:id, 
                    extrs_code:extrsCode // Truyền mã extrs_code
                },
                success: function(response) {
                    inf_order(response.data.orders);
                    product_order(response.data.products);
                },
                error: function(xhr) {
                    console.log('Có lỗi xảy ra');
                }
            });
        });
        function inf_order(inf){
            $('.fullname').text(inf.full_name);
            $('.email').text(inf.email);
            $('.phone').text(inf.phone);
            $('.address').text(inf.address);
            if(inf.status==1){
                $('.status_order').append('<h3>Trạng thái đơn hàng: Đang sử lý</h3>')
            }else{
                if(inf.status==2){
                    $('.status_order').append('<h3>Trạng thái đơn hàng: Đã được gửi đi</h3>')
                }else{
                    $('.status_order').append('<h3>Trạng thái đơn hàng: Đã bị hủy</h3>\
                <h3>Ly do:'+inf.nots+'</h3>')
                }
            }
        }
        function product_order(product){
            var count=0;
            $.each(product,function(index,product){
                $('.table-shopping-cart').append('<tr class="table_row">\
                                <td class="column-1">\
                                    <div class="how-itemcart1">\
                                        <img src="{{URL::to('/')}}/upload/images/product/'+product.image+'" alt="IMG">\
                                    </div>\
                                </td>\
                                <td class="column-2"><a href="{{route('frontend.product.detail.view')}}'+'?slug=' + product.category_slug + ''+'&id='+product.id+'">'+product.name+'</a></td>\
                                <td class="column-3">$ '+product.price+'</td>\
                                <td class="column-4">\
                                    '+product.qtyprice+'\
                                </td>\
                                <td class="column-5">'+product.color_name+'</td>\
                                <td class="column-6">'+product.size_name+'</td>\
                                <td class="column-7">$ '+product.price*product.qtyprice+'</td>\
                            </tr>')
                count+=product.qtyprice*product.price;
            })
            $('.total_money').append('<h3>TOTAL:'+count+'</h3>')
        }
    </script>
@endpush