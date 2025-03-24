namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // ✅ Laisser passer la requête si l'utilisateur est en train de vérifier son email
        if ($request->routeIs('verification.verify')) {
            return $next($request);
        }

        // ✅ Si l'utilisateur n'est pas vérifié, mais qu'il essaie d'accéder à autre chose, on bloque
        if (!$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
