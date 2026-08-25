@extends('user.layouts.beforeLoginLayout') 


@section('pageCSS') @endsection

@section('content')

<!-- CMS Card -->
<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-1 pb-4 lh-lg">
                        <section class="inPageHeader">
                            <h2 class="text-center">@if(isset($page->cms_title)){{$page->cms_title}}@endif</h2>
                        </section>
                        <p>@if(isset($page->cms_content)){!!$page->cms_content!!}@endif
                        </p> 
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<!-- /.CMS Card -->
@section('pageJS') @endsection

@endsection


