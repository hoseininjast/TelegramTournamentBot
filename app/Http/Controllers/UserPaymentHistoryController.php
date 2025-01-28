<?php

namespace App\Http\Controllers;

use App\Models\UserPaymentHistory;
use Illuminate\Http\Request;

class UserPaymentHistoryController extends Controller
{
    public function index()
    {
        return UserPaymentHistory::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            's' => ['nullable'],
        ]);

        return UserPaymentHistory::create($data);
    }

    public function show(UserPaymentHistory $userPaymentHistory)
    {
        return $userPaymentHistory;
    }

    public function update(Request $request, UserPaymentHistory $userPaymentHistory)
    {
        $data = $request->validate([
            's' => ['nullable'],
        ]);

        $userPaymentHistory->update($data);

        return $userPaymentHistory;
    }

    public function destroy(UserPaymentHistory $userPaymentHistory)
    {
        $userPaymentHistory->delete();

        return response()->json();
    }
}
