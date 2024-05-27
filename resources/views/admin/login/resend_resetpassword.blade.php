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
        
            <div class="col-sm-12 col-md-12">
                <div class="mb-3">
                    <h3>Bạn vui long check Gmail để đổi lại mật khẩu</h3>
                </div>
                <div class="mb-3 d-flex justify-content-center align-items-center">
                    <a href="{{route('admin.login.resend_password')}}" class="btn btn-primary">Gui lai Email</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>