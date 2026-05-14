<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class SecurityHeaders
{
   public function handle(Request $request, Closure $next): Response
   {
       $response = $next($request);
       $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
       $response->headers->set('X-Content-Type-Options', 'nosniff');
       $response->headers->set(
           'Content-Security-Policy',
           "default-src 'self' https://cdn.jsdelivr.net;"
       );
       $response->headers->set(
   'Content-Security-Policy',
   "default-src 'self' https://cdn.jsdelivr.net; frame-ancestors 'self'; form-action 'self';"
);
       return $response;
   }
}