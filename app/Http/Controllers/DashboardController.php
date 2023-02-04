<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataRoles = [];
        $roles = $request->user()->getRoleNames();

        foreach ($roles as $role) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($role) . "\\DashboardController";

            $dataRoles[$role] = (new $controller)->index($request);
        }

        return Inertia::render('Dashboard', [
            'dataRoles' => $dataRoles
        ]);
    }
}
