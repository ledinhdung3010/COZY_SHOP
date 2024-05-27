<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row">
            @if(isset($error_resetpassword))
                <div class="alert alert-danger">
                    {{ $error_resetpassword }}
                </div>
            @endif
            <div class="col-sm-12 col-md-12">
                <div class="mb-3">
                    <h3>Nhap Email dang ky tai khoan cua ban</h3>
                    <form method="post">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{old('email')}}">
                        <div class="error_message">

                        </div>
                        <button type="submit" class="btn btn-primary mt-3 btn-reset">Reset</button>
                    </form>
                    
                </div>
                
            </div>
            
            
        </div>
    </div>
</body>
</html>
<script src="{{asset('admin/js/jquery-3.7.1.min.js')}}"></script>
<script>
    $('.btn-reset').click(function(e){
        e.preventDefault();
        var emailValue = $('input[name="email"]').val();
        $.ajax({
                url:"http://127.0.0.1:8000/admin/resetpassword/checkEmail",
                type:"POST",
                data:{email:emailValue},
                success:function(data,textStatus,xhr){
                    if(xhr.status==422){
                        $('.error_message').append('<div class="alert alert-danger">\
                                                        <p>'+data.message+'</p>\
                                                    </div>')
                    }else{
                        window.location.href="http://127.0.0.1:8000/admin/resetpassword/viewResend";
                    }
                },
                error: function(xhr) {
                    if(xhr.status==422){
                        var error=xhr.responseJSON.errors;
                        $.each(error, function(key, value) {
                            $('.error_message').append('<div class="alert alert-danger">\
                                                        <p>'+value+'</p>\
                                                    </div>')
                        })
                        
                    }
                    
                }
            })
    })
</script>