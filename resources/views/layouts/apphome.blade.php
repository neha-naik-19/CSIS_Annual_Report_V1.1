<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Annual Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    
    {{-- @routes --}}
    <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
</head>
<body style="background: white;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <div>
                    <img class="rounded" src="../image/BITS_Logo.jpg" alt="BITS Logo">
                    <span class="bits">bits pilani k. k. birla goa campus <br><span class="annualreport">annual report</span></span>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>
        
        <main>
            <div class="container mt-5">
              <div class="card">
                <div class="card-header">
                  <!-- <nav> -->
                  <div class="nav nav-tabs p-3" id="nav-tab" role="tablist">
                    <button
                      class="nav-link active"
                      id="nav-publication-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#nav-publication"
                      type="button"
                      role="tab"
                      aria-controls="nav-publication"
                      aria-selected="true"
                    >
                      Publication
                    </button>
                    <button
                      class="nav-link"
                      id="nav-project-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#nav-project"
                      type="button"
                      role="tab"
                      aria-controls="nav-project"
                      aria-selected="false"
                    >
                      Project
                    </button>
                    <button
                      class="nav-link"
                      id="nav-books-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#nav-books"
                      type="button"
                      role="tab"
                      aria-controls="nav-books"
                      aria-selected="false"
                    >
                      Books
                    </button>
                  </div>
                  <!-- </nav> -->
                </div>
      
                <div class="card-body">
                  <div class="tab-content" id="nav-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="nav-publication"
                      role="tabpanel"
                      aria-labelledby="nav-publication-tab"
                    >
                      @yield('content')
                    </div>
                    <div
                      class="tab-pane fade"
                      id="nav-project"
                      role="tabpanel"
                      aria-labelledby="nav-project-tab"
                    >
                      Project
                    </div>
                    <div
                      class="tab-pane fade"
                      id="nav-books"
                      role="tabpanel"
                      aria-labelledby="nav-books-tab"
                    >
                      Books
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </main>

        <footer class="footer fixed-bottom">
            <div class="container-fluid p-0">
                <p class="text-light text-muted">© {{ now()->year }} BITS Pilani Goa Campus</p>
                <div id="imgdiv">
                    <img
                    src="../image/bits-line.gif" class="d-block w-25" alt="..."
                    />
                </div>
            </div>
        </footer>
    </div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Include Bootstrap Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/home.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
