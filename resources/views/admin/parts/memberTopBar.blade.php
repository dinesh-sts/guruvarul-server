<div class="col-12 mb-3">
    <div class="card inMemberTopPanel inBorderColor1">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.membersAll') }}" class="btn btnPrimary d-block">
                        <i class="fas fa-users pe-1"></i> All Members
                    </a>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                    <a href="" data-bs-toggle="modal" data-bs-target="#filterProfile" class="btn btnPrimary d-block"><i class="fas fa-search pe-1"></i>Search Profile</a>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                    <div class="dropdown">
                        <a class="btn btnPrimary d-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter pe-1"></i>Sort Members
                        </a>
                        <ul class="dropdown-menu inBorderColor1">
                            <li>
                                <a href="{{route('admin.membersAll',['filter' => 'all'])}}" name="filter" value="all" class="dropdown-item">All Members<span class="badge text-bg-secondary ms-1">@if(isset($allMembersCount)) {{ $allMembersCount }}@endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.membersAll',['filter' => 'active'])}}" name="filter" value="active" class="dropdown-item">Approved Members<span class="badge text-bg-secondary ms-1">@if(isset($approvedMembersCount)) {{ $approvedMembersCount }} @endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.membersAll',['filter' => 'paid'])}}" name="filter" value="paid" class="dropdown-item">Paid Members<span class="badge text-bg-secondary ms-1">@if(isset($paidMembersCount)) {{ $paidMembersCount }} @endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.membersAll',['filter' => 'featured'])}}" name="filter" value="featured" class="dropdown-item">Featured Members<span class="badge text-bg-secondary ms-1">@if(isset($featuredMembersCount)) {{ $featuredMembersCount }} @endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.membersAll',['filter' => 'inactive'])}}" name="filter" value="inactive" class="dropdown-item">Unapproved Members<span class="badge text-bg-secondary ms-1">@if(isset($unapprovedMembersCount)) {{ $unapprovedMembersCount }} @endif</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 offset-lg-0 col-md-6 offset-md-0 mb-3">
                    <a href="{{ route('admin.registerFirst') }}" class="btn btnPrimary d-block"><i class="fas fa-user-plus pe-1"></i> Add Member</a>
                </div>
            </div>
        </div>
    </div>
</div>

