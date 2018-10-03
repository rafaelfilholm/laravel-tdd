<?php

namespace App\Observers;

use App\Account;

class AccountObserver
{
    /**
     * Handle the account "creating" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function creating(Account $account)
    {
        if(is_object($account->bank_image) and $account->bank_image->isValid())
        {
            $filename = $account->bank_image->getClientOriginalName();

            $account->bank_image->storeAs('images', $filename);
            $account->bank_image = $filename;
        }
    }

}
