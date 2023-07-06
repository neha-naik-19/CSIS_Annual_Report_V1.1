


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
        
            <!-- Styles -->
            <link rel="stylesheet" type="text/css" href="../css/styles.css">
            
            @routes
        </head>
        <body style="background: white;">
            <div id="app">
                <div class="container">
                    <div class="login-alert">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div>
                                        <label style="font-size: 20px;"><strong>The email ID you are using to Sign-In is different..</strong></label>
                                    </div><br>
                                    <div>
                                        <label style="font-size: 15px;"><strong>Kindly Sign-In with Bits email ID.</strong></label>
                                    </div><br>
                                    <div>
                                        <a class="btn btn-danger" href="/login">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
        
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
            <script src="{{ asset('js/home.js') }}" defer></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        </body>
        </html>
               

