<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function index()
    {
        return Inertia::render('Donations', [
            'histories' => 'for all role',
            'requests' => 'for admin role and needy role',
            'users' => 'for admin to see all users donation histories',
        ]);
    }
}
