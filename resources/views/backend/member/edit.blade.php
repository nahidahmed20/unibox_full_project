<div class="modal fade" id="memberModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="memberForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="member_id">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="modalTitle">
                            <i class="fa-solid fa-user-plus text-primary"></i>
                            <span>Add Member</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row">
                            @php
                                $fields = [
                                    'name' => 'Name',
                                    'code_number' => 'Code Number',
                                    'email' => 'Email',
                                    'phone' => 'Phone',
                                    'address' => 'Address',
                                    'occupation' => 'Occupation',
                                    'nationality' => 'Nationality',
                                    'religion' => 'Religion',
                                    'education' => 'Education',
                                ];
                            @endphp

                            @foreach ($fields as $key => $label)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"> {{ $label }} </label>
                                    <input type="text" id="{{ $key }}" name="{{ $key }}"
                                        class="form-control">
                                </div>
                            @endforeach
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Gender </label>
                                <select id="gender" name="gender" class="form-select">
                                    <option value="Male"> Male </option>
                                    <option value="Female"> Female</option>
                                    <option value="Other"> Other </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Date Of Birth </label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Marital Status </label>
                                <select id="marital_status" name="marital_status" class="form-select">
                                    <option value="Single"> Single </option>
                                    <option value="Married"> Married </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Image </label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Status </label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1"> Active </option>
                                    <option value="0"> Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" id="saveBtn">Save Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>