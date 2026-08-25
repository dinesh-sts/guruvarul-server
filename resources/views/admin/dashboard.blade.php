@extends('admin.layouts.afterLoginLayout')

<!-- Page Title -->
@section('title') Admin Panel - Dashboard @endsection

<!-- Page Css -->
@section('pageCSS') @endsection

<!-- Main Content -->
@section('content')
<div class="container pt-3">
    
    <!-- Member Details Section -->
    <div class="row inADashboardDetail pt-2 pb-3">
        <h3 class="colorSecondary font-public">Members Details</h3>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover inBgPastlePink">
                <div class="card-body pt-4 pb-4">
                    <div class="media align-items-center static-top-widget">
                        <div class="media-body">
                            <h1 class="colorPrimary">@if(isset($allMembersCount)) {{ $allMembersCount }} @endif</h1>
                            <h5 class="colorSecondary">All Members</h5>
                        </div>
                        <div class="align-self-center text-center">
                            <i class="fas fa-users fa-fw"></i>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover inBgPastlePink">
                <div class="card-body pt-4 pb-4">
                    <div class="media align-items-center static-top-widget">
                        <div class="media-body">
                            <h1 class="colorPrimary">@if(isset($approvedMembersCount)) {{ $approvedMembersCount }} @endif</h1>
                            <h5 class="colorSecondary">Approved Members</h5>
                        </div>
                        <div class="align-self-center text-center">
                            <i class="fas fa-user-check fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover inBgPastlePink">
                <div class="card-body pt-4 pb-4">
                    <div class="media align-items-center static-top-widget">
                        <div class="media-body">
                            <h1 class="colorPrimary">@if(isset($paidMembersCount)) {{ $paidMembersCount }} @endif</h1>
                            <h5 class="colorSecondary">Paid Members</h5>
                        </div>
                        <div class="align-self-center text-center">
                            <i class="fas fa-user-tag fa-fw"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover inBgPastlePink">
                <div class="card-body pt-4 pb-4">
                    <div class="media align-items-center static-top-widget">
                        <div class="media-body">
                            <h1 class="colorPrimary">@if(isset($featuredMembersCount)){{ $featuredMembersCount }}@endif</h1>
                            <h5 class="colorSecondary">Featured Members</h5>
                        </div>
                        <div class="align-self-center text-center">
                            <i class="fas fa-users-viewfinder fa-fw"></i>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <!-- /. Member Details Section -->

    <!-- Earning Details Section -->
    <div class="row inADashboardDetail">
        <h3 class="colorSecondary font-public">Earning</h3>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover">
                <div class="card-body pt-4 pb-4">
                    <h1 class="colorPrimary">@if(isset($totalEarning)) {{ $totalEarning }} @endif</h1>
                    <h5>Total</h5>
                    <h4>Earning</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover">
                <div class="card-body pt-4 pb-4">
                    <h1 class="colorPrimary">@if(isset($lastMonthEarning)) {{ $lastMonthEarning }} @endif</h1>
                    <h5>Last Month Earning</h5>
                    <h4>Earning</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover">
                <div class="card-body pt-4 pb-4">
                    <h1 class="colorPrimary">@if(isset($lastSixMonthsEarning)) {{ $lastSixMonthsEarning }} @endif</h1>
                    <h5>Last 6 Months</h5>
                    <h4>Earning</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 card-hover">
                <div class="card-body pt-4 pb-4">
                    <h1 class="colorPrimary">@if(isset($lastYearEarning)) {{ $lastYearEarning }} @endif</h1>
                    <h5>Last 12 Months</h5>
                    <h4>Earning</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- /. Earning Details Section -->

    <!-- Earning Overview Chart Section -->
    <div class="row mt-3 pb-4">
        <div class="col-12">
            <div class="card card-hover inADashboardChart border-0">
                <div class="card-header inBorderColor1">
                    <h5 class="colorSecondary font-public">Earning Overview</h5>
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" class="height-320"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Earning Overview Chart Section -->

    <!-- Recently joined profiles -->
    <div class="row inADashboardRecent">
        <h3 class="colorSecondary font-public pb-3 pt-3">Recently Joined Members</h3>

        @foreach ($recentlyJoinedProfiles as $profile)
        <div class="col-6 col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.view-profile',$profile->matri_id) }}" class="card card-hover inBorderColor1 text-decoration-none">
                @if(isset($profile))
                    <!--- Profile Photo -->
                    @include('admin.parts.profilePhoto')
                    <!--- /. Profile Photo -->
                    <div class="card-body text-center">
                        <h5 class="card-title font-public">
                            @if(isset($profile->firstname)) {{ $profile->firstname }} @endif 
                            @if(isset($profile->lastname)){{ $profile->lastname }} @endif
                        </h5>
                        <h6>
                            User Id : <span class="colorPrimary">@if(isset($profile->matri_id)){{  $profile->matri_id }} @endif</span>
                        </h6>
                        <p class="card-text pt-2">
                            @if(isset($profile->m_status)){{ $profile->m_status }},@endif 
                            @if(isset($profile->gender)){{ $profile->gender }},@endif
                        </p>
                        <p class="card-text pb-2">
                            @if(isset($profile->religion)){{ $profile->rel->religion_name }},@endif
                            @if(isset($profile->caste)){{ $profile->cast->caste_name }} @endif
                        </p>
                        <div class="btn btnPrimary d-block">
                            {{\Carbon\Carbon::parse($profile->created_at)->format('D, d M Y');}}
                        </div>
                    </div>
                @endif
            </a>
        </div>
        @endforeach
    </div>
    <!-- /. Recently joined profiles -->
     
</div>
@endsection

<!-- Page Js -->
@section('pageJS') 

<!-- Chart Js-->
<script src="{{ asset('admin/js/chart.js/Chart.js') }}"></script>
<script src="{{ asset('admin/js/chart-area.js') }}"></script>

<script>
    var ctx = document.getElementById("myAreaChart");
    var earningsData = {!! json_encode($filteredEarnings) !!};
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            //labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            labels: [@php 
                for ($i = 0; $i < 12; $i++) {
                    echo $months[] = date( $i === 11 ? '"M Y"' : '"M Y",' , strtotime( date( 'Y-m-01' )." -$i months"));  
                }
            @endphp],
            datasets: [{
                label: "Earnings",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "#233350",
                pointRadius: 2,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: earningsData,
                // data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return 'Rs.' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Rs.' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
</script>
@endsection   
