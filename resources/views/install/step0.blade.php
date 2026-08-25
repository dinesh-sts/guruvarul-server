@extends('install.layouts.layout')

@section('content') 

<div class="container pt-5">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card shadow border-1">
                <div class="card-body">
                    <div class="text-center pt-3">
                        <h1 class="h4 fw-bold text-dark">Premium Matrimonial Script Installation</h1>
                        <p>Keep below details ready for complete installation in no time.</p>
                    </div>
                    <ol class="list-group">
                        <li class="list-group-item text-semibold"><i class="fas fa-check"></i> Purchase code</li>
                        <li class="list-group-item text-semibold"><i class="fas fa-check"></i> Database Name</li>
                        <li class="list-group-item text-semibold"><i class="fas fa-check"></i> Database Username</li>
                        <li class="list-group-item text-semibold"><i class="fas fa-check"></i> Database Password</li>
                        <li class="list-group-item text-semibold"><i class="fas fa-check"></i> Database Hostname</li>
                    </ol>
                    <p class="mt-3">
                        During the installation process, we will check if the files that are needed to be written
                        (<strong>.env file</strong>) have
                        <strong>write permission</strong>. We will also check if <strong>curl</strong> are enabled on your server or not.
                    </p>
                    <br>
                    <div class="text-center pb-3">
                        <a href="{{ route('step1') }}" class="btn btn-primary">
                            Start Installation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
