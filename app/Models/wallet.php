<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallet extends Model
{
    use HasFactory;
    protected $table = 'wallet_manager';
    protected $fillable = [
        'user_id',
        'balance',
        'status',
    ];

    public function credit($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    public function debit($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }

    public function validate_order($amount) {}
}
