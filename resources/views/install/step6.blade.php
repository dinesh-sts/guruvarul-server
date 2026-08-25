@extends('install.layouts.layout')

@section('content') 

<div class="container pt-5">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card shadow border-1">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="h4 fw-bold text-dark">Congratulations!!!</h1>
                        <p>You have successfully completed the installation process. Please Login to continue.</p>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 card-title">Configure the following setting to run the system properly.</h6>
                        </div>
                        <div class="card-body">
                            <ul class="">
                                <li class="">SMTP Setting</li>
                                <li class="">Payment Method Configuration</li>
                                <li class="">SMS Api Setting</li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-center mt-3 pb-3">
                        <a href="{{ env('APP_URL') }}" class="btn btn-primary btn-sm ps-3 pe-3">Go to Frontend Website</a>
                        <a href="{{ env('APP_URL') }}/secureadmin" class="btn btn-success btn-sm ps-3 pe-3">Login to Admin panel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
