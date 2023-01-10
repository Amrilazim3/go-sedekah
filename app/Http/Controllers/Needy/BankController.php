<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BankController extends Controller
{
    public function index()
    {
        return Inertia::render('Needy/Banks', [
            'banksName' => [
                [
                    'SLL233',
                    'Maybank',
                ],
                [
                    'MBS193',
                    'Bank Islam',
                ],
                [
                    'MU133',
                    'Muamalat',
                ],
            ]
        ]);
    }
}
