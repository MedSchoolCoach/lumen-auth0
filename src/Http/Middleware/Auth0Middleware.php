<?php

namespace MedSchoolCoach\LumenAuth0\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use MedSchoolCoach\LumenAuth0\Auth0Verifier;
use Closure;
use Illuminate\Http\Request;
use MedSchoolCoach\LumenAuth0\Models\User;

/**
 * Class Auth0Middleware
 * @package MedSchoolCoach\LumenAuth0\Http\Middleware
 */
class Auth0Middleware
{
    /**
     * @var Auth0Verifier
     */
    private $verifier;

    /**
     * Auth0Middleware constructor.
     * @param Auth0Verifier $verifier
     */
    public function __construct(Auth0Verifier $verifier)
    {
        $this->verifier = $verifier;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $this->verifier->check($request->bearerToken());
        } catch (\Exception $e) {
            return $this->abort(401, $e->getMessage());
        }

        return $next($request);
    }

    /**
     * @param $code
     * @param string $message
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    private function abort($code, $message = '', array $headers = [])
    {
        return response()->json(['message' => $message], $code, $headers);
    }
}
