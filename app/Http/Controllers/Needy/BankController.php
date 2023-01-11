<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use Billplz\Laravel\Billplz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class BankController extends Controller
{
    public function index()
    {
        $banksName = Cache::remember('banks-name-code', 7200, function () {
            $banksName = BankDetail::select('code', 'name')->get();

            $banksNameArr = [];
            foreach ($banksName as $bank) {
                $banksNameArr[] = [$bank['code'], $bank['name']];
            }

            return $banksNameArr;
        });

        $banks = Bank::select([
            'id',
            'name_on_card',
            'account_number',
            'ic_number',
            'status'
        ])
            ->where('user_id', auth()->user()->id)
            ->get();

        return Inertia::render('Needy/Banks', [
            'banksName' => $banksName,
            'banks' => $banks
        ])
            ->with('jetstream.flash.banner', session()->get('jetstream.flash.banner'))
            ->with('jetstream.flash.bannerStyle', session()->get('jetstream.flash.bannerStyle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50'],
            'bankAccountNumber' => ['required', 'unique:banks,account_number', 'min:12', 'max:20'], // search how to validate number account
            'bankAccountIc' => ['required', 'min:12', 'max:12'], // search how to validate ic
            'bankCode' => ['required'],
        ]);

        $bankDetail = BankDetail::where('code', $request->bankCode)->first();

        Bank::create([
            'user_id' => $request->user()->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => $request->name,
            'ic_number' => $request->bankAccountIc,
            'account_number' => $request->bankAccountNumber,
            'status' => "pending"
        ]);

        Billplz::bank()->create(
            $request->name,
            $request->bankAccountIc,
            $request->bankAccountNumber,
            $request->bankCode,
            false
        );

        $request->session()->flash('jetstream.flash.banner', 'Bank account successfully added.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('needy.banks.index');
    }
}
