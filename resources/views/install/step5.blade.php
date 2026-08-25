@extends('install.layouts.layout')

@section('content') 
@if (Session::has('message'))
<div class="alert alert-success mt-3">
    {{ Session::get('message') }}
</div>  
@endif
<div class="container pt-5">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card shadow border-1">
                <div class="card-body">
                    <div class="text-center pt-3">
                        <h1 class="h4 fw-bold text-dark">Premium Matrimonial Script Settings</h1>
                        <p>Fill this form with basic information & admin login credentials</p>
                    </div>
                    <p class="text-muted font-13">
                        <form method="POST" action="{{ route('system_settings') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Admin Username</label>
                                <input type="text" class="form-control @error('admin_username') is-invalid @enderror" id="admin_username" name="admin_username" value="{{ old('admin_username') }}">
                                @error('admin_username')
                                    <p class="invalid-feedback d-block">{{ $message }}</p>     
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="admin_email" class="form-label">Admin Email</label>
                                <input type="email" class="form-control @error('admin_email') is-invalid @enderror" id="admin_email" name="admin_email" value="{{ old('admin_email') }}"">
                                @error('admin_email')
                                    <p class="invalid-feedback d-block">{{ $message }}</p>     
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="admin_password" class="form-label">Admin Password (At least 8 characters)</label>
                                <input type="password" class="form-control @error('admin_password') is-invalid @enderror" id="admin_password" name="admin_password" >
                                @error('admin_password')
                                    <p class="invalid-feedback d-block">{{ $message }}</p>     
                                @enderror
                            </div>
                            <div class="text-center">
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
