<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::select(['id', 'name', 'email'])->role('admin')->get();
        $donors = User::select(['id', 'name', 'email'])->role('donor')->paginate(20);
        $needy = User::select(['id', 'name', 'email'])->role('needy')->paginate(20);

        return Inertia::render('Admin/Users', [
            'usersData' => [
                'admins' => $admins,
                'donors' => $donors,
                'needy' => $needy
            ]
        ]);
    }
}
