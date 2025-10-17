<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntakeFormsTable extends Migration
{
    public function up(): void
    {
        Schema::create('intake_forms', function (Blueprint $table) {
            $table->id();
            // Agency info
            $table->string('agency_name');
            $table->string('address')->nullable();
            $table->string('dba')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('fax')->nullable();
            $table->string('npi')->nullable();
            $table->string('ein')->nullable();

            // Owner 1
            $table->string('owner1_name')->nullable();
            $table->float('owner1_percent')->nullable();
            $table->string('owner1_aliases')->nullable();
            $table->date('owner1_dob')->nullable();
            $table->string('owner1_ssn')->nullable();
            $table->date('owner1_txdl_exp')->nullable();
            $table->date('owner1_prof_license_exp')->nullable();
            $table->string('owner1_lic_1')->nullable();
            $table->string('owner1_lic_2')->nullable();
            $table->string('owner1_relationships')->nullable();
            $table->boolean('owner1_citizen')->default(false);
            $table->string('owner1_greencard')->nullable();
                 $table->string('admin_resume')->nullable();
                         $table->string('admin_resume_file')->nullable();
            $table->json('admin_presurvey_modules')->nullable();
                    $table->string('admin_presurvey_file')->nullable();


             // Alt Admin
            $table->string('alt_admin_name')->nullable();
            $table->string('alt_admin_aliases')->nullable();
            $table->date('alt_admin_dob')->nullable();
            $table->string('alt_admin_ssn')->nullable();
            $table->date('alt_admin_txdl_exp')->nullable();
            $table->date('alt_admin_prof_license_exp')->nullable();
            $table->string('alt_admin_lic_1')->nullable();
            $table->string('alt_admin_lic_2')->nullable();
            $table->string('alt_admin_relationships')->nullable();
            $table->boolean('alt_admin_citizen')->default(false);
            $table->string('alt_admin_greencard')->nullable();
            $table->string('alt_admin_resume')->nullable();
            $table->string('alt_admin_resume_file')->nullable();
            $table->json('alt_admin_presurvey_modules')->nullable();
            $table->string('alt_admin_presurvey_file')->nullable();


            // Owner 2
            $table->string('owner2_name')->nullable();
            $table->float('owner2_percent')->nullable();
            $table->string('owner2_aliases')->nullable();
            $table->date('owner2_dob')->nullable();
            $table->string('owner2_ssn')->nullable();
            $table->date('owner2_txdl_exp')->nullable();
            $table->date('owner2_prof_license_exp')->nullable();
            $table->string('owner2_lic_1')->nullable();
            $table->string('owner2_lic_2')->nullable();
            $table->string('owner2_relationships')->nullable();
            $table->boolean('owner2_citizen')->default(false);
            $table->string('owner2_greencard')->nullable();
       

            // Owner 3
            $table->string('owner3_name')->nullable();
            $table->float('owner3_percent')->nullable();
            $table->string('owner3_aliases')->nullable();
            $table->date('owner3_dob')->nullable();
            $table->string('owner3_ssn')->nullable();
            $table->date('owner3_txdl_exp')->nullable();
            $table->date('owner3_prof_license_exp')->nullable();
            $table->string('owner3_lic_1')->nullable();
            $table->string('owner3_lic_2')->nullable();
            $table->string('owner3_relationships')->nullable();
            $table->boolean('owner3_citizen')->default(false);
            $table->string('owner3_greencard')->nullable();

            // About your agency
            $table->string('logo')->nullable();
            $table->string('slogan')->nullable();
            $table->time('business_hours_start')->nullable();
            $table->time('business_hours_end')->nullable();
            $table->string('areas_service')->nullable();
            $table->text('mission')->nullable();

            // Online Presence
            $table->boolean('show_address')->default(false);
            $table->boolean('has_facebook')->default(false);
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();

            // Client Payment
            $table->string('payment_methods')->nullable();
            $table->boolean('accepts_insurance')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_forms');
    }
}
