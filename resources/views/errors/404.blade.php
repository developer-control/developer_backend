@extends('layouts.app')

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
                            <img src="{{ url('/') }}/assets/images/404.svg" class="img-fluid mb-2" alt="404" />
                            <h2>Page Not Found :(</h2>
                            <p>Oops! 😖 The page you requested was not found on the server.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Go To Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
@endsection
