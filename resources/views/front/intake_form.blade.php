@extends('front.layouts.master')

@section('title', 'Intake Form')
@section('css')
@endsection
<style>
    .is-invalid {
        border-color: #dc3545;
    }

    .text-danger {
        font-size: 0.9rem;
    }
</style>
@section('content')
    <div class="intake-form-page section-spacing-top-bottom">
        <div class="container ">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="intake-card">
                <div class="card-header">
                    <h2 class="mb-0">Agency Intake Form</h2>
                </div>
                <div class="card-body">
                    <form id="intakeForm" action="{{ route('intake.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- ========== Basic Agency Info ========== -->
                        <div class="form-section">
                            <h3 class="section-title">Basic Agency Information</h3>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="agency_name" class="form-label">Agency Name (legal name)</label>
                                    <input type="text" name="agency_name" class="form-control" id="agency_name"
                                        value="{{ old('agency_name') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="dba" class="form-label">Doing Business As (DBA)</label>
                                    <input type="text" name="dba" class="form-control" id="dba"
                                        value="{{ old('dba') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="address"
                                        value="{{ old('address') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        value="{{ old('phone') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="alternate_email" class="form-label">Alternate Email</label>
                                    <input type="email" name="alternate_email" class="form-control" id="alternate_email"
                                        value="{{ old('alternate_email') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="fax" class="form-label">Fax</label>
                                    <input type="text" name="fax" class="form-control" id="fax"
                                        value="{{ old('fax') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="npi" class="form-label">NPI#</label>
                                    <input type="text" name="npi" class="form-control" id="npi"
                                        value="{{ old('npi') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="ein" class="form-label">EIN (TAX) ID#</label>
                                    <input type="text" name="ein" class="form-control" id="ein"
                                        value="{{ old('ein') }}">
                                </div>
                            </div>
                        </div>

                        <!-- ========== Owner 1 Info ========== -->
                        <div class="form-section">
                            <h3 class="section-title">Owner 1/ Administrator information</h3>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_name" class="form-label">Name</label>
                                    <input type="text" name="owner1_name" class="form-control" id="owner1_name"
                                        value="{{ old('owner1_name') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_percent" class="form-label">Ownership %</label>
                                    <input type="number" step="0.01" name="owner1_percent" class="form-control"
                                        id="owner1_percent" value="{{ old('owner1_percent') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="owner1_dob" class="form-control" id="owner1_dob"
                                        value="{{ old('owner1_dob') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_ssn" class="form-label">Social Security #</label>
                                    <input type="text" name="owner1_ssn" class="form-control" id="owner1_ssn"
                                        value="{{ old('owner1_ssn') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_txdl_exp" class="form-label">Texas Driver License
                                        Expiration</label>
                                    <input type="date" name="owner1_txdl_exp" class="form-control"
                                        id="owner1_txdl_exp" value="{{ old('owner1_txdl_exp') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_prof_license_exp" class="form-label">Professional License
                                        Expiration</label>
                                    <input type="date" name="owner1_prof_license_exp" class="form-control"
                                        id="owner1_prof_license_exp" value="{{ old('owner1_prof_license_exp') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_lic_1" class="form-label"> TX Driver's License #</label>
                                    <input type="text" name="owner1_lic_1" class="form-control" id="owner1_lic_1"
                                        value="{{ old('owner1_lic_1') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_lic_2" class="form-label">Professional License #</label>
                                    <input type="text" name="owner1_lic_2" class="form-control" id="owner1_lic_2"
                                        value="{{ old('owner1_lic_2') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner1_aliases" class="form-label">Aliases (any other names used)</label>
                                    <input type="text" class="form-control" name="owner1_aliases" id="owner1_aliases"
                                        value="{{ old('owner1_aliases') }}">
                                    <label for="owner1_relationships" class="form-label mt-3">
                                        Relationships / ownership or management role with other agencies?
                                    </label>
                                    <input type="text" class="form-control" name="owner1_relationships"
                                        id="owner1_relationships" value="{{ old('owner1_relationships') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="admin_resume" id="admin_resume"
                                            class="form-check-input" value="1"
                                            {{ old('admin_resume') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="admin_resume">Resume Available?</label>
                                    </div>
                                    <div id="admin_resume_file" style="display: none;" class="mb-3">
                                        <input type="file" name="admin_resume_file" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </div>

                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="admin_presurvey_modules"
                                            id="admin_presurvey_modules" class="form-check-input" value="1"
                                            {{ old('admin_presurvey_modules') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="admin_presurvey_modules">Presurvey CBT
                                            modules
                                            done/attached</label>
                                    </div>
                                    <div id="admin_presurvey_file" style="display: none;" class="mb-3">
                                        <input type="file" name="admin_presurvey_file" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </div>
                                    <div class="form-check">

                                        <input type="checkbox" class="form-check-input citizen-checkbox"
                                            id="owner1_citizen" name="owner1_citizen" value="1"
                                            data-target="#greencard_info_wrapper_1"
                                            {{ old('owner1_citizen') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="owner1_citizen">Citizen?</label>
                                    </div>
                                    <div class="form-group mt-2" id="greencard_info_wrapper_1"
                                        style="display: {{ old('owner1_citizen') ? 'none' : 'block' }};">
                                        <label class="form-label" for="owner1_greencard">If no, include Green Card
                                            Identification #</label>
                                        <input type="text" class="form-control" name="owner1_greencard"
                                            id="owner1_greencard" value="{{ old('owner1_greencard') }}">
                                    </div>

                                </div>


                            </div>
                        </div>

                        <!-- ========== Alternate Admin Details ========== -->
                        <div class="form-section ">
                            <h3 class="section-title">Alternate Administrator Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_name" class="form-label">Alt Admin Name</label>
                                    <input type="text" class="form-control" name="alt_admin_name" id="alt_admin_name"
                                        value="{{ old('alt_admin_name') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_aliases" class="form-label">Alt Admin Aliases</label>
                                    <input type="text" class="form-control" name="alt_admin_aliases"
                                        id="alt_admin_aliases" value="{{ old('alt_admin_aliases') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_dob" class="form-label">Alt Admin DOB</label>
                                    <input type="date" class="form-control" name="alt_admin_dob" id="alt_admin_dob"
                                        value="{{ old('alt_admin_dob') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_ssn" class="form-label">Alt Admin SS#</label>
                                    <input type="text" class="form-control" name="alt_admin_ssn" id="alt_admin_ssn"
                                        value="{{ old('alt_admin_ssn') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_txdl_exp" class="form-label">TXDL Expiry</label>
                                    <input type="date" class="form-control" name="alt_admin_txdl_exp"
                                        id="alt_admin_txdl_exp" value="{{ old('alt_admin_txdl_exp') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_prof_license_exp" class="form-label">Professional License
                                        Expiry</label>
                                    <input type="date" class="form-control" name="alt_admin_prof_license_exp"
                                        id="alt_admin_prof_license_exp" value="{{ old('alt_admin_prof_license_exp') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_lic_1" class="form-label"> TX Driver's License #</label>
                                    <input type="text" class="form-control" name="alt_admin_lic_1"
                                        id="alt_admin_lic_1" value="{{ old('alt_admin_lic_1') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_admin_lic_2" class="form-label">Professional License #</label>
                                    <input type="text" class="form-control" name="alt_admin_lic_2"
                                        id="alt_admin_lic_2" value="{{ old('alt_admin_lic_2') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input citizen-checkbox"
                                            id="alt_admin_citizen" name="alt_admin_citizen" value="1"
                                            data-target="#greencard_info_wrapper_4"
                                            {{ old('alt_admin_citizen') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alt_admin_citizen">Citizen?</label>
                                    </div>
                                    <div class="form-group mt-2" id="greencard_info_wrapper_4"
                                        style="display: {{ old('alt_admin_citizen') ? 'none' : 'block' }};">
                                        <label class="form-label" for="alt_admin_greencard">If no, include Green Card
                                            Identification #</label>
                                        <input type="text" class="form-control" name="alt_admin_greencard"
                                            id="alt_admin_greencard" value="{{ old('alt_admin_greencard') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="alt_admin_resume" id="alt_admin_resume"
                                            class="form-check-input" value="1"
                                            {{ old('alt_admin_resume') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alt_admin_resume">Resume Available?</label>
                                    </div>
                                    <div id="alt_admin_resume_file" style="display: none;" class="mb-3">
                                        <input type="file" name="alt_admin_resume_file" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </div>

                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="alt_admin_presurvey_modules"
                                            id="alt_admin_presurvey_modules" class="form-check-input" value="1"
                                            {{ old('alt_admin_presurvey_modules') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alt_admin_presurvey_modules">Presurvey CBT
                                            modules done/attached</label>
                                    </div>
                                    <div id="alt_admin_presurvey_file" style="display: none;" class="mb-3">
                                        <input type="file" name="alt_admin_presurvey_file" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="alt_admin_relationships" class="form-label">Relationships / ownership or
                                        management role with other agencies?</label>
                                    <input type="text" class="form-control" name="alt_admin_relationships"
                                        id="alt_admin_relationships" value="{{ old('alt_admin_relationships') }}">
                                    <div class="form-check mb-3 mt-2">
                                        <input type="checkbox" class="form-check-input" id="copy_owner2_to_alt_admin">
                                        <label class="form-check-label" for="copy_owner2_to_alt_admin">Alternate
                                            Administrator
                                            is an owner too</label>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- ========== Owner 2 Info ========== -->
                        <div class="form-section ">
                            <h3 class="section-title">Owner 2 (If Applicable)</h3>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_name" class="form-label">Name</label>
                                    <input type="text" name="owner2_name" class="form-control" id="owner2_name"
                                        value="{{ old('owner2_name') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_percent" class="form-label">Ownership %</label>
                                    <input type="number" step="0.01" name="owner2_percent" class="form-control"
                                        id="owner2_percent" value="{{ old('owner2_percent') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="owner2_dob" class="form-control" id="owner2_dob"
                                        value="{{ old('owner2_dob') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_ssn" class="form-label">Social Security #</label>
                                    <input type="text" name="owner2_ssn" class="form-control" id="owner2_ssn"
                                        value="{{ old('owner2_ssn') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_txdl_exp" class="form-label">Texas Driver License
                                        Expiration</label>
                                    <input type="date" name="owner2_txdl_exp" class="form-control"
                                        id="owner2_txdl_exp" value="{{ old('owner2_txdl_exp') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_prof_license_exp" class="form-label">Professional License
                                        Expiration</label>
                                    <input type="date" name="owner2_prof_license_exp" class="form-control"
                                        id="owner2_prof_license_exp" value="{{ old('owner2_prof_license_exp') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_lic_1" class="form-label"> TX Driver's License #</label>
                                    <input type="text" name="owner2_lic_1" class="form-control" id="owner2_lic_1"
                                        value="{{ old('owner2_lic_1') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_lic_2" class="form-label">Professional License #</label>
                                    <input type="text" name="owner2_lic_2" class="form-control" id="owner2_lic_2"
                                        value="{{ old('owner2_lic_2') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner2_aliases" class="form-label">Aliases (any other names used)</label>
                                    <input type="text" class="form-control" name="owner2_aliases" id="owner2_aliases"
                                        value="{{ old('owner2_aliases') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="owner2_relationships"
                                            value="1" {{ old('owner2_relationships') ? 'checked' : '' }}>
                                        <label class="form-check-label">Relationships with other agencies?</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input citizen-checkbox"
                                            id="owner2_citizen" name="owner2_citizen" value="1"
                                            data-target="#greencard_info_wrapper_2"
                                            {{ old('owner2_citizen') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="owner2_citizen">Citizen?</label>
                                    </div>

                                    <div class="form-group mt-2" id="greencard_info_wrapper_2"
                                        style="display: {{ old('owner2_citizen') ? 'none' : 'block' }};">
                                        <label class="form-label" for="owner2_greencard">If no, include Green Card
                                            Identification #</label>
                                        <input type="text" class="form-control" name="owner2_greencard"
                                            id="owner2_greencard" value="{{ old('owner2_greencard') }}">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ========== Owner 3 Info ========== -->
                        <div class="form-section ">
                            <h3 class="section-title">Owner 3 (If Applicable)</h3>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_name" class="form-label">Name</label>
                                    <input type="text" name="owner3_name" class="form-control" id="owner3_name"
                                        value="{{ old('owner3_name') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_percent" class="form-label">Ownership %</label>
                                    <input type="number" step="0.01" name="owner3_percent" class="form-control"
                                        id="owner3_percent" value="{{ old('owner3_percent') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="owner3_dob" class="form-control" id="owner3_dob"
                                        value="{{ old('owner3_dob') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_ssn" class="form-label">Social Security #</label>
                                    <input type="text" name="owner3_ssn" class="form-control" id="owner3_ssn"
                                        value="{{ old('owner3_ssn') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_txdl_exp" class="form-label">Texas Driver License
                                        Expiration</label>
                                    <input type="date" name="owner3_txdl_exp" class="form-control"
                                        id="owner3_txdl_exp" value="{{ old('owner3_txdl_exp') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_prof_license_exp" class="form-label">Professional License
                                        Expiration</label>
                                    <input type="date" name="owner3_prof_license_exp" class="form-control"
                                        id="owner3_prof_license_exp" value="{{ old('owner3_prof_license_exp') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_lic_1" class="form-label"> TX Driver's License #</label>
                                    <input type="text" name="owner3_lic_1" class="form-control" id="owner3_lic_1"
                                        value="{{ old('owner3_lic_1') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_lic_2" class="form-label">Professional License #</label>
                                    <input type="text" name="owner3_lic_2" class="form-control" id="owner3_lic_2"
                                        value="{{ old('owner3_lic_2') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="owner3_aliases" class="form-label">Aliases (any other names used)</label>
                                    <input type="text" class="form-control" name="owner3_aliases" id="owner3_aliases"
                                        value="{{ old('owner3_aliases') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <div class="form-check mt-4 pt-3">
                                        <input type="checkbox" class="form-check-input" name="owner3_relationships"
                                            value="1" {{ old('owner3_relationships') ? 'checked' : '' }}>
                                        <label class="form-check-label">Relationships with other agencies?</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input citizen-checkbox"
                                            id="owner3_citizen" name="owner3_citizen" value="1"
                                            data-target="#greencard_info_wrapper_3"
                                            {{ old('owner3_citizen') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="owner3_citizen">Citizen?</label>
                                    </div>

                                    <div class="form-group mt-2" id="greencard_info_wrapper_3"
                                        style="display: {{ old('owner3_citizen') ? 'none' : 'block' }};">
                                        <label class="form-label" for="owner3_greencard">If no, include Green Card
                                            Identification #</label>
                                        <input type="text" class="form-control" name="owner3_greencard"
                                            id="owner3_greencard" value="{{ old('owner3_greencard') }}">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ========== About Business ========== -->
                        <div class="form-section ">
                            <h3 class="section-title ">About Your Agency</h3>
                            <p>To help us create your marketing materials, website, and social media
                                pages, please share some information about your agency.</p>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="logo" class="form-label">Logo (upload a .png or .jpeg file)</label>
                                    <input type="file" name="logo" class="form-control" id="logo"
                                        accept=".jpg,.jpeg,.png">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="slogan" class="form-label">Slogan (optional):</label>
                                    <input type="text" name="slogan" class="form-control" id="slogan"
                                        value="{{ old('slogan') }}">
                                </div>
                                <div class="row mb-3">
                                    <label class="form-label">Business Hours</label>
                                    <div class="col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $days = [
                                                        'Monday',
                                                        'Tuesday',
                                                        'Wednesday',
                                                        'Thursday',
                                                        'Friday',
                                                        'Saturday',
                                                        'Sunday',
                                                    ];
                                                    $oldBusinessHours = old('business_hours', []);
                                                @endphp

                                                @foreach ($days as $day)
                                                    @php
                                                        $start = $oldBusinessHours[$day]['start'] ?? '';
                                                        $end = $oldBusinessHours[$day]['end'] ?? '';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $day }}</td>
                                                        <td>
                                                            <input type="time"
                                                                name="business_hours[{{ $day }}][start]"
                                                                class="form-control" value="{{ $start }}">
                                                        </td>
                                                        <td>
                                                            <input type="time"
                                                                name="business_hours[{{ $day }}][end]"
                                                                class="form-control" value="{{ $end }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <!-- On call on Saturdays -->
                                    <div class="col-md-6">
                                        <label class="form-label">On call on Saturday?</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="on_call_saturday"
                                                    id="on_call_saturday_yes" value="1"
                                                    {{ old('on_call_saturday') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="on_call_saturday_yes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="on_call_saturday"
                                                    id="on_call_saturday_no" value="0"
                                                    {{ old('on_call_saturday') == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="on_call_saturday_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- On call on Sundays -->
                                    <div class="col-md-6">
                                        <label class="form-label">On call on Sundays?</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="on_call_sunday"
                                                    id="on_call_sunday_yes" value="1"
                                                    {{ old('on_call_sunday') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="on_call_sunday_yes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="on_call_sunday"
                                                    id="on_call_sunday_no" value="0"
                                                    {{ old('on_call_sunday') == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="on_call_sunday_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="areas_service" class="form-label">What areas does your business
                                        service?</label>
                                    <input type="text" name="areas_service" class="form-control" id="areas_service"
                                        value="{{ old('areas_service') }}">
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label for="mission" class="form-label">Mission/Vision Statement (optional)</label>
                                    <textarea name="mission" class="form-control" id="mission" rows="4">{{ old('mission') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- ========== Online Presence ========== -->
                        <div class="form-section ">
                            <h3 class="section-title">Online Presence</h3>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label class="form-label d-block mb-2">Show agency's address on website?</label>
                                    <p>You can omit the address if it's your home.</p>


                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="show_address" class="form-check-input"
                                            id="show_address_yes" value="1"
                                            {{ old('show_address') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_address_yes">Yes</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="show_address" class="form-check-input"
                                            id="show_address_no" value="0"
                                            {{ old('show_address') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_address_no">No</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label class="form-label d-block mb-2">Have a Facebook page?</label>
                                    <p>To create a Facebook page, you'll first need a personal Facebook account.</p>

                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="has_facebook" class="form-check-input"
                                            id="has_facebook_yes" value="1"
                                            {{ old('has_facebook') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_facebook_yes">Yes</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="has_facebook" class="form-check-input"
                                            id="has_facebook_no" value="0"
                                            {{ old('has_facebook') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_facebook_no">No</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="facebook_link" class="form-label">Existing Facebook Page Link (if
                                        applicable)</label>
                                    <input type="url" name="facebook_link" class="form-control" id="facebook_link"
                                        value="{{ old('facebook_link') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="instagram_link" class="form-label">Existing Instagram Page Link (if
                                        applicable)</label>
                                    <input type="url" name="instagram_link" class="form-control" id="instagram_link"
                                        value="{{ old('instagram_link') }}">
                                </div>
                            </div>
                        </div>

                        <!-- ========== Payment ========== -->
                        <div class="form-section ">
                            <h3 class="section-title">Client Payment Information</h3>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="payment_methods" class="form-label">What payment methods do you accept
                                        from
                                        clients?</label>
                                    <input type="text" name="payment_methods" class="form-control"
                                        id="payment_methods" value="{{ old('payment_methods') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label class="form-label">Does your agency accept insurance?</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="accepts_insurance"
                                                id="accepts_insurance_yes" value="1"
                                                {{ old('accepts_insurance') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="accepts_insurance_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="accepts_insurance"
                                                id="accepts_insurance_no" value="0"
                                                {{ old('accepts_insurance') == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="accepts_insurance_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset"
                                class="btn button-primary me-md-2 justify-content-center">Reset</button>
                            <button type="submit"
                                class="btn button-primary intake-from-submit-btn justify-content-center">Submit
                                Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $.validator.addMethod("futureDate", function(value, element) {
                if (!value) return true; // ignore if empty (server will handle if required)
                var inputDate = new Date(value);
                var today = new Date();
                today.setHours(0, 0, 0, 0); // set time to 00:00 to compare only date
                return inputDate > today;
            }, "Please enter a date after today.");

            $.validator.addMethod("fileSize", function(value, element, param) {
                if (element.files.length === 0) return true; // no file, let server handle nullable
                return element.files[0].size <= param;
            }, "File must be less than 2MB.");



            $('#intakeForm').validate({
                rules: {
                    agency_name: {
                        required: true,
                        maxlength: 255
                    },
                    address: {
                        required: true,
                        maxlength: 255
                    },
                    dba: {
                        maxlength: 255
                    },
                    phone: {
                        required: true,
                        maxlength: 20
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    alternate_email: {
                        email: true
                    },
                    fax: {
                        maxlength: 20
                    },
                    npi: {
                        maxlength: 50
                    },
                    ein: {
                        maxlength: 50
                    },
                    owner1_name: {
                        required: true,
                        maxlength: 255
                    },
                    owner1_percent: {
                        number: true,
                        max: 100
                    },
                    owner1_aliases: {
                        maxlength: 255
                    },
                    owner1_dob: {
                        date: true
                    },
                    owner1_ssn: {
                        maxlength: 20
                    },
                    owner1_txdl_exp: {
                        date: true,
                        futureDate: true

                    },
                    owner1_prof_license_exp: {
                        date: true,
                        futureDate: true
                    },
                    owner1_lic_1: {
                        maxlength: 50
                    },
                    owner1_lic_2: {
                        maxlength: 50
                    },
                    owner1_relationships: {
                        maxlength: 255
                    },
                    owner1_greencard: {
                        maxlength: 255
                    },
                    admin_resume_file: {
                        fileSize: 2 * 1024 * 1024
                    },
                    admin_presurvey_file: {
                        fileSize: 2 * 1024 * 1024
                    },

                    owner2_name: {
                        maxlength: 255
                    },
                    owner2_percent: {
                        number: true,
                        max: 100

                    },
                    owner2_aliases: {
                        maxlength: 255
                    },
                    owner2_dob: {
                        date: true
                    },
                    owner2_ssn: {
                        maxlength: 20
                    },
                    owner2_txdl_exp: {
                        date: true,
                        futureDate: true

                    },
                    owner2_prof_license_exp: {
                        date: true,
                        futureDate: true

                    },
                    owner2_lic_1: {
                        maxlength: 50
                    },
                    owner2_lic_2: {
                        maxlength: 50
                    },
                    owner2_relationships: {
                        maxlength: 255
                    },
                    owner2_greencard: {
                        maxlength: 255
                    },

                    owner3_name: {
                        maxlength: 255
                    },
                    owner3_percent: {
                        number: true,
                        max: 100

                    },
                    owner3_aliases: {
                        maxlength: 255
                    },
                    owner3_dob: {
                        date: true
                    },
                    owner3_ssn: {
                        maxlength: 20
                    },
                    owner3_txdl_exp: {
                        date: true,
                        futureDate: true

                    },
                    owner3_prof_license_exp: {
                        date: true,
                        futureDate: true

                    },
                    owner3_lic_1: {
                        maxlength: 50
                    },
                    owner3_lic_2: {
                        maxlength: 50
                    },
                    owner3_relationships: {
                        maxlength: 255
                    },
                    owner3_greencard: {
                        maxlength: 255
                    },
                    logo: {
                        maxlength: 255,
                        fileSize: 2 * 1024 * 1024

                    },
                    slogan: {
                        maxlength: 255
                    },
                    areas_service: {
                        required: true,
                        maxlength: 255
                    },
                    mission: {
                        maxlength: 500
                    },

                    alt_admin_name: {
                        required: true,
                        maxlength: 255
                    },
                    alt_admin_aliases: {
                        maxlength: 255
                    },
                    alt_admin_dob: {
                        date: true
                    },
                    alt_admin_ssn: {
                        maxlength: 20
                    },
                    alt_admin_txdl_exp: {
                        date: true,
                        futureDate: true

                    },
                    alt_admin_prof_license_exp: {
                        date: true,
                        futureDate: true

                    },
                    alt_admin_lic_1: {
                        maxlength: 50
                    },
                    alt_admin_lic_2: {
                        maxlength: 50
                    },
                    alt_admin_greencard: {
                        maxlength: 255
                    },
                    alt_admin_relationships: {
                        maxlength: 255
                    },
                    payment_methods: {
                        required: true
                    },

                    alt_admin_resume_file: {
                        fileSize: 2 * 1024 * 1024
                    },
                    alt_admin_presurvey_file: {
                        fileSize: 2 * 1024 * 1024
                    }
                },

                errorClass: 'text-danger',
                errorElement: 'div',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

        $(document).ready(function() {
            $("form").on("submit", function(e) {
                let isValid = true;

                @foreach ($days as $day)
                    let start{{ $day }} = $(
                        "input[name='business_hours[{{ $day }}][start]']").val();
                    let end{{ $day }} = $(
                        "input[name='business_hours[{{ $day }}][end]']").val();

                    if ((start{{ $day }} && !end{{ $day }}) || (!
                            start{{ $day }} && end{{ $day }})) {
                        isValid = false;
                        toastr.error("Please fill both start and end time for {{ $day }}");
                    }

                    if (start{{ $day }} && end{{ $day }} &&
                        start{{ $day }} === end{{ $day }}) {
                        isValid = false;
                        toastr.error("Start and end time cannot be the same for {{ $day }}");
                    }
                @endforeach

                if (!isValid) e.preventDefault();
            });
        });



        $.validator.addMethod("futureDate", function(value, element) {
            if (!value) return true;
            var inputDate = new Date(value);
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            return inputDate > today;
        }, "Please enter a date after today.");

        $(document).ready(function() {
            $('.citizen-checkbox').on('change', function() {
                const target = $(this).data('target');
                if ($(this).is(':checked')) {
                    $(target).hide();
                } else {
                    $(target).show();
                }
            }).trigger('change');
        });

        $(document).ready(function() {
            function toggleFileInput(checkboxId, fileDivId) {
                if ($('#' + checkboxId).is(':checked')) {
                    $('#' + fileDivId).show();
                } else {
                    $('#' + fileDivId).hide();
                }
            }

            toggleFileInput('admin_resume', 'admin_resume_file');
            toggleFileInput('admin_presurvey_modules', 'admin_presurvey_file');
            toggleFileInput('alt_admin_resume', 'alt_admin_resume_file');
            toggleFileInput('alt_admin_presurvey_modules', 'alt_admin_presurvey_file');

            $('#admin_resume').change(function() {
                toggleFileInput('admin_resume', 'admin_resume_file');
            });

            $('#admin_presurvey_modules').change(function() {
                toggleFileInput('admin_presurvey_modules', 'admin_presurvey_file');
            });

            $('#alt_admin_resume').change(function() {
                toggleFileInput('alt_admin_resume', 'alt_admin_resume_file');
            });

            $('#alt_admin_presurvey_modules').change(function() {
                toggleFileInput('alt_admin_presurvey_modules', 'alt_admin_presurvey_file');
            });
        });

        $(document).ready(function() {
            $('#copy_owner2_to_alt_admin').on('change', function() {
                if ($(this).is(':checked')) {
                    // Copy values from Owner 2 to Alternate Admin
                    $('#alt_admin_name').val($('#owner2_name').val());
                    $('#alt_admin_aliases').val($('#owner2_aliases').val());
                    $('#alt_admin_dob').val($('#owner2_dob').val());
                    $('#alt_admin_ssn').val($('#owner2_ssn').val());
                    $('#alt_admin_txdl_exp').val($('#owner2_txdl_exp').val());
                    $('#alt_admin_prof_license_exp').val($('#owner2_prof_license_exp').val());
                    $('#alt_admin_lic_1').val($('#owner2_lic_1').val());
                    $('#alt_admin_lic_2').val($('#owner2_lic_2').val());
                    $('#alt_admin_relationships').val($('#owner2_relationships').is(':checked') ? 'Yes' :
                        '');
                    $('#alt_admin_greencard').val($('#owner2_greencard').val());

                    // Citizen checkbox
                    $('#alt_admin_citizen').prop('checked', $('#owner2_citizen').is(':checked')).trigger(
                        'change');

                    // Resume checkbox - Optional: decide if you want to copy it
                    // $('#alt_admin_resume').prop('checked', true);
                } else {
                    // Optional: Clear values if unchecked
                    $('#alt_admin_name, #alt_admin_aliases, #alt_admin_dob, #alt_admin_ssn, #alt_admin_txdl_exp, #alt_admin_prof_license_exp, #alt_admin_lic_1, #alt_admin_lic_2, #alt_admin_relationships, #alt_admin_greencard')
                        .val('');
                    $('#alt_admin_citizen, #alt_admin_resume').prop('checked', false).trigger('change');
                }
            });
        });
    </script>

@endsection
