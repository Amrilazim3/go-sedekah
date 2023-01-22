<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $roles = $user->roles->transform(function ($item) {
            return $item->name;
        })->toArray();
        $dataRoles = [];

        foreach ($roles as $role) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($role) . "\\DonationController";

            $dataRoles[$role] = (new $controller)->index($request);
        }

        $queryResult = [];

        if (count(request(['role', 'model'])) > 0) {
            $queryController = "App\\Http\\Controllers\\"
                . ucfirst(request('role')) .
                "\\"
                . request('model')
                . "Controller";
            $urlParts = parse_url($request->getRequestUri());
            parse_str($urlParts['query'], $queryParamResults);
            $firstQueryParamKey = array_keys($queryParamResults)[0]; // either 'search' or 'status'

            $queryMethod = "query" . ucfirst($firstQueryParamKey) . "Filter";
            $queryResult = (new $queryController)->{$queryMethod}(request($firstQueryParamKey));
        }

        return Inertia::render('Donations', [
            'dataRoles' => $dataRoles,
            'queryResult' => $queryResult,
            'queryParams' => request(['search', 'role', 'model'])
        ])
            ->with('jetstream.flash.banner', session()->get('jetstream.flash.banner'))
            ->with('jetstream.flash.bannerStyle', session()->get('jetstream.flash.bannerStyle'));
    }
}