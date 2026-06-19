<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CheckLoginAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the cookie
        $encryptedValue = $request->cookie('angga_bali_trans_admin');

        if ($encryptedValue) {
            try {
                // Decrypt the value
                $decryptedValue = Crypt::decryptString($encryptedValue);

                // Check if value is "true"
                if ($decryptedValue === 'true') {
                    return $next($request);
                }
            } catch (\Exception $e) {
                // Decryption failed
                return redirect('/')->with('error', 'Invalid session');
            }
        }

        // Redirect to  if the cookie is missing or invalid
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
