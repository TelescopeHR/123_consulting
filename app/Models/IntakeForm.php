<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntakeForm extends Model
{
    protected $fillable = [
        'agency_name',
        'address',
        'dba',
        'phone',
        'email',
        'alternate_email',
        'fax',
        'npi',
        'ein',

        // Owner 1
        'owner1_name',
        'owner1_percent',
        'owner1_aliases',
        'owner1_dob',
        'owner1_ssn',
        'owner1_txdl_exp',
        'owner1_prof_license_exp',
        'owner1_lic_1',
        'owner1_lic_2',
        'owner1_relationships',
        'owner1_citizen',
        'owner1_greencard',
        'admin_resume',
        'admin_resume_file',
        'admin_presurvey_modules',
        'admin_presurvey_file',

        // Owner 2
        'owner2_name',
        'owner2_percent',
        'owner2_aliases',
        'owner2_dob',
        'owner2_ssn',
        'owner2_txdl_exp',
        'owner2_prof_license_exp',
        'owner2_lic_1',
        'owner2_lic_2',
        'owner2_relationships',
        'owner2_citizen',
        'owner2_greencard',

        // Owner 3
        'owner3_name',
        'owner3_percent',
        'owner3_aliases',
        'owner3_dob',
        'owner3_ssn',
        'owner3_txdl_exp',
        'owner3_prof_license_exp',
        'owner3_lic_1',
        'owner3_lic_2',
        'owner3_relationships',
        'owner3_citizen',
        'owner3_greencard',

        // Alt Admin
        'alt_admin_name',
        'alt_admin_aliases',
        'alt_admin_dob',
        'alt_admin_ssn',
        'alt_admin_txdl_exp',
        'alt_admin_prof_license_exp',
        'alt_admin_lic_1',
        'alt_admin_lic_2',
        'alt_admin_resume',
        'alt_admin_resume_file',
        'alt_admin_citizen',
        'alt_admin_greencard',
        'alt_admin_presurvey_modules',
        'alt_admin_presurvey_file',
        'alt_admin_relationships',

        // About
        'logo',
        'slogan',
       'business_hours',
        'on_call_saturday',
        'on_call_sunday',
        'areas_service',
        'mission',

        // Online presence
        'show_address',
        'has_facebook',
        'facebook_link',
        'instagram_link',

        // Client payment
        'payment_methods',
        'accepts_insurance',
    ];

    protected $casts = [
        'business_hours' => 'array',
        'on_call_saturday' => 'boolean',
        'on_call_sunday' => 'boolean',
        'owner1_citizen' => 'boolean',
        'owner2_citizen' => 'boolean',
        'owner3_citizen' => 'boolean',
        'admin_citizen' => 'boolean',
        'alt_admin_citizen' => 'boolean',
        'show_address' => 'boolean',
        'has_facebook' => 'boolean',
        'accepts_insurance' => 'boolean',
    ];
}
