<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Address\AddressStore;
use App\Http\Requests\Client\Address\AddressUpdate;
use App\Http\Resources\Address\AddressResource;
use App\Models\Address;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStore $request)
    {
        $this->addressService->createAddress($request);
        return created_response($this->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return $address->belongsToThis(auth()->user()) ? ok_response(new AddressResource($address)) : forbidden_response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressUpdate $request, Address $address)
    {
        if(!$address->belongsToThis(auth()->user())){
            return forbidden_response();
        }

        $this->addressService->updateAddress($request, $address);
        return ok_response($this->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if(!$address->belongsToThis(auth()->user())){
            return forbidden_response();
        }
        $address->delete();
        return ok_response($this->all());
    }

    public function all()
    {
        return collectionFormat(AddressResource::class, auth()->user()->addresses()->paginate(10));
    }
}
