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
        ])
            ->with('jetstream.flash.banner', session()->get('jetstream.flash.banner'))
            ->with('jetstream.flash.bannerStyle', session()->get('jetstream.flash.bannerStyle'));
    }

    public function assignNeedyRole(User $user, Request $request)
    {
        // check if user has needy role
        $needyValidate = User::role('needy')->where('id', $user->id)->exists();

        // check if user has admin role
        $adminValidate = User::role('admin')->where('id', $user->id)->exists();

        if ($needyValidate) {
            $request->session()->flash('jetstream.flash.banner', 'User already has needy role.');
            $request->session()->flash('jetstream.flash.bannerStyle', 'danger');

            return redirect()->route('admin.users');
        }

        if ($adminValidate) {
            $request->session()->flash('jetstream.flash.banner', 'User is an admin, cannot assigned to this role.');
            $request->session()->flash('jetstream.flash.bannerStyle', 'danger');

            return redirect()->route('admin.users');
        }

        // perform database insertion.
        $user->assignRole('needy');

        $request->session()->flash('jetstream.flash.banner', 'Needy role successfully assigned!');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('admin.users');
    }
}
