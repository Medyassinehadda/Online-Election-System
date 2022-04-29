@extends('layout')

@section('content')
<header>
  <!-- Navbar-->
  <nav id="navbarAnim" class="navbar navbar-expand-lg fixed-top py-3" style=>
      <div class="container"><a href="#" class="navbar-brand text-uppercase font-weight-bold">Online Election System</a>

          <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" class="navbar-toggler navbar-toggler-right">
            <i class="fa fa-bars" style="font-size:25px"></i>
          </button>

          <div id="navbarSupportedContent" class="collapse navbar-collapse">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item active"><a href="#" class="nav-link text-uppercase font-weight-bold">Home <span class="sr-only">(current)</span></a></li>
                  <li class="nav-item"><a href="#welcome" class="nav-link text-uppercase font-weight-bold">About</a></li>
                  <li class="nav-item"><a href="#condidates" class="nav-link text-uppercase font-weight-bold">Condidates</a></li>
                  <li class="nav-item"><a href="#contactus" class="nav-link text-uppercase font-weight-bold">Contact us</a></li>
                  
                  @if (Auth::check())
                    <li class="nav-item dropdown">
                      
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="position: relative;padding-left:60px">
                        <img src="avatar/{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="width:45px;height:45px;position:absolute;border-radius:50%;margin-top:-8px;left:8px;object-fit: cover;">
                        {{ Auth::user()->name }}
                      </a>
                      
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                  @else
                    <li class="nav-item">
                      <a data-toggle="modal" data-target="#LoginModal" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                      <a id="OpenCamRe" data-toggle="modal" data-target="#registerModal" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                  @endif

              </ul>
          </div>
      </div>
  </nav>
</header>

@guest

  @if (Route::has('login'))
            <!-- Modal -->
              <div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      
                        <form method="POST" action="{{ route('login') }}">
                          @csrf

                          <div class="form-group row">
                              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                              <div class="col-md-6">
                                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                  @error('email')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                              <div class="col-md-6">
                                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                  @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                      <label class="form-check-label" for="remember">
                                          {{ __('Remember Me') }}
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      {{ __('Login') }}
                                  </button>

                                  @if (Route::has('password.request'))
                                      <a class="btn btn-link" href="{{ route('password.request') }}">
                                          {{ __('Forgot Your Password?') }}
                                      </a>
                                  @endif
                              </div>
                          </div>
                      </form>
                    </div>
                    
                  </div>
                </div>
              </div>
              <!-- Fin Modal -->
      
  @endif

  @if (Route::has('register'))
          <!-- Modal -->
          <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Register</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  
                  <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('avatar') }}</label>

                      <div class="col-md-6">
                        <!-- Camera -->
                          <div id="my_camera"></div>
                          <input id="snapInput" type=button class="btn btn-sm btn-primary" value="Take Snapshot" onClick="take_snapshot()">
                          <input type="hidden" id="avatar"  name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                          
                          <div id="results">
                            <img id="PicCap" src=""/>
                          </div>

                          <input id="RepeatPic" type=button class="btn btn-sm btn-primary" value="Repeat Picture" onClick="Rep_snapshot()">
                          
                          {{-- ***********************************--}}
                          <script type="text/javascript">
                            var avatarss = @json($avatars);
                          </script>
                          
                          <script src="cam/face-api.min.js"></script>
                          <script src="cam/camera.js"></script>
                          {{-- ***********************************--}}

                          @error('avatar')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror

                          @error('resultDet')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                    </div>                            

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
          </div>
  @endif
@endguest

