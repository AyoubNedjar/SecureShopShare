<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Closure;
use phpseclib3\Crypt\RSA;

class RegisteredUserController extends Controller
{
    public function create()
    {
        $verificationCode = Str::random(6);
        $encryptedCode = base64_encode($verificationCode);
        session(['verification_code' => $verificationCode]);

        return view('auth.register', compact('encryptedCode'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                $g_response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]);

                $g_response_body = $g_response->json();
                if (!$g_response_body['success']) {
                    $fail("The {$attribute} is invalid.");
                }
            }],
            'verification_code' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                if ($value !== session('verification_code')) {
                    $fail("The {$attribute} is invalid.");
                }
            }]
        ]);

        // Génération des clés RSA
        $rsa = RSA::createKey(2048);
        $publicKey = $rsa->getPublicKey()->toString('PKCS8');
        $privateKey = encrypt($rsa->toString('PKCS8')); // Chiffrer la clé privée

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'public_key' => $publicKey,
            'private_key' => $privateKey,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Je suis login');
    }
}
