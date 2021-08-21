<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DestroRadius</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
           

            <div class="content">
               <div class="px-4 py-5 my-5 text-center">
                  <img src="{{ asset('/images/u1.png') }}" class="rounded-circle" height="100" width="100">
                  <h1 class="display-5 fw-bold">DestroRadius</h1>
                  <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">Web Management Portal for <b>Freeradius</b>. Easily manage Radius Hotspot Customers using DestroRadius on the web interface.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                      <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-sm-3">Go To Admin Login</a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </body>
</html>
