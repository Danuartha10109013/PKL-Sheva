<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Sleek Dashboard - Free Bootstrap 4 Admin Dashboard Template and UI Kit. It is very powerful bootstrap admin dashboard, which allows you to build products like admin panels, content management systems and CRMs etc.">

    <title>Sign In - Sleek Admin Dashboard Template</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" />
    <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

    <!-- SLEEK CSS -->
    <link id="sleek-css" rel="stylesheet" href="{{asset('vendor/theme')}}/assets/css/sleek.css" />

    <!-- FAVICON -->
    <link href="{{asset('vendor')}}/zen.png" rel="shortcut icon" />

    <!--
      HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="{{asset('vendor/theme')}}/https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="{{asset('vendor/theme')}}/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="{{asset('vendor/theme')}}/assets/plugins/nprogress/nprogress.js"></script>
  </head>

  <body class="" id="body">
    <div class="container d-flex align-items-center justify-content-center vh-100">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
          <div class="card">
            <div class="card-header bg-primary">
              <div class="app-brand">
                <a href="/index.html">
                  <img src="{{asset('vendor/zen.png')}}" alt="">

                  <span class="brand-name">PROJECT PLAN</span>
                </a>
              </div>
            </div>

            <div class="card-body p-5">
              <h4 class="text-dark mb-5">Sign In</h4>

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

              <form action="{{route('input_login')}}" method="POST" >
                @csrf
                <div class="row">
                  <div class="form-group col-md-12 mb-4">
                    <input type="text" name="username" class="form-control input-lg" id="email" aria-describedby="emailHelp" placeholder="Username">
                  </div>

                  <div class="form-group col-md-12 ">
                    <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password">
                  </div>

                  <div class="col-md-12">
                    <div class="d-flex my-2 justify-content-between">
                      <div class="d-inline-block mr-3">
                        <label class="control control-checkbox">Remember me
                          <input type="checkbox" />
                          <div class="control-indicator"></div>
                        </label>
                      </div>

                      <p><a class="text-blue" href="#">Forgot Your Password?</a></p>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Sign In</button>

                    <p>Don't have an account yet ?
                      <a class="text-blue" href="sign-up.html">Sign Up</a>
                    </p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- <script type="module">
      import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';

      const el = document.createElement('pwa-update');
      document.body.appendChild(el);
    </script> -->

    <!-- Javascript -->
    <script src="{{asset('vendor/theme')}}/assets/plugins/jquery/jquery.min.js"></script>
    <script src="{{asset('vendor/theme')}}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('vendor/theme')}}/assets/js/sleek.js"></script>
  <link href="{{asset('vendor/theme')}}/assets/options/optionswitch.css" rel="stylesheet">
<script src="{{asset('vendor/theme')}}/assets/options/optionswitcher.js"></script>
</body>
</html>
