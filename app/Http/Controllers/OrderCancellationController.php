<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancellation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderCancellationController extends Controller
{
    /**
     * Cancel an order
     */
    public function cancel(Request $request, Order $order): RedirectResponse
    {
        // Check if user is authorized to cancel this order
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized to cancel this order.');
        }

        // Custom validation with better handling
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:255',
            'custom_cancellation_reason' => 'nullable|string|max:500',
            'additional_comments' => 'nullable|string|max:1000',
        ]);

        // Add conditional validation for custom reason
        $validator->sometimes('custom_cancellation_reason', 'required', function ($input) {
            return $input->cancellation_reason === 'other';
        });

        if ($validator->fails()) {
            // Redirect to cancellation form instead of back()
            return redirect()->route('buyer.orders.request-cancel', $order->id)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Check if order can be cancelled
        if (!$this->canCancelOrder($order)) {
            // Redirect to my account page with error
            return redirect()->route('settings.orders')
                ->with('error', 'This order cannot be cancelled at this time.');
        }

        try {
            // Update order status using model
            $order->update([
                'order_status' => 'cancelled',
                'delivery_status' => 'cancelled',
                'payment_status' => 'failed',
            ]);
            // Create cancellation record using model
            $order->cancellation()->create([
                'cancelled_by_user_id' => Auth::id(),
                'cancellation_reason' => $validated['cancellation_reason'],
                'custom_cancellation_reason' => $validated['custom_cancellation_reason'] ?? null,
                'additional_comments' => $validated['additional_comments'] ?? null,
                'cancelled_by_role' => $this->getUserRole($order),
                'cancelled_at' => now(),
            ]);

            // Handle refund logic if needed
            $this->processRefundIfNeeded($order);

            // Send notifications
            $this->sendCancellationNotifications($order);

            // Redirect to my account page with success message
            return redirect()->route('settings.orders')
                ->with('success', 'Order #' . $order->id . ' has been cancelled successfully.');

        } catch (\Exception $e) {
            Log::error('Order cancellation failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            // Redirect to cancellation form with error
            return redirect()->route('buyer.orders.request-cancel', $order->id)
                ->with('error', 'Failed to cancel order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show cancellation form
     */
    public function show(Order $order)
    {
        // Check if user is authorized to view this order
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized to view this order.');
        }

        // Check if order can be cancelled
        if (!$this->canCancelOrder($order)) {
            return redirect()->back()->with('error', 'This order cannot be cancelled at this time.');
        }

        return view('buyer.request-order-cancel', compact('order'));
    }

    public function sellerCancel(Request $request, Order $order): RedirectResponse
    {
        // Check if user is authorized to cancel this order
        if ($order->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized to cancel this order.');
        }

        // Custom validation with better handling
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:255',
            'custom_cancellation_reason' => 'nullable|string|max:500',
            'additional_comments' => 'nullable|string|max:1000',
        ]);

        // Add conditional validation for custom reason
        $validator->sometimes('custom_cancellation_reason', 'required', function ($input) {
            return $input->cancellation_reason === 'other';
        });

        if ($validator->fails()) {
            // Redirect to cancellation form instead of back()
            return redirect()->route('buyer.order-cancel', $order->id)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Check if order can be cancelled
        if (!$this->canCancelOrder($order)) {
            // Redirect to my account page with error
            return redirect()->route('seller.orders.index')
                ->with('error', 'This order cannot be cancelled at this time.');
        }

        try {
            // Update order status using model
            $order->update([
                'order_status' => 'cancelled',
                'delivery_status' => 'cancelled',
                'payment_status' => 'failed',
            ]);

            // Create cancellation record using model
            $order->cancellation()->create([
                'cancelled_by_user_id' => Auth::id(),
                'cancellation_reason' => $validated['cancellation_reason'],
                'custom_cancellation_reason' => $validated['custom_cancellation_reason'] ?? null,
                'additional_comments' => $validated['additional_comments'] ?? null,
                'cancelled_by_role' => $this->getUserRole($order),
                'cancelled_at' => now(),
            ]);

            // Handle refund logic if needed
            $this->processRefundIfNeeded($order);

            // Send notifications
            $this->sendCancellationNotifications($order);

            // Redirect to my account page with success message
            return redirect()->route('seller.orders.index')
                ->with('success', 'Order #' . $order->id . ' has been cancelled successfully.');

        } catch (\Exception $e) {
            Log::error('Order cancellation failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            // Redirect to cancellation form with error
            return redirect()->route('orders.request-cancel', $order->id)
                ->with('error', 'Failed to cancel order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show cancellation form
     */
    public function sellerShow(Order $order)
    {
        // Check if user is authorized to view this order
        if ($order->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized to view this order.');
        }

        // Check if order can be cancelled
        if (!$this->canCancelOrder($order)) {
            return redirect()->back()->with('error', 'This order cannot be cancelled at this time.');
        }

        return view('seller.order-cancel', compact('order'));
    }

    /**
     * Check if an order can be cancelled
     */
    private function canCancelOrder(Order $order): bool
    {
        // Order is already cancelled
        if ($order->isCancelled()) {
            return false;
        }

        // Define cancellable statuses
        $cancellableStatuses = ['pending', 'confirmed', 'processing'];
        
        // Check if order status allows cancellation
        if (!in_array($order->order_status, $cancellableStatuses)) {
            return false;
        }

        // Check if payment status allows cancellation
        if ($order->payment_status === 'refunded') {
            return false;
        }

        // Check if delivery has started (optional business rule)
        $nonCancellableDeliveryStatuses = ['shipped', 'out_for_delivery', 'delivered'];
        if (in_array($order->delivery_status, $nonCancellableDeliveryStatuses)) {
            return false;
        }

        return true;
    }

    /**
     * Get user role for the order
     */
    private function getUserRole(Order $order): string
    {
        $userId = Auth::id();
        
        if ($order->buyer_id === $userId) {
            return 'buyer';
        } elseif ($order->seller_id === $userId) {
            return 'seller';
        }
        
        return 'unknown';
    }

    /**
     * Process refund if needed
     */
    private function processRefundIfNeeded(Order $order): void
    {
        // Only process refund if payment was completed
        if ($order->payment_status === 'completed') {
            // Update payment status to indicate refund is processing
            $order->update([
                'payment_status' => 'refund_pending'
            ]);

            // Here you would integrate with your payment processor
            // For example, Stripe, PayPal, etc.
            // $this->initiateRefund($order);
            
            // For now, we'll just log it
            \Log::info('Refund initiated for cancelled order', [
                'order_id' => $order->id,
                'amount' => $order->total
            ]);
        }
    }

    /**
     * Send cancellation notifications
     */
    private function sendCancellationNotifications(Order $order): void
    {
        try {
            // Notify seller about cancellation
            // You can use Laravel notifications here
            // $order->seller->notify(new OrderCancelledNotification($order));
            
            // Notify buyer about successful cancellation
            // $order->buyer->notify(new OrderCancellationConfirmationNotification($order));
            
            // For now, we'll just log it
            \Log::info('Cancellation notifications sent', [
                'order_id' => $order->id,
                'buyer_id' => $order->buyer_id,
                'seller_id' => $order->seller_id
            ]);
            
        } catch (\Exception $e) {
            // Log notification failures but don't break the cancellation process
            \Log::error('Failed to send cancellation notifications: ' . $e->getMessage(), [
                'order_id' => $order->id
            ]);
        }
    }
}