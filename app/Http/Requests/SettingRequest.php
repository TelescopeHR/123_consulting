<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $stripe_required = false;
        $smtp_required = false;
        $googlelogin_required = false;
        $grecaptcha_reuired = false;

        if ($this->stripe_enviroment || $this->publishable_key || $this->stripe_key) {
            $stripe_required = true;
        }
        if ($this->mailer || $this->mail_host || $this->mail_port || $this->mail_encryption || $this->username || $this->password || $this->mail_address || $this->mailer_name) {
            $smtp_required = true;
        }
        if ($this->google_clientid || $this->google_secret) {
            $googlelogin_required = true;
        }
        if ($this->g_recaptcha_key || $this->g_recaptcha_secret) {
            $grecaptcha_reuired = true;
        }

        return [
            'stripe_enviroment' => Rule::requiredIf($stripe_required) . '|nullable|in:test,live',
            'publishable_key' => Rule::requiredIf($stripe_required),
            'stripe_key' => Rule::requiredIf($stripe_required),

            'mailer' => Rule::requiredIf($smtp_required),
            'mail_host' => Rule::requiredIf($smtp_required),
            'mail_port' => Rule::requiredIf($smtp_required) . '|nullable|numeric',
            'mail_encryption' => Rule::requiredIf($smtp_required) . '|in:ssl,auto,tls',
            'username' => Rule::requiredIf($smtp_required),
            'password' => Rule::requiredIf($smtp_required),
            'mail_address' => Rule::requiredIf($smtp_required) . '|nullable|email',
            'mailer_name' => Rule::requiredIf($smtp_required),

            'google_clientid' => Rule::requiredIf($googlelogin_required),
            'google_secret' => Rule::requiredIf($googlelogin_required),

            'g_recaptcha_key' => Rule::requiredIf($grecaptcha_reuired),
            'g_recaptcha_secret' => Rule::requiredIf($grecaptcha_reuired),

            'facebook_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',

            'logo' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'faviconicon' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000'
        ];
    }
}
