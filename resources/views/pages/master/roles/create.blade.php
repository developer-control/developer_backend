@extends('layouts.main', ['menu' => 'access_user', 'submenu' => 'master_role'])
@section('style')
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('create_role') }}
@endsection
@section('page-title')
    Create Master Role
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-9">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Create Role Access</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="" method="POST">
                            @csrf
                            <div class="row p-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role_name">Role Name</label>
                                        <div class="input-group mb-4">
                                            @if (@$developer)
                                                <span class="input-group-text">{{ @$developer->name ?? 'test' }}</span>
                                            @endif
                                            <input class="form-control  @error('transaction_date') has-danger @enderror"
                                                placeholder="Role Name..." type="text" id="role_name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role_name">Role Name</label>
                                        <div class="input-group input-group-alternative mb-4">
                                            @if (@$developer)
                                                <span class="input-group-text">{{ $developer->name }}</span>
                                            @endif
                                            <input class="form-control form-control-alternative" placeholder="Role Name..."
                                                type="text" id="role_name" name="name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('scripts')
    <script>
        $(document).on("keydown", "form", function(event) {
            // return event.key != "Enter";
            if (event.key === "Enter" && event.target.tagName !== "TEXTAREA") {
                event.preventDefault(); // Mencegah submit form
            }
        });
    </script>
@endsection
