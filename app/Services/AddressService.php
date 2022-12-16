<?php

namespace App\Services;

use App\Models\Address;

class AddressService
{
    public function createAddress($request)
    {
        $address = Address::create($request->validated());
        return $address;
    }

    public function updateAddress($request, $address)
    {
        $address->update($request->validated());
        return $address;
    }
}
