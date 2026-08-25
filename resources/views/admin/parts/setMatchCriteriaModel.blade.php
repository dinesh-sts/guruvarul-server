<div class="modal fade inAdminSearchModal" id="setMatchCriteria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Set Match Criteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">	
                <div class="row">
                    <form action="{{ route('admin.setMatchCriteria') }}" method="POST">
                        @csrf
                        <div class="mb-4 row">
                            <label for="inputPassword" class="col-lg-12 col-form-label">Set Criteria</label>
                            <div class="col-lg-12">
                                <select name="matchCriteria[]" class="form-select chosen-select" id="religion-dropdown" data-placeholder="Choose" multiple>
                                    <option value="m_status" @if(in_array('m_status',$matchParameters)) selected @endif>Marital Status</option>
                                    <option value="country" @if(in_array('country',$matchParameters)) selected @endif>Country</option>
                                    <option value="religion" @if(in_array('religion',$matchParameters)) selected @endif>Religion</option>
                                    <option value="caste" @if(in_array('caste',$matchParameters)) selected @endif>Caste</option>
                                    <option value="age" @if(in_array('age',$matchParameters)) selected @endif>Age</option>
                                    <option value="height" @if(in_array('height',$matchParameters)) selected @endif>Height</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btnPrimary pt-2 pb-2">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>