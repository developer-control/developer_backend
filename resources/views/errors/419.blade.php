@extends('layouts.app')

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
                            <h2>Oops! This Page expired</h2>
                            <p>Sorry, your session has expired or your authentication token is no longer valid. Please
                                refresh the page and
                                try again. If the problem persists, please contact our support team for assistance. Thank
                                you for using our
                                service.</p>
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
