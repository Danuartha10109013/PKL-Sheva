

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('vendorin')}}/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{asset('zen-blue-logo.png')}}">
  <title>
    Login || PT. Zen Multimedia Indonesia
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('vendorin')}}/assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-6 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter email or username and password to sign in</p>
                </div>
                @if (session('success'))
                  <script>
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: '{{ session('success') }}',
                      showConfirmButton: false,
                      timer: 3000
                    });
                  </script>
                @endif

                @if (session('error'))
                  <script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: '{{ session('error') }}',
                      showConfirmButton: false,
                      timer: 3000
                    });
                  </script>
                @endif

                @if ($errors->any())
                  <script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Validation Error!',
                      html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
                      showConfirmButton: true
                    });
                  </script>
                @endif
                <div class="card-body">
                  <form role="form" action="{{route('input_login')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control form-control-lg" placeholder="Email" aria-label="Email Or Username">
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://mir-s3-cdn-cf.behance.net/project_modules/1400_opt_1/e403d7208953083.66f6e8211b181.jpg');
          background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Yoviuu"</h4>
                <p class="text-white position-relative">This is For You</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="{{asset('vendorin')}}/assets/js/core/popper.min.js"></script>
  <script src="{{asset('vendorin')}}/assets/js/core/bootstrap.min.js"></script>
  <script src="{{asset('vendorin')}}/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{asset('vendorin')}}/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('vendorin')}}/assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>