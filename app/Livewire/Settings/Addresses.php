<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderCancellation;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class Addresses extends Component
{
    use WithPagination;

    protected $rules = [
        'addressForm.address_line_1' => 'required|string|max:255',
        'addressForm.address_line_2' => 'nullable|string|max:255',
        'addressForm.city' => 'required|string|max:100',
        'addressForm.state' => 'required|string|max:100',
        'addressForm.postal_code' => 'required|string|max:20',
        'addressForm.country' => 'required|string|max:100',
        'addressForm.is_default' => 'boolean',
    ];

    public function saveAddress()
    {
        $this->validate();

        $user = Auth::user();
        
        $user->deliveryAddresses()->create($this->addressForm);

        $this->closeAddAddressModal();
        session()->flash('success', 'Address added successfully!');
        $this->dispatch('address-added');
    }

    public function updateAddress()
    {
        $this->validate();

        if ($this->editingAddress) {
            $this->editingAddress->update($this->addressForm);
            $this->closeEditAddressModal();
            session()->flash('success', 'Address updated successfully!');
            $this->dispatch('address-updated');
        }
    }

    public function deleteAddress($addressId)
    {
        $user = Auth::user();
        $address = $user->deliveryAddresses()->where('id', $addressId)->first();

        if ($address) {
            $address->delete();
            session()->flash('success', 'Address deleted successfully!');
            $this->dispatch('address-deleted');
        }
    }

    private function resetAddressForm()
    {
        $this->addressForm = [
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'country' => '',
            'is_default' => false,
        ];
        $this->resetValidation();
    }

    public function render()
    {
        $user = Auth::user();
        
        $deliveryAddresses = $user->deliveryAddresses()
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'addresses_page');

        return view('livewire.settings.addresses', [
            'deliveryAddresses' => $deliveryAddresses,
        ]);
    }
}