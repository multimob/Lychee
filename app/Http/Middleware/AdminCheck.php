<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Middleware;

use App\MiddlewareFunctions\IsInstalled;
use App\ModelFunctions\SessionFunctions;
use Closure;
use Illuminate\Http\Request;

class AdminCheck
{
	/**
	 * @var SessionFunctions
	 */
	private $sessionFunctions;

	public function __construct(SessionFunctions $sessionFunctions)
	{
		$this->sessionFunctions = $sessionFunctions;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!IsInstalled::assert()) {
			return $next($request);
		}

		if (!$this->sessionFunctions->is_admin()) {
			return response('false');
		}

		return $next($request);
	}
}
