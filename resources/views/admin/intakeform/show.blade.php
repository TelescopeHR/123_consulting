@extends('admin.layouts.master')
@section('title', ucfirst(Str::plural($module)))

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12 col-sm-12">
                    <h1>Agency Details</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content agency-details-page">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="container-fluid">
                    <div class="card">  
                        <div class="card-body">
                            <h4 class="">Basic Information</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Agency Name</th>
                                        <td>{{ $intakeForm->agency_name }}</td>
                                        <th>Address</th>
                                        <td>{{ $intakeForm->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Doing Business As</th>
                                        <td>{{ $intakeForm->dba }}</td>
                                        <th>Phone</th>
                                        <td>{{ $intakeForm->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $intakeForm->email }}</td>
                                        <th>Alternate Email</th>
                                        <td>{{ $intakeForm->alternate_email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fax</th>
                                        <td>{{ $intakeForm->fax }}</td>
                                        <th>NPI</th>
                                        <td>{{ $intakeForm->npi }}</td>
                                    </tr>
                                    <tr>
                                        <th>EIN</th>
                                        <td>{{ $intakeForm->ein }}</td>
                                    </tr>
                                </table>
                            </div>



                            <h4 class="mt-4">Owner 1 Details</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $intakeForm->owner1_name }}</td>
                                        <th>Ownership %</th>
                                        <td>{{ $intakeForm->owner1_percent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aliases</th>
                                        <td>{{ $intakeForm->owner1_aliases }}</td>
                                        <th>Date of Birth</th>
                                        <td>{{ $intakeForm->owner1_dob }}</td>
                                    </tr>
                                    <tr>
                                        <th>SSN</th>
                                        <td>{{ $intakeForm->owner1_ssn }}</td>
                                        <th>TXDL Expiry</th>
                                        <td>{{ $intakeForm->owner1_txdl_exp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Professional License Expiry</th>
                                        <td>{{ $intakeForm->owner1_prof_license_exp }}</td>
                                        <th>License 1</th>
                                        <td>{{ $intakeForm->owner1_lic_1 }}</td>
                                    </tr>
                                    <tr>
                                        <th>License 2</th>
                                        <td>{{ $intakeForm->owner1_lic_2 }}</td>
                                        <th>Relationships</th>
                                        <td>{{ $intakeForm->owner1_relationships == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Citizen</th>
                                        <td>{{ $intakeForm->owner1_citizen == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Green Card</th>
                                        <td>{{ $intakeForm->owner1_greencard }}</td>
                                    </tr>
                                    <tr>
                                        <th>Admin Resume</th>
                                        <td>{{ $intakeForm->admin_resume == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Admin Resume File</th>
                                        <td>
                                            @if ($intakeForm->admin_resume_file)
                                                <a href="{{ asset($intakeForm->admin_resume_file) }}" target="_blank">View File</a>
                    
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Admin Pre-Survey Modules</th>
                                        <td>{{ $intakeForm->admin_presurvey_modules == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Admin Pre-Survey File</th>
                                        <td>
                                            @if ($intakeForm->admin_presurvey_file)
                                                <a href="{{ asset($intakeForm->admin_presurvey_file) }}" target="_blank">View File</a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <h4 class="mt-4">Alternate Admin</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $intakeForm->alt_admin_name }}</td>
                                        <th>Aliases</th>
                                        <td>{{ $intakeForm->alt_admin_aliases }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $intakeForm->alt_admin_dob }}</td>
                                        <th>SSN</th>
                                        <td>{{ $intakeForm->alt_admin_ssn }}</td>
                                    </tr>
                                    <tr>
                                        <th>TXDL Expiry</th>
                                        <td>{{ $intakeForm->alt_admin_txdl_exp }}</td>
                                        <th>Professional License Expiry</th>
                                        <td>{{ $intakeForm->alt_admin_prof_license_exp }}</td>
                                    </tr>
                                    <tr>
                                        <th>License 1</th>
                                        <td>{{ $intakeForm->alt_admin_lic_1 }}</td>
                                        <th>License 2</th>
                                        <td>{{ $intakeForm->alt_admin_lic_2 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Resume</th>
                                        <td>{{ $intakeForm->alt_admin_resume == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Resume File</th>
                                        <td>
                                            @if ($intakeForm->alt_admin_resume_file)
                                                <a href="{{ asset($intakeForm->alt_admin_resume_file) }}" target="_blank">View File</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Citizen</th>
                                        <td>{{ $intakeForm->alt_admin_citizen == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Green Card</th>
                                        <td>{{ $intakeForm->alt_admin_greencard }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pre-Survey Modules</th>
                                        <td>{{ $intakeForm->alt_admin_presurvey_modules == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Pre-Survey File</th>
                                        <td>
                                            @if ($intakeForm->alt_admin_presurvey_file)
                                                <a href="{{ asset($intakeForm->alt_admin_presurvey_file) }}" target="_blank">View File</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Relationships</th>
                                        <td>{{ $intakeForm->alt_admin_relationships }}</td>
                                    </tr>
                                </table>
                            </div>

                            <h4 class="mt-4">Owner 2 Details</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $intakeForm->owner2_name }}</td>
                                        <th>Ownership %</th>
                                        <td>{{ $intakeForm->owner2_percent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aliases</th>
                                        <td>{{ $intakeForm->owner2_aliases }}</td>
                                        <th>Date of Birth</th>
                                        <td>{{ $intakeForm->owner2_dob }}</td>
                                    </tr>
                                    <tr>
                                        <th>SSN</th>
                                        <td>{{ $intakeForm->owner2_ssn }}</td>
                                        <th>TXDL Expiry</th>
                                        <td>{{ $intakeForm->owner2_txdl_exp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Professional License Expiry</th>
                                        <td>{{ $intakeForm->owner2_prof_license_exp }}</td>
                                        <th>License 1</th>
                                        <td>{{ $intakeForm->owner2_lic_1 }}</td>
                                    </tr>
                                    <tr>
                                        <th>License 2</th>
                                        <td>{{ $intakeForm->owner2_lic_2 }}</td>
                                        <th>Relationships</th>
                                        <td>{{ $intakeForm->owner2_relationships == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Citizen</th>
                                        <td>{{ $intakeForm->owner2_citizen == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Green Card</th>
                                        <td>{{ $intakeForm->owner2_greencard }}</td>
                                    </tr>
                                </table>
                            </div>

                            <h4 class="mt-4">Owner 3 Details</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $intakeForm->owner3_name }}</td>
                                        <th>Ownership %</th>
                                        <td>{{ $intakeForm->owner3_percent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aliases</th>
                                        <td>{{ $intakeForm->owner3_aliases }}</td>
                                        <th>Date of Birth</th>
                                        <td>{{ $intakeForm->owner3_dob }}</td>
                                    </tr>
                                    <tr>
                                        <th>SSN</th>
                                        <td>{{ $intakeForm->owner3_ssn }}</td>
                                        <th>TXDL Expiry</th>
                                        <td>{{ $intakeForm->owner3_txdl_exp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Professional License Expiry</th>
                                        <td>{{ $intakeForm->owner3_prof_license_exp }}</td>
                                        <th>License 1</th>
                                        <td>{{ $intakeForm->owner3_lic_1 }}</td>
                                    </tr>
                                    <tr>
                                        <th>License 2</th>
                                        <td>{{ $intakeForm->owner3_lic_2 }}</td>
                                        <th>Relationships</th>
                                        <td>{{ $intakeForm->owner3_relationships == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Citizen</th>
                                        <td>{{ $intakeForm->owner3_citizen == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Green Card</th>
                                        <td>{{ $intakeForm->owner3_greencard }}</td>
                                    </tr>
                                </table>
                            </div>

<h4 class="mt-4">About</h4>
<div class="agency-table-container">
    <table class="table table-bordered agency-details-table">
        <tr>
            <th>Logo</th>
            <td>
                @if ($intakeForm->logo)
                    <a href="{{ asset($intakeForm->logo) }}" target="_blank">
                        <img src="{{ asset($intakeForm->logo) }}" width="100" alt="Logo">
                    </a>    
                @endif
            </td>
            <th>Slogan</th>
            <td>{{ $intakeForm->slogan }}</td>
        </tr>

       
        <tr>
            <th>Areas of Service</th>
            <td>{{ $intakeForm->areas_service }}</td>
            <th>Mission</th>
            <td>{{ $intakeForm->mission }}</td>
        </tr>
        <tr>
            <th>On call on Saturday</th>
            <td>{{ $intakeForm->on_call_saturday == 1 ? 'Yes' : 'No' }}</td>
            <th>On call on Sundays</th>
            <td>{{ $intakeForm->on_call_sunday == 1 ? 'Yes' : 'No'}}</td>
        </tr>
  
        
    </table>
@if(!empty($intakeForm->business_hours))
    <table class="table table-bordered agency-details-table">
        <tr>
            <th rowspan="{{ count($intakeForm->business_hours) + 1 }}">Business Hours</th>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>

        @php
            $businessHours = $intakeForm->business_hours ?? [];
        @endphp

        @foreach($businessHours as $day => $hours)
            <tr>
                <td>{{ $day }}</td>
                <td>{{ $hours['start'] ?? '-' }}</td>
                <td>{{ $hours['end'] ?? '-' }}</td>
            </tr>
        @endforeach
    </table>
@endif


</div>



                            <h4 class="mt-4">Online Presence</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Show Address</th>
                                        <td>{{ $intakeForm->show_address == 1 ? 'Yes' : 'No' }}</td>
                                        <th>Has Facebook</th>
                                        <td>{{ $intakeForm->has_facebook == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Facebook Link</th>
                                        <td>{{ $intakeForm->facebook_link }}</td>
                                        <th>Instagram Link</th>
                                        <td>{{ $intakeForm->instagram_link }}</td>
                                    </tr>
                                </table>
                            </div>

                            <h4 class="mt-4">Client Payment</h4>
                            <div class="agency-table-container">
                                <table class="table table-bordered agency-details-table">
                                    <tr>
                                        <th>Payment Methods</th>
                                        <td>{{ $intakeForm->payment_methods }}</td>
                                        <th>Accepts Insurance</th>
                                        <td>{{ $intakeForm->accepts_insurance == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>   
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
@endsection
