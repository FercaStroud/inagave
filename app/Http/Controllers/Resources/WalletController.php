<?php

namespace App\Http\Controllers\Resources;

use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function index()
    {
        return Wallet::with('user')->get();
    }

    public function requestWithdraw(Request $request)
    {
        if ($request->has('app_user')) {
            $user = User::find($request->get('app_user'));
        } else {
            $user = User::find(auth()->user()->id);
        }

        $wallet = New Wallet();
        $wallet->user_id = $user->id;
        $wallet->parent_id = 0;
        $wallet->status = 'PENDING';
        $wallet->amount = (float)$request->get('amount');
        $wallet->bank = $request->get('bank');
        $wallet->account = $request->get('account');
        $wallet->type = 'WITHDRAW';
        $wallet->save();

        return response()->json($wallet);
    }

    public function approveRequest(Request $request)
    {
        $wallet = Wallet::find($request->get('id'));
        $wallet->status = 'APPROVED';
        $wallet->save();

        return response()->json($wallet);
    }

    public function getUserWallet(Request $request)
    {
        if ($request->has('app_user')) {
            $user = User::find($request->get('app_user'));
        } else {
            $user = User::find(auth()->user()->id);
        }

        $wallets = Wallet::where([
            ['user_id', '=', $user->id],
            ['parent_id', '=', 0],
        ])->with('user')->get();
        foreach ($wallets as $key => $wallet) {
            $wallets[$key]['transactions'] = Wallet::where('parent_id', '=', $wallets[0]->id)->get();
        }

        return $wallets;
    }

    public function update(Request $request, Wallet $wallet): JsonResponse
    {
        $request->validate([
            'status' => 'required',
        ]);

        tap($wallet)->update($request->all());

        $wallet->save();
        return response()->json($wallet, 201);
    }

    public function destroy(Wallet $wallet): JsonResponse
    {
        $wallet->delete();

        return response()->json(null, 204);
    }
}