<!-- Page Content -->
<section class="py-5" style="background-color: #fff">

  <div class="jumbotron" style="min-height: 250px;margin-top:-5%">
    <div class="container text-center" style="padding-top:12%;color:#47126b;">
      <h1 style="font-size:60px">
        Welcome to Online Election System
      </h1>     
      <p style="font-size:20px">every election is determined by the people who show up</p>
    </div>
  </div>

  <div class="wavesHeader" style="margin-top: -40px;">
    <img src="img/waveHeader.svg" alt="">
  </div>
    
    <!-- Help-->
    <div id="welcome" class="container-fluid" style="background-color: #fff;width:100%">
    <h1 class="text-center" style="text-align: center;color:#47126b">What is an Online Election System?</h1>
      <div class="container-fluid bg-3 text-center">
        <div class="row" style="padding: 5% 0 0 0;">
          <div class="col">
            <p style="font-size:20px;text-align: justify;padding:4%;color:#47126b">Online voting is a web-based voting system that will help you manage your elections easily and securely. 
              This voting system can be used for casting votes during the elections held in colleges, etc. 
              In this system the voter do not have to go to the polling booth to cast their vote. They can use their personal computer to cast their votes. 
              There is a database which is maintained in which all the name of the voters with their complete information is stored.
              The advantage of online voting is that the voters have the choice of voting at their own free time and there is reduced congestion. 
              It also minimizes on errors of vote counting. 
              The individual votes are submitted in a database which can be queried to find out who of the aspirants for a given post has the highest number of votes.</p>
          </div>
          <div class="col">
            <img src="img/undraw_voting1.svg" alt="" style="width:450px;height:auto;">
          </div>
          
        </div>
      </div>
    </div>
    <!-- fin help-->
  
  <div class="waveBodyTop" style="margin-bottom:-1px;">
    <img src="img/waveBodyTop.svg" alt="">
  </div>

  <!-- condidates-->
  <div class="condidatesDiv" id="condidates" style="display:block;">
    <div class="containerCon">
      
      <h1 class="text-center" style="text-align: center;padding: 0% 0 3% 0;width:100%;color:#47126b;">candidates</h1>
      
      @if (count($condidats)>0)

      <!-- loop -->
      @foreach ($condidats as $item)          
      <div class="card">
        <div class="content">
          <div class="imgBx">
            <img 
              src="{{ asset('images/' . $item->image_path) }}" 
              alt="">
          </div>
          <div class="contentBx">
            <h3>{{ $item->name }}<br><span>{{ $item->age }}</span></h3>
          </div>
        </div>
        <ul class="sci">
          <li style="--i:2">

            <a href="{{ asset('cvCondidats/' . $item->cv) }}" class="buttonCv">Voir CV</a>

          </li>
        </ul>
      </div>
      @endforeach 
      <!-- end loop -->

    </div>

    <div class="wrapperBtn">
      <a id="pushBtn" class="btnVote" href="" data-toggle="modal" data-target="#exampleModal1">
        Voting now
      </a>
    </div>

    @guest
    
      <!-- Modal -->
      <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Login</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger" role="alert">
                You need to login first 
              </div>
                <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <div class="form-group row">
                      <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                      <div class="col-md-6">
                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                      <div class="col-md-6">
                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-md-6 offset-md-4">
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                              <label class="form-check-label" for="remember">
                                  {{ __('Remember Me') }}
                              </label>
                          </div>
                      </div>
                  </div>

                  <div class="form-group row mb-0">
                      <div class="col-md-8 offset-md-4">
                          <button type="submit" class="btn btn-primary">
                              {{ __('Login') }}
                          </button>

                          @if (Route::has('password.request'))
                              <a class="btn btn-link" href="{{ route('password.request') }}">
                                  {{ __('Forgot Your Password?') }}
                              </a>
                          @endif
                      </div>
                  </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <!-- Fin Modal -->

    @else

        <!-- Modal Start -->
        <div class="modal fade" id="exampleModal1" role="dialog" aria-labelledby="exampleModalLabel"
            data-current-step="1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Vote</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                          {{-- start Form --}}
                        <form action="{{ route('voters.store') }}" method="POST">
                          @csrf

                            <fieldset data-step="1">
                              <div class="d-flex justify-content-between align-items-center">
                                  <h5>Condidats</h5>
                                  <span class="lead">#1</span>
                              </div>
                              <hr>
                              <div class="form-group row">
                                <table class="table">
                                  <tbody>
                                  
                                    <!-- start loop -->
                                    @foreach ($condidats as $item) 
                                      <tr>
                                        <th style="text-align: center;vertical-align: middle;">
                                          <img src="{{ asset('images/' . $item->image_path) }}" style="width:100px;height:100px;border-radius: 50%;vertical-align: middle;object-fit: cover;">
                                        </th>
                                        <td style="text-align: center;vertical-align: middle;">{{ $item->name }}</td>
                                        <td style="text-align: center;vertical-align: middle;">
                                          <input type="radio" id="{{ $item->name }}" name="myvote" value="{{ $item->name }}">
                                        </td>
                                      </tr>
                                    @endforeach
                                    <!-- end loop -->

                                  </tbody>
                                </table>
                              </div>
                            </fieldset>

                            <fieldset data-step="2">
                              <div class="d-flex justify-content-between align-items-center">
                                  <h5>Identity confirmation</h5>
                                  <span class="lead">#2</span>
                              </div>
                                <hr>
                              <div class="form-group row justify-content-center">
                                  
                                  <!-- Camera -->
                                  <div id="my_camera2"></div>
                                  <input id="snapInput2" type="button" class="btn btn-sm btn-primary" value="Take Snapshot" onClick="take_snapshot2()">
                                  
                                  <input type="hidden" id="avatarVoter"  name="avatarVoter">
                                  
                                  <div id="results2">
                                    <img id="PicCap2" src=""/>
                                    <img id="avatarProfile" src="avatar/{{ Auth::user()->avatar }}">
                                  </div>

                                  <input id="RepeatPic2" type="button" class="btn btn-sm btn-primary" value="Repeat Picture" onClick="Rep_snapshot2()">
                                  
                                  {{-- ****************************************** --}}
                                  <script type="text/javascript">
                                    var avatarsVoters = @json($avatarsVoters);
                                  </script>
                                  <script src="cam/face-api.min.js"></script>
                                  <script src="cam/camera2.js"></script>

                                  @if ($message = Session::get('erreur'))
                                    <script type="text/javascript">
                                      alert("Failed vote !!");
                                    </script>
                                  @endif

                                  @if ($message = Session::get('success'))
                                    <script type="text/javascript">
                                      alert('Vote added successfully');
                                    </script>
                                  @endif
                                  {{-- ****************************************** --}}
                                
                              </div>
                            </fieldset>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-step-to="prev">
                                  Previous
                              </button>
                              <button id="nextBtn" type="button" class="btn btn-success" data-step-to="next">
                                  Next
                              </button>
                              <input type="hidden" name="idVoter" value="{{ Auth::user()->id }}"> 
                              <button type="submit" class="btn btn-info">Confirm</button>
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End -->

    @endguest
  
  </div>
  
  @else
    <h4 style="color: #47126b;padding: 3% 0 6% 0;">There is no election right now, thanks for visiting our website</h4>
  @endif
  <!-- fin condidates-->
  
  <div class="wavesBodyBottom" style="margin-top:-1px;">
    <img src="img/waveBodyBottom.svg" alt="">
  </div>

    <!-- contact-->
      <div id="contactus" class="container-fluid" style="background-color: #fff;padding: 0% 6% 5% 6%;width:100%;color:#47126b">
        <h1 class="text-center" style="padding: 0 0 3% 0;">Contact Us</h1>
        <div class="row">
          <div class="col-sm-5">
            <p>Contact us and we'll get back to you within 24 hours.</p>
            <p><span class="glyphicon glyphicon-map-marker"></span> Bekalta - Monastir</p>
            <p><span class="glyphicon glyphicon-phone"></span> +216 93389987</p>
            <p><span class="glyphicon glyphicon-envelope"></span>xxxxxxxxxxx@gmail.com</p>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-6 form-group">
                <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
              </div>
              <div class="col-sm-6 form-group">
                <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
              </div>
            </div>
            <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
            <div class="row">
              <div class="col-sm-12 form-group">
                <button class="btn btn-default pull-right" type="submit">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- fin contact-->

