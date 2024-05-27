@extends('admin_layout')
@section('title','AddPRoduct')
@section('breadcrumb-item-1','Products')
@section('breadcrumb-item-2','Add')
@push('stylesheets')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
<style>
    .mult-select-tag .wrapper{
        padding-left: 0 !important;
    }
    .ck-editor__editable{
        min-height: 500px !important;
    }
</style>
@endpush
@push('javascript')

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
 new MultiSelectTag('color_id', {
    rounded: true,    // default true
    shadow: false,      // default false
    placeholder: 'Search',  // default Search...
    tagColor: {
        textColor: '#327b2c',
        borderColor: '#92e681',
        bgColor: '#eaffe6',
    },
    onChange: function(values) {
        console.log(values)
    }
})
new MultiSelectTag('size_id', {
    rounded: true,    // default true
    shadow: false,      // default false
    placeholder: 'Search',  // default Search...
    tagColor: {
        textColor: '#327b2c',
        borderColor: '#92e681',
        bgColor: '#eaffe6',
    },
    onChange: function(values) {
        console.log(values)
    }
})
new MultiSelectTag('tag_id', {
    rounded: true,    // default true
    shadow: false,      // default false
    placeholder: 'Search',  // default Search...
    tagColor: {
        textColor: '#327b2c',
        borderColor: '#92e681',
        bgColor: '#eaffe6',
    },
    onChange: function(values) {
        console.log(values)
    }
})
    // ClassicEditor
    //     .create( document.querySelector( '#editor' ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );

</script>
<script>
    $(document).ready(function(){
        $('#sale_price').prop('disabled',true);
        $('input[name="in_sale"]').change(function(){
                if($(this).is(':checked')){
                    $('#sale_price').prop('disabled', false);
                } else {
                    $('#sale_price').prop('disabled', true);
                }
            });
    })
</script>

@endpush
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h5 class="text-center">Add Product</h5>
        <a href="{{route('admin.product')}}" class="btn btn-primary my-3">Back to list products</a>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('error_sale--price'))
            <div class="alert alert-danger">
                <p>{{Session::get('error_sale--price')}}</p>
            </div>
        @endif
        
        @if(Session::has('error_upload_img'))
            <div class="alert alert-danger">
                <p>{{Session::get('error_upload_img')}}</p>
            </div>
        @endif
        @if(Session::has('error_insert--product'))
            <div class="alert alert-danger">
                <p>{{Session::get('error_insert--product')}}</p>
            </div>
        @endif

        <form  class="border p-3 " id="inf_product" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        <span class="text-danger error-message name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Category</label>
                        <select name="category" id="" class="form-control">
                            <option value="">-- Chose --</option>
                            @foreach ($categorys as $item)
                            <option value="{{$item->id}}" {{old('category_id')==$item->id ? 'selected' :''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-message category_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Summary</label>
                        <textarea name="summary" id="" class="form-control"  rows="5">
                        </textarea>
                        
                    </div>
                    <div class="mb-3">
                        <label for="">Price</label>
                        <input type="text" name="price" class="form-control" id="">
                        <span class="text-danger error-message price_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Is Sale</label>
                        <input type="checkbox" name="in_sale"  id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Sale-Price</label>
                        <input type="text" name="sale_price" class="form-control" id="sale_price">
                        <span class="text-danger error-message sale_price_error"></span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">Quantity</label>
                        <input type="text" name="quantity" class="form-control" id="">
                        <span class="text-danger error-message quantity_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Image gally</label>
                        <input type="file" name="list_image[]" class="form-control" id=""  multiple>
                        <span class="text-danger error-message list_image_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="">-- Chose --</option>
                            <option value="1"  {{old('status')=="1" ? 'selected': ''}}>Active</option>
                            <option value="2" {{old('status')=="2" ? 'selected': ''}}>In Active</option>
                        </select>
                        <span class="text-danger error-message status_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Color</label>
                        <select name="color[]" id="color_id" class="form-control" multiple>
                            @foreach ($colors as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-message color_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Size</label>
                        <select name="size[]" id="size_id" class="form-control" multiple>
                            @foreach ($sizes as $item)
                            <option value="{{$item->id}}">{{$item->name_letter}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-message size_error"></span>
                        
                    </div>
                    <div class="mb-3">
                        <label for="">Tag</label>
                        <select name="tag[]" id="tag_id" class="form-control" multiple>
                     
                            @foreach ($tags as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-message tag_error"></span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" rows="10">
                        </textarea>
                        <span class="text-danger error-message description_error"></span>
                    </div>
                   
                    <button  type="submit" class="btn btn-primary btn-lg add_product">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('javascript')
    <script>
        $(document).ready(function(){
            if (!localStorage.getItem('jwt_token')) {
                // Nếu không có token, chuyển hướng người dùng về trang đăng nhập
                window.location.href = 'http://127.0.0.1:8000/admin/login';
            }else{
                $('#inf_product').on('submit', function(e){
                    e.preventDefault();
                    $('.error-message').text('');
                    var formData = new FormData(this);
                    $.ajax({
                            url:"http://127.0.0.1:8000/admin/create",
                            type:"Post",
                            headers: {
                                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                            },
                            data:formData,
                            processData: false, // Don't process the files
                            contentType: false,
                            success:function(data,textStatus,xhr){
                               if(data.code==422 && data.error_sale_price!=''){
                                    $('.sale_price_error').text(data.error_sale_price);
                               }else{
                                    if(data.code==422 && data.error_img!=''){
                                        $('.list_image_error').text(data.error_img);
                                    }else{
                                        if(xhr.status==200){
                                            localStorage.setItem('message_insert_product_success',data.message);
                                            window.location.href="http://127.0.0.1:8000/admin/product";
                                        }else{
                                            if(xhr.status==500){
                                                localStorage.setItem('message_insert_product_fail',data.message);
                                                window.location.href="http://127.0.0.1:8000/admin/product";
                                            }   
                                           
                                           
                                            
                                        }
                                    }
                               }
                            },
                            error: function(xhr) {
                                if (xhr.status == 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        if (key.match(/^list_image\.\d+$/)) { // Kiểm tra key có phải là 'list_image.[index]'
                                            $('.list_image_error').text(value); // Gán lỗi cho phần tử HTML tương ứng
                                        } else {
                                            $('.' + key + '_error').text(value[0]); // Gán lỗi cho các trường khác
                                        }
                                    });
                                }
                            }
                        })
                    })
            }
        });

    </script>
@endpush