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
    


<div class="row">
    <div class="col-sm-12 col-md-12">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form  class="border p-3" id="form_register" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">UserName <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" value="{{old('username')}}">
                        <span class="text-danger error-message error_username"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="Email" class="form-control" name="email" value="">
                        <span class="text-danger error-message error_email"></span>
                    </div>
                    <div class="mb-3">
                        <label for="">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">Gender <span class="text-danger">*</span></label>
                        <select name="gender" id="" class="form-control">
                            <option value="">-- Chose --</option>
                            <option value="1"  {{old('status')=="1" ? 'selected': ''}}>Nam</option>
                            <option value="2" {{old('status')=="2" ? 'selected': ''}}>Nu</option>
                            <option value="3" {{old('status')=="2" ? 'selected': ''}}>Khac</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" value="">
                    </div>

                </div>
                <div class="col-sm-12 col-md-6">
                    
                    <div class="mb-3">
                        <label for="">Birthday</label>
                        <input type="date" class="form-control" name="birthday" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">FirstName <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="first_name" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">LastName <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="last_name" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">Avatar</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                
                    <button type="submit" class="btn btn-primary btn-lg btn-register">Submit</button>
                </div>
            </div>
            
            
        </form>
    </div>
</div>

</body>
</html>
<script src="{{asset('admin/js/jquery-3.7.1.min.js')}}"></script>
<script>
         $('#form_register').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"http://127.0.0.1:8000/admin/register/create",
                type:"Post",
                data:formData,
                processData: false, // Don't process the files
                contentType: false,
                success:function(data,textStatus,xhr){
                    if(xhr.status==200){
                        localStorage.setItem('token',data.token);
                        window.location.href='http://127.0.0.1:8000/admin/register/resend';
                    }
                   
                },
                error: function(xhr) {
                    $('.error-message').empty();
                    var errors = xhr.responseJSON.errors;
                   if(xhr.status==500){
                        var error_username = xhr.responseJSON.username;
                        if(error_username){
                            $('.error_username').text(error_username);
                        }
                        var error_email = xhr.responseJSON.email;
                        if(error_email){
                            $('.error_email').text(error_email);
                        }
                   }
                }
            })
                    
    })
</script>