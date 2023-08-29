<?php

namespace AppModule\Shop\Http\Middleware;

use Closure;
use AppModule\Core\Repositories\LocaleRepository;

class Locale
{
    /**
     * Create a middleware instance.
     *
     * @param  \AppModule\Core\Repositories\LocaleRepository  $localeRepository
     * @return void
     */
    public function __construct(protected LocaleRepository $localeRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($localeCode = core()->getRequestedLocaleCode('locale', false)) {
            if ($this->localeRepository->findOneByField('code', $localeCode)) {
                app()->setLocale($localeCode);

                session()->put('locale', $localeCode);
            }
        } else {
            if ($localeCode = session()->get('locale')) {
                app()->setLocale($localeCode);
            } else {
                app()->setLocale(core()->getDefaultChannel()->default_locale->code);
            }
        }

        unset($request['locale']);

        return $next($request);
    }
}
