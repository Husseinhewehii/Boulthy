<?php

namespace App\Observers;

use App\Models\Promo;

class PromoObserver
{
    public function saving(Promo $promo)
    {
       if($promo->isGeneric()){
           $promo->user_id = null;
       }
    }
}
