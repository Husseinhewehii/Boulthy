<?php

namespace App\Services;

use App\Constants\PromoTypes;
use App\Models\Promo;
use DateTime;

class PromoService
{
    public function createPromo($request)
    {
        $promo = Promo::create($request->validated());
        return $promo;
    }

    public function updatePromo($request, $promo)
    {
        $promo->update($request->validated());
        return $promo;
    }

    public function createPromoForNewUser($user)
    {
        $promo = new Promo();
        $promo->user_id = $user->id;

        $promo->name = $user->name." "."($user->id)"." ".get_static_content("clientregistrationpromoname");
        $promo->short_description = get_static_content("clientregistrationpromoshortdescription");
        $promo->description = get_static_content("clientregistrationpromodescription");
        $promo->percentage = get_setting("clientregistrationpromopercentage");
        $promo->code = generate_valid_unique_code(Promo::class, "code", constant("valid_promo_characters"), constant("default_promo_length"), constant("valid_promo_regex"));

        $promo->start_date = $user->email_verified_at;
        $promo->end_date = new DateTime($promo->start_date. "+ ".get_setting("clientregistrationpromotime")." seconds");
        $promo->type = PromoTypes::EXCLUSIVE;

        $promo->save();
        return $promo;
    }
}
