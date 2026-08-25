@php
    $advLevel2 = DB::table('advertisements')->where([['adv_level','level-2'],['status','APPROVED']])->inRandomOrder()->first();   
@endphp
@if(isset($advLevel2))
<div class="container pt-3 pb-3 inAdvertisementBucket">
    <div class="row">
        <a href="{{ $advLevel2->adv_link }}" class="col-12" target="_blank">
            <span>Advertisement</span>
            <img src="{{ asset('storage/advImage/'.$advLevel2->adv_img) }}" class="img-fluid w-100">
            
        </a>
    </div>
</div>
@endif
