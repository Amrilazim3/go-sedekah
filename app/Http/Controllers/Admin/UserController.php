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
        $admins = User::select(['id', 'name', 'email'])->role('admin')->paginate(20);
        $donors = User::select(['id', 'name', 'email'])->role('donor')->paginate(20);
        $needy = User::select(['id', 'name', 'email'])->role('needy')->paginate(20);

        $filteredData = User::select(['id', 'name', 'email'])
            ->filter(request('name'))
            ->role(request('role'))
            ->limit(10)
            ->get();
        
        return Inertia::render('Admin/Users', [
            'usersData' => [
                'admins' => $admins,
                'donors' => $donors,
                'needy' => $needy
            ],
            'filteredData' => $filteredData,
            'requestedData' => request(['name', 'role']),
        ]);
    }
}
