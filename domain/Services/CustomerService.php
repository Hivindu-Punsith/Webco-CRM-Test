<?php

namespace domain\Services;

use App\Models\Customer;

class CustomerService
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        return $this->customer->with('addresses')->get();
    }

    /**
     * get
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        return $this->customer->with('addresses')->find($id);
    }

    public function create($data)
    {
        // Save customer
        $customer = $this->customer->create([
            'name' => $data['name'],
            'company' => $data['company'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'country' => $data['country'],
        ]);

        // Save Addresses
        foreach ($data['addresses'] as $address) {
            $customer->addresses()->create([
                'address_no' => $address['address_no'],
                'street' => $address['street'],
                'city' => $address['city'],
                'state' => $address['state'],
                'country' => $address['country'],
                'zip_code' => $address['zip_code'],
            ]);
        }

        return $customer->load('addresses');
    }

    public function update($data, $customer)
    {
        // Update customer
        $customer->update([
            'name' =>  $data['name'],
            'company' => $data['company'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'country' => $data['country']
        ]);

        // Get the current addresses IDs for the customer
        $currentAddressIds = $customer->addresses->pluck('id')->toArray();

        // Loop through the provided addresses and update or create new ones
        $newAddressIds = [];
        foreach ($data['addresses'] as $address) {
            if (isset($address['id']) && in_array($address['id'], $currentAddressIds)) {
                // Update existing address
                $customer->addresses()->where('id', $address['id'])->update([
                    'address_no' => $address['address_no'],
                    'street' => $address['street'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'country' => $address['country'],
                    'zip_code' => $address['zip_code'],
                ]);
                $newAddressIds[] = $address['id'];
            } else {
                // Create new address
                $newAddress = $customer->addresses()->create([
                    'address_no' => $address['address_no'],
                    'street' => $address['street'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'country' => $address['country'],
                    'zip_code' => $address['zip_code'],
                ]);
                $newAddressIds[] = $newAddress->id;
            }
        }

        // Delete addresses that are not present in the updated request
        $customer->addresses()->whereNotIn('id', $newAddressIds)->delete();

        return $customer;
    }

    public function destroy($customer)
    {
        $customer->delete();
    }
}
