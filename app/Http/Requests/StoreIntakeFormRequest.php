<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntakeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basic Agency Info
            'agency_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'dba' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'alternate_email' => 'nullable|email',
            'fax' => 'nullable|string|max:20',
            'npi' => 'nullable|string|max:50',
            'ein' => 'nullable|string|max:50',

            // Owner 1
            'owner1_name' => 'required|string|max:255',
            'owner1_percent' => 'nullable|numeric|max:100',
            'owner1_aliases' => 'nullable|string|max:255',
            'owner1_dob' => 'nullable|date',
            'owner1_ssn' => 'nullable|string|max:20',
            'owner1_txdl_exp' => 'nullable|date|after:today',
            'owner1_prof_license_exp' => 'nullable|date|after:today',
            'owner1_lic_1' => 'nullable|string|max:50',
            'owner1_lic_2' => 'nullable|string|max:50',
            'owner1_relationships' => 'nullable|string|max:255',
            'owner1_citizen' => 'nullable|boolean',
            'owner1_greencard' => 'nullable|string|max:255',
            'admin_resume' => 'nullable|boolean',
            'admin_resume_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'admin_presurvey_modules' => 'nullable|boolean',
            'admin_presurvey_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',

            // Owner 2
            'owner2_name' => 'nullable|string|max:255',
            'owner2_percent' => 'nullable|numeric|max:100',
            'owner2_aliases' => 'nullable|string|max:255',
            'owner2_dob' => 'nullable|date',
            'owner2_ssn' => 'nullable|string|max:20',
            'owner2_txdl_exp' => 'nullable|date|after:today',
            'owner2_prof_license_exp' => 'nullable|date|after:today',
            'owner2_lic_1' => 'nullable|string|max:50',
            'owner2_lic_2' => 'nullable|string|max:50',
            'owner2_relationships' => 'nullable|string|max:255',
            'owner2_citizen' => 'nullable|boolean',
            'owner2_greencard' => 'nullable|string|max:255',

            // Owner 3
            'owner3_name' => 'nullable|string|max:255',
            'owner3_percent' => 'nullable|numeric|max:100',
            'owner3_aliases' => 'nullable|string|max:255',
            'owner3_dob' => 'nullable|date',
            'owner3_ssn' => 'nullable|string|max:20',
            'owner3_txdl_exp' => 'nullable|date|after:today',
            'owner3_prof_license_exp' => 'nullable|date|after:today',
            'owner3_lic_1' => 'nullable|string|max:50',
            'owner3_lic_2' => 'nullable|string|max:50',
            'owner3_relationships' => 'nullable|string|max:255',
            'owner3_citizen' => 'nullable|boolean',
            'owner3_greencard' => 'nullable|string|max:255',

            // // Alt Admin
            'alt_admin_name' => 'required|string|max:255',
            'alt_admin_aliases' => 'nullable|string|max:255',
            'alt_admin_dob' => 'nullable|date',
            'alt_admin_ssn' => 'nullable|string|max:20',
            'alt_admin_txdl_exp' => 'nullable|date|after:today',
            'alt_admin_prof_license_exp' => 'nullable|date|after:today',
            'alt_admin_lic_1' => 'nullable|string|max:50',
            'alt_admin_lic_2' => 'nullable|string|max:50',
            'alt_admin_resume' => 'nullable|boolean',
            'alt_admin_resume_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'alt_admin_citizen' => 'nullable|boolean',
            'alt_admin_greencard' => 'nullable|string|max:255',
            'alt_admin_presurvey_modules' => 'nullable|boolean',
            'alt_admin_presurvey_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'alt_admin_relationships' => 'nullable|string|max:255',

            // About
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'slogan' => 'nullable|string|max:255',
            'business_hours' => 'nullable|array',
            'business_hours.*.start' => 'nullable|date_format:H:i|required_with:business_hours.*.end',
            'business_hours.*.end' => 'nullable|date_format:H:i|required_with:business_hours.*.start',
            'on_call_saturday' => 'nullable|boolean',
            'on_call_sunday' => 'nullable|boolean',
            'areas_service' => 'required|string|max:255',
            'mission' => 'nullable|string|max:500',

            // Online presence
            'show_address' => 'nullable|boolean',
            'has_facebook' => 'nullable|boolean',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',

            // Payment
            'payment_methods' => 'required|string|max:255',
            'accepts_insurance' => 'nullable|boolean',
        ];
    }
}
