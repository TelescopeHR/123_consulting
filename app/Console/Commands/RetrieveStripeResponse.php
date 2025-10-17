<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\StripeResponse;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserPolicy;
use App\Models\UserSubscription;
use App\Models\VerifyUser;
use App\Traits\SendEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RetrieveStripeResponse extends Command
{
    use SendEmail;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retrieve:stripe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stripe_key = get_setting_value('stripe_key');
        $stripe_key = $stripe_key ? $stripe_key : env('STRIPE_SECRET');
        \Stripe\Stripe::setApiKey($stripe_key);

        $stripeResponses = StripeResponse::where('payment_status', 'unpaid')->where('created_at', '>=', Carbon::now()->subDays(1))->get();

        foreach ($stripeResponses as $stripeResponse) {

            $user = User::find($stripeResponse->user_id);
            $checkout_session = \Stripe\Checkout\Session::retrieve($stripeResponse->response_id);

            if ($checkout_session->payment_status == 'paid') {

                Log::error($stripeResponse->id);
                $session_cart_data = $stripeResponse->session_data ? json_decode($stripeResponse->session_data) : [];

                if (!empty($session_cart_data)) {
                    $stripe_response = StripeResponse::where('response_id', $stripeResponse->response_id)->first();

                    foreach ($session_cart_data as $cart_item) {
                        if (isset($cart_item->course)) {
                            $cart_course = Course::find($cart_item->course->id);
                            // $cart_course = $cart_item->course;
                            $course_categories = $cart_course->categories->pluck('id')->toArray();

                            /* Start: Abandoned Cart */
                            abandonedCart($cart_item->course_id, null, 4);
							/* End: Abandoned Cart */

                            if (in_array(1, $course_categories)) {
                                UserSubscription::updateOrCreate([
                                    'user_id' => $user->id,
                                    'order_id' => $stripe_response->id,
                                    'course_id' => $cart_item->course_id,
                                ], [
                                    'purchase_date' => Carbon::now()
                                ]);
                            } else {
                                $names = isset($cart_item->certificate_details) ? json_decode($cart_item->certificate_details, true)['names'] : NULL;
                                if ($names) {
                                    for ($i = 0; $i < $cart_item->quantity; $i++) {
                                        //Generate Random password.
                                        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                                        $password = substr(str_shuffle($chars), 0, 10);

                                        $caregiver = '';
                                        if ($names[$i]['email']) {
                                            $caregiver = User::where('email', $names[$i]['email'])->first();
                                        }
                                        if (!$caregiver) {
                                            $caregiver = User::create([
                                                'agency_name' => '',
                                                'parent_id' => $user->id,
                                                'first_name' => $names[$i]['first_name'] ?? $user->first_name,
                                                'last_name' => $names[$i]['last_name'] ?? $user->last_name,
                                                'email' => $names[$i]['email'] ?? null,
                                                'phone' => '',
                                                'username' => '',
                                                'is_password_sent' => 1,
                                                'password' => Hash::make($password)
                                            ]);

                                            VerifyUser::create([
                                                'user_id' => $caregiver->id,
                                                'token' => sha1(time())
                                            ]);

                                            $role = Role::updateOrCreate(['name' => Config::get('constants.users_roles.caregiver')]);
                                            $caregiver->assignRole($role);
                                            if ($names[$i]['email']) {
                                                $this->sendAccountDetailsEmail($names[$i]['email'], $caregiver, $password);
                                            }
                                        }

                                        UserCourse::updateOrCreate([
                                            'user_id' => $user->id,
                                            'course_id' => $cart_item->course_id,
                                            'order_id' => $stripe_response->id,
                                            'caregiver_id' => $caregiver->id
                                        ], [
                                            'certificate_name' => ($names[$i]['first_name'] ?? $caregiver->first_name) . ' ' . ($names[$i]['last_name'] ?? $caregiver->last_name),
                                            'purchase_date' => Carbon::now(),
                                        ]);
                                    }
                                }
                            }

                        } elseif (isset($cart_item->policy_manual)) {
                            UserPolicy::updateOrCreate([
                                'user_id' => $user->id,
                                'policy_manual_id' => $cart_item->policy_manual_id,
                                'order_id' => $stripe_response->id,
                            ], [
                                'purchase_date' => Carbon::now()
                            ]);

                            /* Start: Abandoned Cart */
                            abandonedCart(null, $cart_item->policy_manual_id, 4);
							/* End: Abandoned Cart */
                        }
                    }

                    $receipt = createInvoicePdf($user, $stripe_response);

                    $stripe_response->update([
                        'invoice' => $receipt,
                        'stripe_response' => json_encode($checkout_session),
                        'payment_status' => $checkout_session->payment_status,
                        'status' => $checkout_session->status
                    ]);

                }
            }
        }

        return 0;
    }
}
