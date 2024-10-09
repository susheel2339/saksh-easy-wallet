<?php

namespace Saksh\EasyWallet;

use App\Models\User;
use App\Models\Transaction;

class Wallet
{
public static function getBalance($userId, $currency)
{
$user = User::find($userId);
return $user ? $user->balances[$currency] ?? 0 : 0;
}

public static function credit($userId, $amount, $currency, $description = null)
{
$user = User::find($userId);
if ($user) {
$balances = $user->balances;
$balances[$currency] = ($balances[$currency] ?? 0) + $amount;
$user->balances = $balances;
$user->save();
self::recordTransaction($userId, $amount, 'credit', $currency, $description);
}
}

public static function debit($userId, $amount, $currency, $description = null)
{
$user = User::find($userId);
if ($user && ($user->balances[$currency] ?? 0) >= $amount) {
$balances = $user->balances;
$balances[$currency] -= $amount;
$user->balances = $balances;
$user->save();
self::recordTransaction($userId, $amount, 'debit', $currency, $description);
}
}

public static function recordTransaction($userId, $amount, $type, $currency, $description = null)
{
Transaction::create([
'user_id' => $userId,
'amount' => $amount,
'type' => $type,
'currency' => $currency,
'description' => $description,
]);
}
}
