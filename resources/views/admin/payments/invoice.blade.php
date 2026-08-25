<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Invoice @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main content -->
<div class="container pt-3 inInvoice">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-5">
            <div class="card mb-4 inBorderColor1" id="printableArea">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col">
                            @if(isset($siteConfig->web_logo_path))
                            <img src="{{asset('storage/siteConfig/'.$siteConfig->web_logo_path)}}" class="img-fluid maxH-60">
                            @endif
                        </div>
                        <div class="col inInvoiceText">
                            <h3 class="text-end">INVOICE</h3>
                            <h5 class="text-end mt-1"><span class="pe-2 colorPrimary">Date</span> @if(isset($payment->pactive_dt)){{$payment->pactive_dt}}@endif</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-4 inInvoiceCustDet mb-4">
                            <h4>From,</h4>
                            <h5> @if(isset($siteConfig->web_name)){{$siteConfig->web_name}}@endif</h5>
                            <h5><span>Contact No:</span> @if(isset($siteConfig->contact_no)){{$siteConfig->contact_no}}@endif</h5>
                            <h5><span>Email id:</span> @if(isset($siteConfig->contact_email)){{$siteConfig->contact_email}}@endif</h5>
                        </div>
                        <div class="col-4 inInvoiceCustDet mb-4">
                            <h4>To,</h4>
                            <h5> @if(isset($payment->pname)){{$payment->pname}}@endif</h5>
                            <h5>
                                <span>Contact No:</span> 
                                @if(env('DEMO_MODE') == 'On')
                                    <span>Disabled In Demo</span>
                                @else
                                    @if(isset($payment->pcontact)){{ $payment->pcontact }}@endif
                                @endif  
                            </h5>
                            <h5>
                                <span>Email id:</span> 
                                @if(env('DEMO_MODE') == 'On')
                                    <span>Disabled In Demo</span>
                                @else
                                    @if(isset($payment->pemail)){{ $payment->pemail }} @endif
                                @endif
                            </h5>
                        </div>
                        <div class="col-4 inInvoiceCustDet mb-4">
                            <h4>INVOICE NO: INV @if(isset($payment->id)){{$payment->id}}@endif</h4>
                            <h5><span>Customer Id:</span>  @if(isset($payment->pmatri_id)){{$payment->pmatri_id}}@endif</h5>
                            <h5><span>Payment Mode:</span>  @if(isset($payment->paymode)){{$payment->paymode}}@endif</h5>
                            <h5><span>Active On:</span>  @if(isset($payment->pactive_dt)){{$payment->pactive_dt}}@endif</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>@if(isset($payment->id)){{$payment->id}}@endif</td>
                                        <td>@if(isset($payment->p_plan)){{$payment->p_plan}}@endif for @if(isset($payment->plan_duration)){{$payment->plan_duration}} Days @endif</td>
                                        <td>@if(isset($payment->plan_currency)){{$payment->plan_currency}}@endif  @if(isset($payment->p_amount)){{$payment->p_amount}}@endif</td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3 offset-9 inInvoiceCustTot">
                            <h4>Total</h4>
                            <h5>@if(isset($payment->plan_currency)){{$payment->plan_currency}}@endif @if(isset($payment->p_amount)){{$payment->p_amount}}/-@endif</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xl-12 text-center">
                    <button class="btn btnPrimary" onclick="printDiv('printableArea')">
                        <i class="fa-solid fa-print pe-2"></i>Print Invoice
                    </button>
                </div>
            </div>
         </div>
    </div>
</div>
<!-- /. Main content -->
@endsection

<!-- Additional page js add here -->
@section('pageJS')
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endsection