</section>

<div class="wavesFooter" style="margin-bottom: -1px;margin-top:-8%">
  <img src="img/waveFooter.svg" alt="">
</div>

<footer class="footer" style="top: 0;width:100%">
    <div class="container-fluid" style="max-width: 1170px;margin:auto;">
        <div class="row" style="display: flex;flex-wrap:wrap;">
            <div class="footer-col">
                <h4>Contact info</h4>
                <ul class="ulfooter">
                    <li><a href="">Adresse: bekalta 5090</a></li>
                    <li><a href="">Monastir,Tunisia</a></li>
                    <li><a href="">Mobile: (+216) 93389987</a></li>
                    <li><a href="">Email: yassinehadda11@gmail.com</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>links</h4>
                <ul class="ulfooter">
                    <li><a href="">Home</a></li>
                    <li><a href="#welcome">About</a></li>
                    <li><a href="#condidates">Condidates</a></li>
                    <li><a href="#contactus">Contact Us</a></li>
                    <li><a href=""  data-toggle="modal" data-target="#exampleModal" >Admin Area</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>About us</h4>
                <ul class="ulfooter">
                    <p>
                      This voting system can be used for casting votes during the elections held in colleges, etc.
                      The advantage of online voting is that the voters have the choice of voting at their own free time and there is reduced congestion. 
                      It also minimizes on errors of vote counting.
                    </p>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Follow us</h4>
                <div class="social-links">
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-google"></i></a>
                    <a href=""><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>


{{-- SCRIPT --}}
<script>
  var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
  $(function () {
    var tags = $(".footer-col");
    
    $(window).on('scroll', function () {
        if ( $(window).scrollTop() > 2500 ) {
          $(tags).fadeIn(2000);
        } else {
          $(tags).fadeOut();
        }
    });
  });
</script>

<script>
    $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
    })
</script>

<script>
    $(function () {
        $(window).on('scroll', function () {
            if ( $(window).scrollTop() > 10 ) {
                $('.navbar').addClass('active');
                $('.fa-bars').addClass('active');
            } else {
                $('.navbar').removeClass('active');
                $('.fa-bars').removeClass('active');
            }
        });
    });
</script>

<script>
  $('#exampleModal1').modalWizard().on('submit', function (e) {
      $(this).modal('hide');
  });
</script>

<script>
  /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
  var prevScrollpos = window.pageYOffset;
  window.onscroll = function() {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
      document.getElementById("navbarAnim").style.top = "0";
    } else {
      document.getElementById("navbarAnim").style.top = "-80px";
    }
    prevScrollpos = currentScrollPos;
  }
</script>
{{-- END SCRIPT --}}



@endsection