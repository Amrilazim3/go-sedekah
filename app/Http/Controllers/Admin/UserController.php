<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Admin\Role\AdminRoleAdded;
use App\Notifications\Admin\Role\NeedyRoleAdded;
use App\Notifications\Admin\Role\NeedyRoleRemoved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::select(['id', 'name', 'email'])
            ->role('admin')
            ->paginate(13, ['*'], 'admins');
        $donors = User::select(['id', 'name', 'email'])
            ->role('donor')
            ->paginate(13, ['*'], 'donors');
        $needy = User::select(['id', 'name', 'email'])
            ->role('needy')
            ->paginate(13, ['*'], 'needy');

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
        $needyValidate = User::role('needy')->where('id', $user->id)->exists();

        $adminValidate = User::role('admin')->where('id', $user->id)->exists();

        if ($needyValidate) {
            $request->session()->flash('jetstream.flash.banner', 'User already has needy role.');
            $request->session()->flash('jetstream.flash.bannerStyle', 'danger');

            return redirect()->route('admin.users.index');
        }

        if ($adminValidate) {
            $request->session()->flash('jetstream.flash.banner', 'User is an admin, cannot assigned to this role.');
            $request->session()->flash('jetstream.flash.bannerStyle', 'danger');

            return redirect()->route('admin.users.index');
        }

        $user->assignRole('needy');

        Notification::send($user, new NeedyRoleAdded);

        $request->session()->flash('jetstream.flash.banner', 'Needy role successfully assigned!');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('admin.users.index');
    }

    public function removeNeedyRole(User $user, Request $request)
    {
        $user->removeRole('needy');

        Notification::send($user, new NeedyRoleRemoved);

        $request->session()->flash('jetstream.flash.banner', 'Needy role successfully removed!');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('admin.users.index');
    }

    public function assignAdminRole(User $user, Request $request)
    {
        $needyValidate = User::role('needy')->where('id', $user->id)->exists();

        $adminValidate = User::role('admin')->where('id', $user->id)->exists();

        if ($needyValidate) {
            $request->session()->flash('jetstream.flash.banner', 'User is an needy, cannot assigned to this role.');
            $request->session()->flash('jetstream.flash.bannerStyle', 'danger');

            return redirect()->route('admin.users.index');
        }

        if ($adminValidate) {
            $request->session()->flash('jetstream.flash.banner', 'User is already an admin.');
            $request->session()->flash('jetstream.flash.bannerStyle', 'danger');

            return redirect()->route('admin.users.index');
        }

        $user->assignRole('admin');

        Notification::send(
            $user, new AdminRoleAdded
        );

        $request->session()->flash('jetstream.flash.banner', 'Admin role successfully assigned!');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('admin.users.index');
    }

    public function removeAdminRole(User $user, Request $request)
    {
        $user->removeRole('admin');

        $request->session()->flash('jetstream.flash.banner', 'Admin role successfully removed!');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('admin.users.index');
    }
}
