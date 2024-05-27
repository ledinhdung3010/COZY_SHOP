<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resend</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row">
        <div class="message">

        </div>
            <div class="col-sm-12 col-md-12">
                <div class="mb-3">
                    <h3>Bạn vui long check Gmail để hoàn thành đăng ký</h3>
                </div>
                <div class="mb-3 d-flex justify-content-center align-items-center">
                    <a href="" class="btn btn-primary btn-resend">Gui lai Email</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="{{asset('admin/js/jquery-3.7.1.min.js')}}"></script>
<script>
    $('.btn-resend').click(function(e){
        e.preventDefault();
        $.ajax({
                url:"http://127.0.0.1:8000/admin/register/resendEmail",
                type:"Get",
                success:function(data,textStatus,xhr){
                    $('.message').empty();
                    $('.message').append('<div class="alert alert-success">\
                                                <p>'+data.message+'</p>\
                                            </div>')
                },
                error: function(xhr) {
                    if(xhr.status==422){
                        var message=xhr.responseJSON.message;
                        localStorage.setItem('message_success',message);
                        window.location.href='http://127.0.0.1:8000/admin/login';
                    }
                }
            })
    })
</script>