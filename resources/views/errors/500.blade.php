@extends('layouts.app')

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
                            <h2>Woops! Something went wrong :(</h2>
                            <p>We will work on fixing that right away.</p>
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
