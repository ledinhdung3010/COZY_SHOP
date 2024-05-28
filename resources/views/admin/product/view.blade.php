@extends('admin_layout')
@section('title','ViewProduct')
@section('breadcrumb-item-1','Products')
@section('breadcrumb-item-2','View')
@push('stylesheets')
    <style>
       .gold-star{
            color: gold;
       }
       .border-bottom{
            border-bottom: 1px solid #000;
            padding: 10px 0;
        }
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
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h1>REIVEW PRODUCT</h1>
        
        <div class="content-comment">
            
        </div>
        <div class="message_deletes_success">
           
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var url = window.location.href;
        // Create a URL object
        var urlParams = new URL(url);
        // Use URLSearchParams to get the id parameter
        var idPd = urlParams.searchParams.get('id');
        $.ajax({
            type: 'post',
            url: 'http://127.0.0.1:8000/admin/renderProduct',
            data: { id: idPd },
            success: function(data, textStatus, xhr) {
                if (xhr.status == 200) {
                    console.log(data.comment);
                    $.each(data.comment, function(key, value) {
                        var stars = "";
                        for (var i = 0; i < 5; i++) {
                            if (i < value.start) {
                                stars += '<i class="zmdi zmdi-star gold-star"></i>';
                            } else {
                                stars += '<i class="zmdi zmdi-star-outline gold-star"></i>';
                            }
                        }
                        if (value.partend_id == null) {
                            $('.content-comment').append('<div class="border-bottom">\
                                                             <div class="d-flex justify-content-between align-items-center p-b-17">\
                                                                <div class="flex-w flex-sb-m p-b-17" id=' + value.id + '>\
                                                                    <h3 class="mtext-107 cl2 p-r-20">\
                                                                        ' + value.username + '\
                                                                    </h3>\
                                                                    <span class="fs-18 cl11">\
                                                                        ' + stars + '\
                                                                    </span>\
                                                                </div>\
                                                                <div class="dropdown" data-id='+value.id+'>\
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">\
                                                                    </button>\
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">\
                                                                    <li><a class="dropdown-item btn-deleteComment" href="#">Delete Comment</a></li>\
                                                                    </ul>\
                                                                </div>\
                                                            </div>\
                                                            <div class="comment'+value.id+'">\
                                                                <p class="stext-102 cl6">\
                                                                    ' + value.content + '\
                                                                </p>\
                                                                <div data-id='+value.id+'>\
                                                                    <input class="form-control repComment" type="text" name="repComment">\
                                                                    <button type="submit" class="btn btn-info mt-4 btn-repComment" >Submit</button>\
                                                                </div>\
                                                            </div>\
                                                        </div>\
                                                ');
                        } else {
                            $('.content-comment').append('<div class="border-bottom">\
                                                            <div class="d-flex justify-content-between align-items-center p-b-17">\
                                                                <div class="flex-w flex-sb-m p-b-17" id=' + value.id + '>\
                                                                    <h3 class="mtext-107 cl2 p-r-20">\
                                                                        ' + value.username + '\
                                                                    </h3>\
                                                                    <span class="fs-18 cl11">\
                                                                        ' + stars + '\
                                                                    </span>\
                                                                </div>\
                                                                <div class="dropdown" data-id='+value.id+'>\
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">\
                                                                    </button>\
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">\
                                                                    <li><a class="dropdown-item btn-deleteComment" href="#">Delete Comment</a></li>\
                                                                    </ul>\
                                                                </div>\
                                                            </div>\
                                                            <p class="stext-102 cl6">\
                                                                ' + value.content + '\
                                                            </p>\
                                                            <div class="mx-3" data-id='+value.id+'>\
                                                                <h4>COZA-STORE</h4>\
                                                                <p class="stext-102 cl6">'+value.repComment+'</p>\
                                                            </div>\
                                                        </div>\
                                                ');
                        }
                    });
                }
            },
            error: function(xhr) {
                // Handle the error here
            }
        });

        // Attach the click event handler using event delegation
        $('.content-comment').on('click', '.btn-repComment', function() {
            var $parentElement = $(this).closest('[data-id]');
            // Lấy giá trị của data-id
            var dataId = $parentElement.data('id');
            var content=$parentElement.find('.repComment').val();
            $.ajax({
                type: 'post',
                url: 'http://127.0.0.1:8000/admin/repComment',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                data: {idPd:dataId,content:content},
                success: function(data, textStatus, xhr) {
                    if(xhr.status==200){
                        $parentElement.remove();
                        $('.comment'+dataId).append('<div class="mx-3" data-id='+data.comment.id+'>\
                                                    <h4>COZA-STORE</h4>\
                                                    <p class="stext-102 cl6">'+data.comment.repComment+'</p>\
                                                </div>\
                                            ')

                    }
                },
                error: function(xhr) {
                    // Handle the error here
                }
            });

            
        });
    });
</script>
<script>
    $('.content-comment').on('click','.btn-deleteComment',function(event){
        event.preventDefault();
        var $parentElement = $(this).closest('[data-id]');
            // Lấy giá trị của data-id
        var dataId = $parentElement.data('id');
        $.ajax({
                type: 'post',
                url: 'http://127.0.0.1:8000/admin/deleteComment',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                data: {idPd:dataId},
                success: function(data, textStatus, xhr) {
                        $('.message_deletes_success').empty();
                    if(xhr.status==200){
                        var $borderBottomDiv = $parentElement.closest('div.border-bottom');
                        $borderBottomDiv.remove();
                        $(".message_deletes_success").text(data.message).fadeIn().delay(4000).fadeOut();
                    }
                },
                error: function(xhr) {
                    
                }
            });
        
        
    })
</script>

@endpush