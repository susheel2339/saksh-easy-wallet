# Saksh Easy Wallet

## Installation

```bash
composer require saksh/easy-wallet

Usage
use Saksh\EasyWallet\Wallet;

$balance = Wallet::getBalance($userId, 'USD');
Wallet::credit($userId, 100, 'USD', 'Initial deposit');
Wallet::debit($userId, 50, 'USD', 'Purchase'); 