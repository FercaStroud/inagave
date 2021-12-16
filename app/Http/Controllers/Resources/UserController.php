<?php

namespace App\Http\Controllers\Resources;

use App\Price;
use App\Product;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Util\Utils;
use Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('id', 'desc')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        return response()->json($user, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();

        $this->validator($request, $user->id);

        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        $user->update($input);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    private function validator(Request $request, $id = null)
    {
        $emailValidation = 'required|max:191|email|unique:users';

        if (!empty($id)) {
            $emailValidation .= ',email,' . $id;
        }

        $request->validate([
            'name' => 'required|max:191',
            'email' => $emailValidation,
            'type_id' => 'required|integer|between:1,2',
            'password' => 'sometimes|min:6|confirmed',
        ], [
            'type_id.*' => __('users.invalid_user_type'),
        ]);
    }

    public function getUserStats()
    {
        try {
            $wallet_deposits = Wallet::where([
                ['user_id', '=', auth()->user()->id],
                ['type', '=', 'DEPOSIT'],
                ['bank', '=', 'USER'],
            ])->sum('amount');

            $wallet_withdraws = Wallet::where([
                ['user_id', '=', auth()->user()->id],
                ['type', '=', 'WITHDRAW'],
                ['status', '=', 'APPROVED'],
            ])->sum('amount');

            $products = Product::where('user_id', '=', auth()->user()->id)->get();
            $plantFounds = 0;

            foreach ($products as $key => $product) {
                $year = \Carbon\Carbon::parse($product->planted_at)->year;
                $price = Price::select('price')->where('year', '=', $year)->get();
                $plantFounds += (float)$price[0]->price * $product->quantity;
            }

            return response()->json([
                'total_plants' => $products->sum('quantity'),
                'total_user_founds' => (float)$wallet_deposits - (float)$wallet_withdraws,
                'total_plant_founds' => $plantFounds,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'total_plants' => 0,
                'total_user_founds' => 0,
                'total_plant_founds' => 0,
            ]);
        }
    }
}
