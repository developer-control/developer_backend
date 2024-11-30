  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
      navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
              @yield('breadcrumb')

              <h6 class="font-weight-bolder mb-0">@yield('page-title')</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                  {{-- <div class="input-group">
                      <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" placeholder="Type here...">
                  </div> --}}
              </div>
              <ul class="navbar-nav justify-content-end">
                  {{-- <li class="nav-item d-flex align-items-center">
                      <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank"
                          href="https://www.creative-tim.com/builder?ref=navbar-soft-ui-dashboard">Online Builder</a>
                  </li> --}}
                  <li class="nav-item dropdown px-2 me-1 d-flex align-items-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-bell cursor-pointer"></i>
                      </a>
                      <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                          aria-labelledby="dropdownMenuButton">
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex py-1">
                                      <div class="my-auto">
                                          <img src="" class="avatar avatar-sm  me-3 ">
                                      </div>
                                      <div class="d-flex flex-column justify-content-center">
                                          <h6 class="text-sm font-weight-normal mb-1">
                                              <span class="font-weight-bold">New message</span> from Laur
                                          </h6>
                                          <p class="text-xs text-secondary mb-0 ">
                                              <i class="fa fa-clock me-1"></i>
                                              13 minutes ago
                                          </p>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex py-1">
                                      <div class="my-auto">
                                          <img src="" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                      </div>
                                      <div class="d-flex flex-column justify-content-center">
                                          <h6 class="text-sm font-weight-normal mb-1">
                                              <span class="font-weight-bold">New album</span> by Travis Scott
                                          </h6>
                                          <p class="text-xs text-secondary mb-0 ">
                                              <i class="fa fa-clock me-1"></i>
                                              1 day
                                          </p>
                                      </div>
                                  </div>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <li class="nav-item d-flex align-items-center">
                      <a href="{{ route('logout') }}" class="nav-link text-body font-weight-bold px-0"
                          onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">

                          <span class="d-sm-inline d-none">Sign Out</span>
                          <i class="fas fa-sign-out-alt me-sm-1"></i>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>

                  </li>
                  <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                          <div class="sidenav-toggler-inner">
                              <i class="sidenav-toggler-line"></i>
                              <i class="sidenav-toggler-line"></i>
                              <i class="sidenav-toggler-line"></i>
                          </div>
                      </a>
                  </li>
                  {{-- <li class="nav-item px-3 d-flex align-items-center">
                      <a class="nav-link text-body p-0">
                          <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                      </a>
                  </li> --}}

              </ul>
          </div>
      </div>
  </nav>
  <!-- End Navbar -->
