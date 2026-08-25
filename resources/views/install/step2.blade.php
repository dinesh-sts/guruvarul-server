@extends('install.layouts.layout')

@section('content') 

<div class="container pt-5">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card shadow border-1">
                <div class="card-body">
                    <div class="text-center pt-3">
                        <h1 class="h4 fw-bold text-dark">Purchase Code</h1>
                        <p>
                            Enter your purchase code.<br>
                            <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where to get purchase code?</a>
                        </p>
                    </div>
                    <p class="text-muted font-13">
                        <form method="POST" action="{{ route('purchase.code') }}">
                            @csrf
                            <div class="form-group">
                                <label for="purchase_code" class="form-label">Purchase Code</label>
                                <input type="text" class="form-control" id="purchase_code" name="purchase_code" placeholder="**** **** **** ****" >
                            </div>
                            <div class="text-center pb-3 mt-3">
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
