<div class="modal fade inAdminSearchModal" id="filterProfile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Filter Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h4 class="inSearchTitle">Search By Id</h4>
                    <form action="{{ route('admin.matchMaking') }}" method="get">
                        <div class="row mb-3">
                            <div class="col-lg-8 mb-3">
                                <input type="text" name="keyword" class="form-control" placeholder="Search by keyword">
                            </div>
                            <div class="col-lg-4">
                                <button type="submit" class="btn btnPrimary pt-2 pb-2">SEARCH</button>
                            </div>
                        </div>
                    </form>
                </div>	
                <div class="row">
                    <h4 class="inSearchTitle">Quick Search</h4>
                    <form action="{{ route('admin.matchMaking') }}" method="get">
                        <div class="mb-4 row">
                            <label class="col-lg-3 col-form-label">Gender</label>
                            <div class="col-lg-9 pt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value="Male" type="radio" name="gender" id="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value="Female" type="radio" name="gender" id="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputPassword" class="col-lg-3 col-form-label">Age</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-5">
                                        <select name="age_to" class="form-select"  id="ageToSelect">
                                            <option value="" selected>select</option>
                                            @foreach ($ages as $age)
                                            <option value="{{$age->age}}">{{$age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 text-center">
                                        <h6 class="mt-2">To</h6>
                                    </div>
                                    <div class="col-5">
                                        <select name="age_from" class="form-select"  id="ageFromSelect" disabled>
                                            <option value="" selected>select</option>
                                            @foreach ($ages as $age)
                                            <option value="{{$age->age}}">{{$age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputPassword" class="col-lg-3 col-form-label">Religion</label>
                            <div class="col-lg-9">
                                <select name="religion" class="form-select chosen-select" id="religion-dropdown" data-placeholder="Choose">
                                    <option value="">select</option>
                                    @foreach($religions as $religion)
                                    <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputPassword" class="col-lg-3 col-form-label">Caste</label>
                            <div class="col-lg-9">
                                <select name="caste" class="form-select chosen-select" id="caste-dropdown" data-placeholder="Choose">
                                    <option value="">Select religion first</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btnPrimary pt-2 pb-2">SEARCH</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>