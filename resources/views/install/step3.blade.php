@extends('install.layouts.layout')

@section('content') 

<div class="container pt-5">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card shadow border-1">
                <div class="card-body">
                    <div class="text-center pt-3">
                        <h1 class="h4 fw-bold text-dark">Database setup</h1>
                        <p>Fill this form with valid database credentials</p>
                    </div>

                    @if(isset($error))
                    <div class="row mt-3">
                        <div class="col-md-12">
                          <div class="alert alert-danger">
                            <strong>Invalid Database Credentials!! </strong>Please enter correct database details.
                          </div>
                        </div>
                      </div>
                    @endif

                    <p class="text-muted font-13">
                        <form method="POST" action="{{ route('install.db') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="db_host" class="form-label">Database Host</label>
                                <input type="text" class="form-control" id="db_host" name = "DB_HOST" autocomplete="off" required>
                                <input type="hidden" name = "types[]" value="DB_HOST">
                            </div>
                            <div class="mb-3">
                                <label for="db_name" class="form-label">Database Name</label>
                                <input type="text" class="form-control" id="db_name" name = "DB_DATABASE" autocomplete="off" required>
                                <input type="hidden" name = "types[]" value="DB_DATABASE" >
                            </div>
                            <div class="mb-3">
                                <label for="db_user" class="form-label">Database Username</label>
                                <input type="text" class="form-control" id="db_user" name = "DB_USERNAME" autocomplete="off" required>
                                <input type="hidden" name = "types[]" value="DB_USERNAME">
                            </div>
                            <div class="mb-3">
                                <label for="db_pass" class="form-label">Database Password</label>
                                <input type="password" class="form-control" id="db_pass" name = "DB_PASSWORD" autocomplete="off" >
                                <input type="hidden" name = "types[]" value="DB_PASSWORD">
                            </div>
                           
                            <div class="text-center ">
                                <button type="submit" class="btn btn-primary">Continue</button>
                            </div>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
