<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Address\AddressStore;
use App\Http\Requests\Admin\Address\AddressUpdate;
use App\Http\Resources\Address\AddressResource;
use App\Models\Address;
use App\Repositories\Address\AddressRepository;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $addressRepository;
    protected $addressService;

    public function __construct(AddressRepository $addressRepository, AddressService $addressService) {
        $this->authorizeResource(Address::class, 'address');
        $this->addressRepository = $addressRepository;
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
        return ok_response(new AddressResource($address));
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
        $address->delete();
        return ok_response($this->all());
    }

    public function all()
    {
        return collectionFormat(AddressResource::class, $this->addressRepository->getAddresses());
    }
}
