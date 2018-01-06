<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

/*
            .full-height {
                height: 100vh;
            }
*/

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
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
<!--                 style="margin-top:50px;"-->
                <div class="container">
                   <div class="title m-b-md">
                    Laravel
                </div>
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#myCarousel" data-slide-to="1"></li>
                          <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">

                          <div class="item active">
                            <img src="{{asset('img/la.jpg')}}" alt="Los Angeles" style="width:100%;">
                            <div class="carousel-caption">
                              <h3>Los Angeles</h3>
                              <p>[Our site] is a plain donation platform which allows users to donate freely to other needy users in return for a 30% yield on their donation in 30 days. The platform also allows members to refer their friend and families to the platform and earn 10% of whatsoever their friends and families donate to other needy users.</p>
                            </div>
                          </div>

                          <div class="item">
                            <img src="{{asset('img/chicago.jpg')}}" alt="Chicago" style="width:100%;">
                            <div class="carousel-caption">
                              <h3>Chicago</h3>
                              <p>[Our site] was launched to afford people the opportunity to make steady passive income for themselves while helping others to make some income too.</p>
                            </div>
                          </div>

                          <div class="item">
                            <img src="{{asset('img/ny.jpg')}}" alt="New York" style="width:100%;">
                            <div class="carousel-caption">
                              <h3>New York</h3>
                              <h3>Here each donating user will earn 30% of his donation after 30 days. The user can also earn additional 10% referral bonus. This is because we reward users who help to sustain the system and there is no limit to the number of times a user can earn referral bonus.

Support us by referring our platform to prospective users.
</h3>
                            </div>
                          </div>
  
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                          <span class="glyphicon glyphicon-chevron-right"></span>
                          <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
