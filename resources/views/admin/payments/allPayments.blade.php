<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - All Payments @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main content -->
<div class="container pt-3">

    <h3 class="colorSecondary inATitle1">Payments</h3>

    <div class="row">
        <div class="col-12">
            <div class="card inBorderColor1">
                <div class="card-body inAddDetailTable table-responsive">
                <table id="all_religion" class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Member Id</th>
                            <th>Plan Name</th>
                            <th>Amount</th>   
                            <th>Payment Method</th>    
                            <th>Plan Purchase Date</th>   
                            <th>Invoice</th>   
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td>@if(isset($payment->id)){{$payment->id}}@endif</td>
                                <td class="font-13">@if(isset($payment->pname)){{$payment->pname}}@endif</td>
                                <td class="font-13">@if(isset($payment->pmatri_id)){{$payment->pmatri_id}}@endif</td>
                                <td class="font-13">@if(isset($payment->p_plan)){{$payment->p_plan}}@endif</td>
                                <td class="font-13">@if(isset($payment->plan_currency)){{$payment->plan_currency}}@endif @if(isset($payment->p_amount)){{$payment->p_amount}}@endif/-</td>
                                <td class="font-13">@if(isset($payment->paymode)){{$payment->paymode}}@endif</td>
                                <td class="font-13">@if(isset($payment->pactive_dt)){{$payment->pactive_dt}}@endif</td>
                                <td>
                                    <a href="{{ route('admin.paymentInvoice',$payment->id) }}" class="inAInvoiceBtn"><i class="fas fa-file-text"></i></a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Additional page js add here -->
@section('pageJS')
<script>
    $(document).ready(function () {
        $('#all_religion').DataTable();
    });
</script>
@endsection