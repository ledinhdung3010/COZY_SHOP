<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VNPAY</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="spinner-grow text-primary" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-success" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-info" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-light" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-dark" role="status">
            <span class="sr-only">Loading...</span>
            </div>
    </div>
    
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{asset('admin/js/jquery-3.7.1.min.js')}}"></script>
<script>
    $(document).ready(function(){
        const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('code');
    const id = urlParams.get('id');
    $.ajax({
                url:"http://127.0.0.1:8000/admin/register/verify",
                type:"Get",
                data:{
                    'token':token,
                    'id':id
                },
                success:function(data,textStatus,xhr){
                   if(xhr.status==200){
                    localStorage.setItem('message_success',data.message);
                    window.location.href='http://127.0.0.1:8000/admin/login';
                   }
                },
                error: function(xhr) {
                    if(xhr.status==422){
                        var error=xhr.responseJSON.error;
                        localStorage.setItem('message_error',error);
                        window.location.href='http://127.0.0.1:8000/admin/login';
                    }
                }
            })
    })
    
                    
</script>