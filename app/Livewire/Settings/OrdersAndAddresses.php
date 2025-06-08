<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderCancellation;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class OrdersAndAddresses extends Component
{
    use WithPagination;

    public $ordersCount = 0;
    public $reviewsCount = 0;
    public $selectedAddressId = null;

    // Address form properties
    public $showAddAddressModal = false;
    public $editingAddress = null;
    public $addressForm = [
        'address_line_1' => '',
        'address_line_2' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
        'country' => '',
        'is_default' => false,
    ];

    protected $rules = [
        'addressForm.address_line_1' => 'required|string|max:255',
        'addressForm.address_line_2' => 'nullable|string|max:255',
        'addressForm.city' => 'required|string|max:100',
        'addressForm.state' => 'required|string|max:100',
        'addressForm.postal_code' => 'required|string|max:20',
        'addressForm.country' => 'required|string|max:100',
        'addressForm.is_default' => 'boolean',
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $user = Auth::user();
        $this->ordersCount = $user->orders()->count() ?? 0;
        $this->reviewsCount = $user->reviews()->count() ?? 0;
    }

    public function selectAddress($addressId)
    {
        $this->selectedAddressId = $addressId;
        session(['selected_delivery_address' => $addressId]);
        $this->dispatch('address-selected', $addressId);
    }

    public function openAddAddressModal()
    {
        $this->resetAddressForm();
        $this->showAddAddressModal = true;
    }

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

        $latestOrders = $user->orders()
            ->latest()
            ->paginate(5, ['*'], 'orders_page');

        $latestCancelledOrders = OrderCancellation::where('cancelled_by_user_id', $user->id)
            ->latest()
            ->paginate(5, ['*'], 'cancelled_orders_page');

        return view('livewire.settings.orders-and-addresses', [
            'deliveryAddresses' => $deliveryAddresses,
            'latestOrders' => $latestOrders,
            'latestCancelledOrders' => $latestCancelledOrders,
        ]);
    }
}