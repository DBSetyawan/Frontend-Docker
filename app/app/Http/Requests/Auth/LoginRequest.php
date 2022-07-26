<?php

namespace App\Http\Requests\Auth;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
        return [
            'user' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        ]);

        $response = $client->get(
            'http://10.0.84.248:8892/oauth-aci',
            ['body' => json_encode(
                [
                    'user' => $this->input('user'),
                    'password' => $this->input('password')
                ]
            )]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['rd']) == "Sukses") {
            $this->ensureIsNotRateLimited();

            if (!Auth::attempt([
                'user' => $this->input('user'),
                'password' => $this->input('password'),
            ], $this->boolean('remember'))) {

                throw ValidationException::withMessages([
                    'user' => trans('auth.failed'),
                ]);
            }
        } else {

            if (!Auth::attempt([
                'user' => $this->input('user'),
                'password' => $this->input('password'),
            ], $this->boolean('remember'))) {

                throw ValidationException::withMessages([
                    'user' => $data['response']['rd'],
                ]);
                RateLimiter::hit($this->throttleKey());
            }
        }
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'user' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('user')) . '|' . $this->ip();
    }
}
