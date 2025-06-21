<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{url('vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{url('vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{url('vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{url('vendors/font-awesome/css/font-awesome.min.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{url('vendors/font-awesome/css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{url('vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{url('css/style.css')}}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{url('images/favicon.png')}}" />
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(formId, title, text, confirmButtonText, cancelButtonText) {
    Swal.fire({
      title: title,
      text: text,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: confirmButtonText,
      cancelButtonText: cancelButtonText
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('form-' + formId).submit();
      }
    });
  }
</script>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="index.html"><img src="{{url('images/logo.svg')}}" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{url('images/logo-mini.svg')}}"
            alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              </div>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
            </div>
          </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
              aria-expanded="false">
              <div class="nav-profile-img">
                <img src="{{url('images/faces/face1.jpg')}}" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">{{ auth()->user()->name }}</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
              <div class="dropdown-divider"></div>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              <a class="dropdown-item" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout me-2 text-primary"></i> Signout
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
              <span class="count-symbol bg-warning"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Messages</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{url('images/faces/face4.jpg')}}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                  <p class="text-gray mb-0"> 1 Minutes ago </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{url('images/faces/face2.jpg')}}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                  <p class="text-gray mb-0"> 15 Minutes ago </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{url('images/faces/face3.jpg')}}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                  <p class="text-gray mb-0"> 18 Minutes ago </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">4 new messages</h6>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
              data-bs-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
              aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Notifications</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-calendar"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                  <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-cog"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                  <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-link-variant"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                  <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">See all notifications</h6>
            </div>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="#"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
          <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="{{ url('images/faces/face1.jpg') }}" alt="profile" />
                <span class="login-status online"></span>
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">{{ auth()->user()->name }}</span>
                <span class="text-secondary text-small">{{ ucfirst(auth()->user()->role) }}</span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>

          @if(auth()->user()->role === 'superadmin')
        <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.companies.index') }}">
          <span class="menu-title">Perusahaan</span>
          <i class="mdi mdi-domain menu-icon"></i>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.users.index') }}">
          <span class="menu-title">Users</span>
          <i class="mdi mdi-account-multiple menu-icon"></i>
        </a>
        </li>
      @endif

          @if(auth()->user()->role === 'admin')
        <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
          <span class="menu-title">Karyawan</span>
          <i class="mdi mdi-account-group menu-icon"></i>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.leaves.index') }}">
          <span class="menu-title">Pengajuan Cuti</span>
          <i class="mdi mdi-calendar-clock menu-icon"></i>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.salaries.index') }}">
          <span class="menu-title">Gaji Karyawan</span>
          <i class="mdi mdi-cash-multiple menu-icon"></i>
        </a>
        </li>
      @endif

          @if(auth()->user()->role === 'manager')
        <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.leaves.index') }}">
          <span class="menu-title">Approve Cuti</span>
          <i class="mdi mdi-check-decagram menu-icon"></i>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('salaries.index') }}">
          <span class="menu-title">Gaji</span>
          <i class="mdi mdi-cash-multiple menu-icon"></i>
        </a>
        </li>
      @endif

          @if(auth()->user()->role === 'employee')
        <li class="nav-item">
        <a class="nav-link" href="{{ route('employee.leaves.index') }}">
          <span class="menu-title">Ajukan Cuti</span>
          <i class="mdi mdi-calendar-plus menu-icon"></i>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('employee.salaries.byUser') }}">
          <span class="menu-title">Lihat Gaji</span>
          <i class="mdi mdi-cash-multiple menu-icon"></i>
        </a>
        </li>
      @endif
        </ul>
      </nav>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{url('vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{url('vendors/chart.js/chart.umd.js')}}"></script>
  <script src="{{url('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{url('js/off-canvas.js')}}"></script>
  <script src="{{url('js/misc.js')}}"></script>
  <script src="{{url('js/settings.js')}}"></script>
  <script src="{{url('js/todolist.js')}}"></script>
  <script src="{{url('js/jquery.cookie.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="{{url('js/dashboard.js')}}"></script>
  <!-- End custom js for this page -->
  @yield('scripts')

</body>

</html>