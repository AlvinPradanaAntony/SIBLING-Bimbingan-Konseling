
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (!Auth::user()->hasPermissionTo($permission)) {
            return redirect('/home'); // atau tampilkan halaman error
        }

        return $next($request);
    }
}
