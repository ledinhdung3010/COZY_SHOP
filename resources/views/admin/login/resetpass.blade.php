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
            <div class="col-sm-12 col-md-12">
                <div class="mb-3">
                    <h3>Nhap mật khẩu bạn cần thay đổi</h3>
                    <form action="{{route('admin.login.handleResetPassword',['id'=>$id,'code'=>$code])}}" method="post">
                        @csrf
                        <label for="">Password</label>
                        <input type="text" class="form-control" name="password" value="">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary mt-3">Reset</button>
                    </form>
                    
                </div>
                
            </div>
            
            
        </div>
    </div>
</body>
</html>