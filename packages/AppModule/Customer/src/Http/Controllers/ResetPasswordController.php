<?php

namespace AppModule\Customer\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use AppModule\Customer\Repositories\CustomerRepository;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     * 
     * @param  \AppModule\Customer\Repositories\CustomerRepository  $customer
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository
    )
    {
        $this->_config = request('_config');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function create($token = null)
    {
        return view($this->_config['view'])->with(
            ['token' => $token, 'email' => request('email')]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $this->validate(request(), [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|confirmed|min:6',
            ]);

            $response = $this->broker()->reset(
                request(['email', 'password', 'password_confirmation', 'token']), function ($customer, $password) {
                    $this->resetPassword($customer, $password);
                }
            );

            if ($response == Password::PASSWORD_RESET) {
                $user = $this->customerRepository->findOneByField('email', request('email'));
                
                Event::dispatch('user.admin.update-password', $user);

                return redirect()->route($this->_config['redirect']);
            }

            return back()
                ->withInput(request(['email']))
                ->withErrors([
                    'email' => trans($response),
                ]);
        } catch(\Exception $e) {
            session()->flash('error', trans($e->getMessage()));

            return redirect()->back();
        }
    }

    /**
     * Reset the given customer password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $customer
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($customer, $password)
    {
        $customer->password = Hash::make($password);

        $customer->setRememberToken(Str::random(60));

        $customer->save();

        event(new PasswordReset($customer));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('customers');
    }

}