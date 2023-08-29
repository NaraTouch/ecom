<?php

namespace AppModule\Core\Http\Controllers;

use AppModule\Core\Repositories\CountryRepository;
use AppModule\Core\Repositories\CountryStateRepository;

class CountryStateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\Core\Repositories\CountryRepository  $countryRepository
     * @param  \AppModule\Core\Repositories\CountryStateRepository  $countryStateRepository
     * @return void
     */
    public function __construct(
        protected CountryRepository $countryRepository,
        protected CountryStateRepository $countryStateRepository
    ) {
    }

    /**
     * Get countries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountries()
    {
        return response()->json([
            'data' => core()->countries()->map(fn ($country) => [
                'id'   => $country->id,
                'code' => $country->code,
                'name' => $country->name,
            ]),
        ]);
    }

    /**
     * Get states.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates()
    {
        return response()->json([
            'data' => core()->groupedStatesByCountries(),
        ]);
    }
}
