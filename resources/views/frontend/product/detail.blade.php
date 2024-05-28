@extends('frontend_layout')
@section('title','PRODUCT-DETAIL')
@push('stylesheet')
<style>
  

    .slider {
        overflow: hidden;
        width: 100%;
        position: relative;
        margin: auto;
        
    }
    .slider {
        display: flex;
        padding: 0;
        transition: transform 0.5s ease;
    }
    .slider li {
        flex: 0 0 auto;
        width: 100%;
        list-style: none;
    }
    .wrap-slick2{
        display: flex;
    }
    .fa-chevron-left,
    .fa-chevron-right{
        font-size: 40px;
    }
    .thumbnail img {
        max-width: 100%;
        height: auto;
        cursor: pointer;
    }
   
    .thumbnail img.selected {
        border: 2px solid blue; /* Màu viền và độ rộng của viền */
    }
    .border-bottom{
        border-bottom: 1px solid #000
    }
</style>
@endpush
@section('content')
<!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{route('frontend.home.index')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="#" class="stext-109 cl8 hov-cl1 trans-04">
                <span id="categoryname"></span>
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                <span id="productname"></span>
            </span>
        </div>
    </div>
<!-- Product Detail -->
<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w">
                        <div class="col-md-3">
                            <div class="row list_image">
                               
                            </div>
                        </div>
                        <button class="prev_img"><i class="fa-solid fa-chevron-left"></i></button>
                        <div class="slider2 col-md-4 imageMainProduct mt-5">

                        </div>
                        <button class="next_img"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
                
            <div class="col-md-6 col-lg-5 p-b-30">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14 productName">
                       
                       {{-- {{$infoProduct->name}} --}}
                    </h4>

                    <span class="mtext-106 cl2 productPrice">
                       {{-- {{$infoProduct->price}} --}}
                    </span>

                    <p class="stext-102 cl3 p-t-23 productSummery">
                       {{-- {{$infoProduct->summery}} --}}
                    </p>
                    
                    <!--  -->
                    <div class="p-t-33">
                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Size
                            </div>

                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select class="js-select2 js-size-product" id="sizeProduct" name="time">
                                        <option>Choose an option</option>
                                        {{-- @foreach ($sizeProduct as $size)
                                            <option value="{{$size->id}}">{{$size->name_letter}}</option>
                                        @endforeach --}}
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Color
                            </div>

                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select class="js-select2 js-color-product" id="colorProduct" name="time" >
                                        <option>Choose an option</option>
                                        {{-- @foreach ($colorProduct as $color)
                                            <option value="{{$color->id}}">{{$color->name}}</option>
                                        @endforeach --}}
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-w p-b-10 ml-4 px-3">
                            Số Lượng Sẵn Có 
                            <div class="quantity" style="margin-left:10px; padding: 0px 20px; border: 2px solid #e8e8e8;  border-radius: 5px;">
                                {{-- {{$infoProduct->quantity}} --}}
                            </div> 
                        </div>
                        
                        

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-204 flex-w flex-m respon6-next">
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product js-num-product" type="number" name="num-product" value="1">

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                   
                                </div>
                                <form action="{{route('frontend.cart.add')}}" method="post">
                                    @csrf
                                    <button type="submit" name="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail add-cart">
                                        Add to cart
                                    </button>
                                </form>
                                
                            </div>
                            
                        </div>	
                    </div>

                    <!--  -->
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                            <i class="fa-brands fa-twitter"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                            <i class="fa-brands fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                    </li>
                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-43">
                    <!-- - -->
                    <div class="tab-pane fade show active"  role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6" id="description">
                                {{-- {!!$infoProduct->description!!} --}}
                            </p>
                        </div>
                    </div>


                    <!-- - -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">
                                    <!-- Review -->
                                    <div class="flex-w flex-t p-b-68">
                                        <div class="size-207 comment-product">
                                            
                                        </div>
                                    </div>
                                    
                                    <!-- Add review -->
                                    <form class="w-full form-review">
                                        <h5 class="mtext-108 cl2 p-b-7">
                                            Add a review
                                        </h5>
                
                                        <p class="stext-102 cl6">
                                            Your email address will not be published. Required fields are marked *
                                        </p>
                
                                        <div class="flex-w flex-m p-t-50 p-b-23">
                                            <span class="stext-102 cl3 m-r-16">
                                                Your Rating
                                            </span>
                
                                            <span class="wrap-rating fs-18 cl11 pointer">
                                                <i class="item-rating pointer zmdi zmdi-star-outline" data-value="1"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline" data-value="2"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline" data-value="3"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline" data-value="4"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline" data-value="5"></i>
                                                <input class="dis-none" type="number" name="rating" id="rating">
                                            </span>
                                        </div>
                
                                        <div class="row p-b-25">
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="review">Your review</label>
                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="email">Email</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
                                            </div>
                                        </div>
                
                                        <button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10 btn-review">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
        <span class="stext-107 cl6 p-lr-25 subtitle-productName">
            {{-- NameProduct::{{$infoProduct->name}} --}}
        </span>

        <span class="stext-107 cl6 p-lr-25 subtitle-categoriesName">
            {{-- Categories: {{$infoProduct->categories_name}} --}}
        </span>
    </div>
</section>

	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Related Products
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
                    <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
				<div class="slider" id="relatedProduct">
                    
			    </div>
                    <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
	    </div>
	</section>
@endsection
@push('javascript')
    <script>
        // slider relatedProduct
        // Slide to the left
        function slideLeft() {
                const slider = $('.slider');
                const firstItem = slider.children().first();
                slider.append(firstItem.clone());
                firstItem.remove();
            }

            // Slide  to the right
            function slideRight() {
                const slider = $('.slider');
                const lastItem = slider.children().last();
                slider.prepend(lastItem.clone());
                lastItem.remove();
            }

            // Bind click event to left button
            $('.prev').on('click', function() {
                slideLeft();
            });

            // Bind click event to right button
            $('.next').on('click', function() {
                slideRight();
            });

            // Automatic sliding
            // setInterval(slideLeft, 3000);
    </script>
    <script>
        $(function(){
            $('.btn-num-product-up').click(function(){
                var quantity=$('.quantity').text().trim();
                var number_product=$('.num-product').val();
                if(parseInt(number_product)>parseInt(quantity)){
                    $('.num-product').val(quantity);
                }
            })
            $('.btn-num-product-down').click(function(){
                var number_product=$('.num-product').val();
                if(parseInt(number_product)==0){
                    $('.num-product').val('1');
                }
            })
            $('.num-product').on('input', function() {
                var number_product=$('.num-product').val();
                var quantity=$('.quantity').text().trim();
                if(parseInt(number_product)==0){
                    $('.num-product').val('');
                }
                if(parseInt(number_product)>parseInt(quantity)){
                    $('.num-product').val(quantity);
                }
            })
            $('.num-product').change(function(){
                var number_product=$('.num-product').val();
                if((number_product)==''){
                    $('.num-product').val('1');
                }
            })
            let currentURL = window.location.href;

            // Tạo một đối tượng URL từ URL hiện tại
            let url = new URL(currentURL);

            // Lấy tham số từ URL
            let params = new URLSearchParams(url.search);

            // Lấy giá trị của các tham số
            let slug = params.get('slug');
            let id = params.get('id');
            
            function featchProductDetail(slug,id){
                $.get('http://127.0.0.1:8000/handleProductDetail?slug='+slug+'&id='+id,function(res){
                    if(res.status==200){
                        listImage(res.data.list_images,res.data.infoProduct.image)
                        getSizeProduct(res.data.sizeProduct)
                        getColorProduct(res.data.colorProduct)
                        getProduct(res.data.infoProduct)
                        relatedProducts(res.data.relatedProduct)
                        relatedComments(res.data.comment)
                    }   
                })
            }
            // category
            function getProduct(product){
                $('#categoryname').text(product.categories_name);
                $('#productname').text(product.name)
                $('.productName').text(product.name)
                $('.productPrice').text(product.price_sell)
                $('.productSummery').text(product.summary)
                $('.quantity').text(product.quantity)
                $('#description').html(product.description)
                $('.subtitle-productName').text(product.name)
                $('.subtitle-categoriesName').text(product.categories_name)
            }
            // sizeProduct
            function getSizeProduct(size){
                $.each(size,function(index,size){
                    $('#sizeProduct').append('<option value="'+size.id+'">'+size.name_letter+'</option>')
                })
            }
            // colorProduct
            function getColorProduct(color){
                $.each(color,function(index,color){
                    $('#colorProduct').append('<option value="'+color.id+'">'+color.name+'</option>')
                })
            }
            // relatedComments
            function relatedComments(comment){
                $('.comment-product').empty();
               
                $.each(comment,function(key,value){
                    var starts="";
                    for(var i=0;i<5;i++){
                        if(i<value.start){
                            starts += '<i class="zmdi zmdi-star"></i>';
                        }else{
                            starts += '<i class="zmdi zmdi-star-outline"></i>';
                        }
                    }
                    if (value.partend_id == null) {
                            $('.comment-product').append('<div class="border-bottom">\
                                                            <div class="flex-w flex-sb-m p-b-17 mt-3" >\
                                                                                <h3 class="mtext-107 cl2 p-r-20">\
                                                                                    ' + value.name + '\
                                                                                </h3>\
                                                                                <span class="fs-18 cl11">\
                                                                                    ' + starts + '\
                                                                                </span>\
                                                                            </div>\
                                                                            <p class="stext-102 cl6">\
                                                                                ' + value.content + '\
                                                                            </p>\
                                                            </div>\
                                                ');
                        } else {
                            $('.comment-product').append('<div class="border-bottom">\
                                                                <div class="flex-w flex-sb-m p-b-17 mt-3" id=' + value.id + '>\
                                                                                <h3 class="mtext-107 cl2 p-r-20">\
                                                                                    ' + value.name + '\
                                                                                </h3>\
                                                                                <span class="fs-18 cl11">\
                                                                                    ' + starts + '\
                                                                                </span>\
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
                })
            }
            // relatedProducts
            function relatedProducts(product) {
                $('#relatedProduct').empty();
                $.each(product, function(index, product) {
                    $('#relatedProduct').append('<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">\
                                                    <div class="block2">\
                                                        <div class="block2-pic hov-img0">\
                                                            <img  width="100%" src="' + "{{URL::to('/')}}/upload/images/product/" + product.image + '"  alt="IMG-PRODUCT">\
                                                        </div>\
                                                        <div class="block2-txt flex-w flex-t p-t-14">\
                                                            <div class="block2-txt-child1 flex-col-l ">\
                                                                <a href="{{route('frontend.product.detail.view')}}'+'?slug=' + product.category_slug + ''+'&id='+product.id+'"  class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">\
                                                                   '+product.name +'\
                                                                </a>\
                                                                <span class="stext-105 cl3">\
                                                                    '+product.price+'\
                                                                </span>\
                                                            </div>\
                                                            <div class="block2-txt-child2 flex-r p-t-3">\
                                                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">\
                                                                    <img class="icon-heart1 dis-block trans-04" src="{{asset('frontend/images/icons/icon-heart-01.png')}}" alt="ICON">\
                                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('frontend/images/icons/icon-heart-02.png')}}" alt="ICON">\
                                                                </a>\
                                                            </div>\
                                                        </div>\
                                                    </div>\
                                                </div>')
                })
                
            }
            function listImage(product,imgProduct){
                $('.list_image').empty();
                $('.list_image').append(' <div class="col-12">\
                                    <div class="thumbnail mb-3">\
                                        <img width="50%" src="{{URL::to('/')}}/upload/images/product/'+imgProduct+'" class="img-fluid selected small-image" alt="Small Image 1" data-index="0">\
                                    </div>\
                                </div>')
                let k=0;
                $.each(product, function(index, product) {
                    k=k+1;
                    $('.list_image').append(' <div class="col-12">\
                                    <div class="thumbnail mb-3">\
                                        <img width="50%" src="{{URL::to('/')}}/upload/images/product/'+product+'" class="img-fluid small-image" alt="Small Image 1" data-index="'+k+'">\
                                    </div>\
                                </div>')
                    
                })
                $('.imageMainProduct').append('<img width="100%" src="{{URL::to('/')}}/upload/images/product/'+imgProduct+'" id="" class="img-fluid mb-3 large-image" alt="Large Image">')
            }
            $(document).ready(function(){ 
                featchProductDetail(slug,id);
            })
        })
       

    </script>
    <script>
        //slider image product
        var currentImageIndex = 0;
                // Function to show image based on index
                function showImage(index) {
                    $('.small-image').removeClass('selected');
                    // Thêm border vào ảnh mới
                    $('.small-image').eq(index).addClass('selected');
                    // Hiển thị ảnh lớn tương ứng
                    $('.large-image').attr('src', $('.small-image').eq(index).attr('src'));
                    // Cập nhật chỉ số ảnh hiện tại
                    currentImageIndex = index;
                }

                // Show first image on page load
              

                // Next button click event
                $('.next_img').click(function() {
                        var totalImages = $('.list_image .small-image').length;
                        currentImageIndex = (currentImageIndex + 1) % totalImages;
                        showImage(currentImageIndex);
                });
                $('.prev_img').click(function() {
                    var totalImages = $('.list_image .small-image').length;
                    currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages;
                    showImage(currentImageIndex);
                });
                // Small image click event
                $(document).on('click','.small-image',function() {
                    currentImageIndex = $(this).data('index');
                    console.log(currentImageIndex);
                    showImage(currentImageIndex);
                });
                
            

            $(document).ready(function(){
                showImage(currentImageIndex);
            })
          
             
            

    </script>
    
    <script>
        //add cart
        $('.js-addcart-detail').click(function(event){
                event.preventDefault();
                let currentURL = window.location.href;
                // Tạo một đối tượng URL từ URL hiện tại
                let url = new URL(currentURL);

                // Lấy tham số từ URL
                let params = new URLSearchParams(url.search);

                // Lấy giá trị của các tham số
                let slug = params.get('slug');
                let idPd = params.get('id');
               let qty=$('.js-num-product').val().trim();
               let idColor=$('.js-color-product').val().trim();
               let idSize=$('.js-size-product').val().trim();
               if($.isNumeric(idColor) && $.isNumeric(idSize)&& $.isNumeric(qty)){
                    $.ajax({
                        url:"http://127.0.0.1:8000/add-cart",
                        type:"Post",
                        data:{"id":idPd,'idColor':idColor,'idSize':idSize,'qty':qty},
                        headers: {
                                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                        },
                        beforeSend:function(){
                            $('.js-addcart-detail').text('Processing...');
                        },
                        success:function(result){
                            $('.js-addcart-detail').text('Add to cart');
                            if(result.cod==200){
                                $('.check_out').show();
                                swal('Message', result.mess, "success");
                                $('.js-show-cart').attr('data-notify',result.count);
                               
                                // Lấy thông tin về sản phẩm vừa thêm vào giỏ hàng
                                var updatedCartItem = result.lastCart;
                                var cartItemSelector = '.header-cart-item-info[data-product-id="' +  updatedCartItem.id + updatedCartItem.options.size +updatedCartItem.options.color + '"]';
                                var existingCartItem = $(cartItemSelector);
                                console.log(existingCartItem.length)
                                if (existingCartItem.length > 0) {
                                   
                                    console.log(updatedCartItem.price+'         '+updatedCartItem.qty);
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
                                    var newQuantity = updatedCartItem.qty;
                                    existingCartItem.text(updatedCartItem.options.price_sell + ' X ' + newQuantity);
                                } else {
                               
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới vào danh sách
                                    let cartItemHtml = '<li class="header-cart-item flex-w flex-t m-b-12" data-id="'+updatedCartItem.rowId+'">' +
                                        '<div class="header-cart-item-img">' +
                                        '<img src="{{URL::to('/')}}/upload/images/product/' + updatedCartItem.options.image + '" alt="IMG">' +
                                        '</div>' +
                                        '<div class="header-cart-item-txt p-t-8">' +
                                        '<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">' +
                                        updatedCartItem.name +
                                        '</a>' +
                                        '<span class="header-cart-item-info" data-product-id="' + updatedCartItem.id + updatedCartItem.options.size +updatedCartItem.options.color + '">' +
                                        updatedCartItem.options.price_sell + ' X ' + updatedCartItem.qty +
                                        '</span>' +
                                        '</div>' +
                                        '</li>';
                                    $('.header-cart-wrapitem').append(cartItemHtml);
                                }
                                $('.header-cart-total').text(" Total: "+result.total)

                            }
                        },
                        error: function(xhr) {
                            if(xhr.status==401|| xhr.status === 404){
                                window.location.href="http://127.0.0.1:8000/login"
                            }
                        }
                    })
                }else{
                    swal('Message', "Choose color and size and quantity", "error");
                }
            });
    </script>
    <script>
            $('.item-rating').on('click', function() {
                var rating = $(this).data('value');
                $('#rating').val(rating);
            })
            $('.btn-review').click(function(event){
                event.preventDefault();
                if(localStorage.getItem('username')){
                    var url = window.location.href;
                    // Create a URL object
                    var urlParams = new URL(url);
                    // Use URLSearchParams to get the id parameter
                    var idPd = urlParams.searchParams.get('id');
                    var formData = $('.form-review').serialize();
                    formData += '&idPd=' + idPd+'&username='+localStorage.getItem('username');
                    console.log('====================================');
                    console.log(formData);
                    console.log('====================================');
                    $.ajax({
                        type:'POST',
                        url:'http://127.0.0.1:8000/createReview',
                        data:formData,

                        success: function(data,textStatus,xhr) {
                            if(xhr.status==200){
                                var starts="";
                                for(var i=0;i<5;i++){
                                    if(i<data.comment.start){
                                        starts += '<i class="zmdi zmdi-star"></i>';
                                    }else{
                                        starts += '<i class="zmdi zmdi-star-outline"></i>';
                                    }
                                }
                                $('.comment-product').append('<div class="flex-w flex-sb-m p-b-17">\
                                                    <span class="mtext-107 cl2 p-r-20">\
                                                        '+localStorage.getItem('username')+'\
                                                    </span>\
                                                    <span class="fs-18 cl11">\
                                                        '+starts+'\
                                                    </span>\
                                                </div>\
                                                <p class="stext-102 cl6">\
                                                    '+data.comment.content+'\
                                                </p>')
                                $('.form-review').find('input, textarea, select').val('');
                            }
                        },
                        error: function(xhr) {
                           
                        }
                    })
               
                }else{
                    window.location.href="http://127.0.0.1:8000/login"
                }
              
                
            })

    </script>
   
    
@endpush

