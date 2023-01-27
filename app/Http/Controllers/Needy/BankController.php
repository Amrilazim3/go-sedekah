<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use Billplz\Laravel\Billplz;
use Exception;
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

    public function getIdAndAccountNumber()
    {
        $bankAccounts = [];

        $bankAccountsArr = Bank::select([
            'id',
            'user_id',
            'account_number'
        ])->where('user_id', auth()->user()->id)->get();

        foreach ($bankAccountsArr as $bank) {
            $bankAccounts[] = [$bank['id'], $bank['account_number']];
        }

        return $bankAccounts;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50'],
            'bankAccountNumber' => ['required', 'unique:banks,account_number', 'min:12', 'max:17'], // search how to validate number account
            'bankAccountIc' => ['required', 'min:12', 'max:12'], // search how to validate ic
            'bankCode' => ['required'],
        ]);

        $bankDetail = BankDetail::where('code', $request->bankCode)->first();

        try {
            Billplz::bank()->create(
                $request->name,
                $request->bankAccountIc,
                $request->bankAccountNumber,
                $request->bankCode,
                false
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(
                'Bank account number cannot be process with our third party api, maybe the number has been used or it does not matching the rule of the chosen bank name, please recheck your number.',
                'billplzError'
            );
        }

        Bank::create([
            'user_id' => $request->user()->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => $request->name,
            'ic_number' => $request->bankAccountIc,
            'account_number' => $request->bankAccountNumber,
            'status' => "pending"
        ]);

        $request->session()->flash('jetstream.flash.banner', 'Bank account successfully added.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('needy.banks.index');
    }

    public function destroy(Bank $bank, Request $request)
    {
        $bank->delete();

        $request->session()->flash('jetstream.flash.banner', 'Bank account successfully deleted.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('needy.banks.index');
    }
}
