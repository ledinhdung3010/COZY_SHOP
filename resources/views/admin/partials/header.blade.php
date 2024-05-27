<header class="header header-sticky mb-4">
    <div class="container-fluid">
      <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
        <svg class="icon icon-lg">
          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
        </svg>
      </button><a class="header-brand d-md-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
          <use xlink:href="assets/brand/coreui.svg#full"></use>
        </svg></a>
      <ul class="header-nav d-none d-md-flex">
        <li class="nav-item">
          <a href="#" class="nav-link">HI: <span class="username"></span></a>
        </li>
        {{-- <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Settings</a></li> --}}
      </ul>
      <ul class="header-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
              <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-bell')}}"></use>
            </svg></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
              <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-list-rich')}}"></use>
            </svg></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
              <use xlink:href="{{asset('admin/vendors/@coreui/icons/svg/free.svg#cil-envelope-open')}}"></use>
            </svg></a></li>
      </ul>
      <ul class="header-nav ms-3">
        <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-md"><img class="avatar-img" src="" alt="user@email.com"></div>
          </a>
          <div class="dropdown-menu dropdown-menu-end pt-0">
            <div class="dropdown-header bg-light py-2">
              <div class="fw-semibold">Account</div>
            </div><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
              </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span></a><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
              </svg> Messages<span class="badge badge-sm bg-success ms-2">42</span></a><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-task"></use>
              </svg> Tasks<span class="badge badge-sm bg-danger ms-2">42</span></a><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-comment-square"></use>
              </svg> Comments<span class="badge badge-sm bg-warning ms-2">42</span></a>
            <div class="dropdown-header bg-light py-2">
              <div class="fw-semibold">Settings</div>
            </div><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
              </svg> Profile</a><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
              </svg> Settings</a><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-credit-card"></use>
              </svg> Payments<span class="badge badge-sm bg-secondary ms-2">42</span></a><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-file"></use>
              </svg> Projects<span class="badge badge-sm bg-primary ms-2">42</span></a>
            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
              </svg> Lock Account</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('admin.changepassword')}}">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                </svg>Change Password</a>
            
              
                <button class="dropdown-item" type="submit" id="log_out">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                  </svg> Logout
                </button>
            
              
          </div>
        </li>
      </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
          <li class="breadcrumb-item">
            <!-- if breadcrumb is single--><span>@yield('breadcrumb-item-1')</span>
          </li>
          <li class="breadcrumb-item active"><span>@yield('breadcrumb-item-2')</span></li>
        </ol>
      </nav>
    </div>
  </header>
  @push('javascript')
  <script>
      $(document).ready(function(){
        $.ajax({
                url:'http://127.0.0.1:8000/admin/checkTimeToken',
                type:'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                success: function(response) {
                  
                },
                error: function(xhr) {
                      if (xhr.status == 401) {
                        localStorage.clear();
                        window.location.href = 'http://127.0.0.1:8000/admin/login';
                      }
                }
          })
        var username = localStorage.getItem('username');
        var avatar = localStorage.getItem('avatar');
        var avatar_gg = localStorage.getItem('avatar_gg');
        if(avatar_gg){
          $(".avatar-img").attr("src",avatar_gg);
        }else{
          $(".avatar-img").attr("src", '{{URL::to('/')}}/upload/images/user/'+avatar+'');
        }
          $('.username').text(username)
         
      });
      $('#log_out').click(function(event){
        event.preventDefault();
        console.log(localStorage.getItem('jwt_token'));
        $.ajax({
                type:'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
                },
                url:'http://127.0.0.1:8000/admin/logout',
                success: function(response) {
                  localStorage.clear();
                  window.location.href = 'http://127.0.0.1:8000/admin/login';
                }
          })
      })
  </script>
@endpush