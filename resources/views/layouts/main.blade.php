<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr"
  data-theme="theme-default" data-assets-path="../../../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  @if (Auth::user()->role == 1)
    <title>Dashboard - Super Admin</title>
  @elseif (Auth::user()->role == 2)
    <title>Dashboard - Admin</title>
  @elseif (Auth::user()->role == 3)
    <title>Dashboard - Pool</title>
  @elseif (Auth::user()->role == 4)
    <title>Dashboard - Kepala Kantor</title>
  @endif
  <meta name="description" content="" />

  <link rel="icon" type="image/x-icon"
    href="../../../assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="../../../assets/vendor/fonts/boxicons.css" />

  <link rel="stylesheet" href="../../../assets/vendor/css/core.css"
    class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../../assets/vendor/css/theme-default.css"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../../assets/css/demo.css" />

  <link rel="stylesheet"
    href="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet"
    href="../../../assets/vendor/libs/apex-charts/apex-charts.css" />

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="../../../assets/vendor/js/helpers.js"></script>
  <script src="../../../assets/js/config.js"></script>

  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('partials.' . Auth::user()->getRole->nama_role . '.sidebar')
      <div class="layout-page">
        @include('partials.navbar')
        <div class="content-wrapper">
          @yield('content')
          @include('partials.footer')
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../../assets/vendor/js/bootstrap.js"></script>
  <script
    src="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js">
  </script>
  <script src="../../../assets/js/extended-ui-perfect-scrollbar.js"></script>
  <script src="../../../assets/vendor/js/menu.js"></script>
  <script src="../../../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
  </script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js">
  </script>
  {{-- if width media < 700 navbar add class fixed and after scroll --}}
  <script>
    $(window).scroll(function() {
      if ($(window).width() < 700) {
        if ($(window).scrollTop() >= 150) {
          $('.navbar-hidden').removeClass('d-none');
        } else {
          $('.navbar-hidden').addClass('d-none');
        }
      }
    });
  </script>
  <script>
    function goBack() {
      window.history.back();
    }
  </script>

</body>

</html>
