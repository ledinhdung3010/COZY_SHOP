@extends('admin_layout')
@section('title','ListProduct')
@section('breadcrumb-item-1','Products')
@section('breadcrumb-item-2','Lists')
@push('stylesheets')
    <style>
        .message_deletes_success{     
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: green;
            color: white;
            padding: 25px 40px;
            border-radius: 10px;
            display: none;
        }
    </style>
@endpush
@push('javascript')
<script>
    $(function(){
        $('#txtKeyword').bind('enterKey',function(){
            let keyword=$('#txtKeyword').val().trim();
            keyword=encodeURI(keyword);
            window.location.href="{{route('admin.product')}}"+"?s="+keyword;
            
        })
        $('#txtKeyword').keyup(function(e){
            if(e.keyCode==13){
                $(this).trigger('enterKey')
            }
        })

        $('#btnSearch').click(function(){
            let keyword=$('#txtKeyword').val().trim();
            keyword=encodeURI(keyword);
            window.location.href="{{route('admin.product')}}"+"?s="+keyword;
            
        })

    })

</script>
@endpush
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h5 class="text-center">Product</h5>
        <a href="{{route('admin.product.add')}}" class="btn btn-primary my-3">ADD PRODUCT</a>
        <button class="btn btn-primary my-3 btn-export">EXPORT PRODUCT</button>
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#deletesProduct">
            DELETES-PRODUCT
        </button>
        <!-- Modal -->
        <div class="modal fade" id="deletesProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DELETES PRODUCT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to delete ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-deletes" data-bs-dismiss="modal">OK</button>
            </div>
            </div>
        </div>
        </div>      
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="txtKeyword" placeholder="ProductName" value="{{$keyword}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="input-group-text" id="btnSearch">Search</button>
            </div>
         </div>
       <div class="message_success">

        </div>
        <div class="message_delete_success">
        </div>
        <div class="message_deletes_success">
            
        </div>
        @if(Session::has('delete_success'))
            <div class="alert alert-success">
                <p>{{Session::get('delete_success')}}</p>
            </div>
        @endif
        @if(Session::has('update_success'))
            <div class="alert alert-success">
                <p>{{Session::get('update_success')}}</p>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>image</th>
                    <th>Price</th>
                    <th>is_sale</th>
                    <th>sale_price</th>
                    <th>Quantity</th>
                    <th colspan="3" width="5%">Action</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr >
                        <td><input type="checkbox" id="checked{{$product->id}}" value="{{$product->id}}"></td>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td><img src="{{URL::to('/')}}/upload/images/product/{{$product->image}}" width="100px" height="100px" alt=""></td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->in_sale == 1 ?'yes' : 'no'}}</td>
                        <td>{{$product->sale_price}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>
                            <a href="{{route('admin.product.view',['id'=>$product->id])}}" class="btn btn-info btn-sm">view</a>
                        </td>
                        <td>
                            <a href="{{route('admin.product.edit',['id'=>$product->id])}}" class="btn btn-info btn-sm">edit</a>
                        </td>

                        <!-- Button trigger modal -->
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{$product->id}}">
                                DELETE
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="delete{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">DELETE PRODUCT</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Do you want to delete ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary delete-confirm-btn" data-bs-dismiss="modal" data-product-id="{{ $product->id }}">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                    
                @endforeach

            </tbody>

        </table>
        {{ $products->appends(request()->input())->links() }}
    </div>
</div>
@endsection
@push('javascript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('.message_success').empty();                 
            if (!localStorage.getItem('jwt_token')) {
                // Nếu không có token, chuyển hướng người dùng về trang đăng nhập
                window.location.href = 'http://127.0.0.1:8000/admin/login';
            }
            if(localStorage.getItem('message_insert_product_success')){
                $('.message_success').append(' <div class="alert alert-success">\
                <p>'+localStorage.getItem('message_insert_product_success')+'</p>\
            </div>')
            localStorage.removeItem('message_insert_product_success');
            }
            if(localStorage.getItem('message_insert_product_fail')){

            }
        });
        $('.delete-confirm-btn').click(function () {
            let productId = $(this).data('product-id');
            $.ajax({
                url:'http://127.0.0.1:8000/admin/delete',
                type:"delete",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                data:{id:productId},
                success:function(data,textStatus,xhr){
                    if(xhr.status==200){
                        $('.message_delete_success').append(' <div class="alert alert-success">\
                                                                    <p>'+data.message+'</p>\
                                                                </div>')
                    }
                },
                error: function(xhr) {
                    console.log('aaa');
                }
                      
                })
    
            $('#delete' + productId).closest('tr').remove();
        })

    </script>
    <script>
        $('.btn-deletes').on('click',function(event){
            event.preventDefault();
            var selectedProducts = [];
            $(".table input[type=checkbox]:checked").each(function() {
            selectedProducts.push($(this).val());
            });
            $.ajax({
                type:'POST',
                url:'http://127.0.0.1:8000/admin/deletesProduct',
                data:{idProducts:selectedProducts},
                success: function(data,textStatus,xhr) {
                    $('.message_deletes_success').empty()
                    if(xhr.status==200){
                        selectedProducts.forEach(function(id) {
                            $("#checked" + id).closest('tr').remove();
                        });
                        $(".message_deletes_success").text(data.message).fadeIn().delay(4000).fadeOut();
                    }
                  
                },
                error: function(xhr) {
                    if(xhr.status==422){
                        var error= xhr.responseJSON.message;
                        $(".message_deletes_success").css('background-color','red')
                        $(".message_deletes_success").text(error).fadeIn().delay(4000).fadeOut();
                    }
                }
           })
        })
    </script>
    <script>
        $('.btn-export').on('click',function(event){
            event.preventDefault();
            var selectedProducts = [];
            $(".table input[type=checkbox]:checked").each(function() {
            selectedProducts.push($(this).val());
            });
            $.ajax({
                type:'POST',
                url:'http://127.0.0.1:8000/admin/product/export',
                data:{idProducts:selectedProducts},
                xhrFields: {
                    responseType: 'blob' // Đảm bảo dữ liệu phản hồi được xử lý như là dạng blob
                },
                success: function(data,textStatus,xhr) {
                    var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    var timestamp = Math.floor(Date.now() / 1000); 
                    a.download = timestamp + 'products.xlsx';
                 
                    a.click();
                    window.URL.revokeObjectURL(url);
                  
                },
                error: function(xhr) {
                    
                }
           })
        })
    </script>
    

@endpush