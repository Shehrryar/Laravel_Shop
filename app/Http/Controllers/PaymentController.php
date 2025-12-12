<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Coupon;
use Stripe\Stripe;
// use App\Jobs\SendOrderPlacedMail;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

use App\Events\OrderCreatedEvent;
use App\Events\OrderPaymentUpdateEvent;
use App\Services\OrderService;
use App\Mail\OrderEmail;



use App\Events\OrderPlacedNotificationEvent;
class PaymentController extends Controller
{
    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        // Validate payment method
        if (!in_array($request->paymentMethod, ['cod', 'card'])) {
            return response()->json(['status' => false, 'message' => 'Invalid payment method.']);
        }
        // Get default address
        $customerAddress = CustomerAddress::where('user_id', $user->id)
            ->where('is_default', 1)
            ->first();
        if (!$customerAddress) {
            return response()->json([
                'status' => false,
                'message' => 'No default address found. Please set one before proceeding to checkout.',
            ]);
        }
        // Get user cart
        $cartItems = Cart::where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Your cart is empty.',
            ]);
        }

        $orderService = new OrderService();
        $order = $orderService->createOrder($user, $cartItems, $request, $customerAddress);


        $orderId = session()->get('order_id');

        $order = Order::find($orderId);

        // Mail::to($order->email)->send(new OrderEmail($order));

        // event(new OrderPlacedNotificationEvent(Order::find($orderId)));

        if ($order == true) {
            if ($request->paymentMethod === 'cod') {
                // event(new OrderPlacedNotificationEvent($order));
                $orderId = session()->get('order_id');
                $paymentInfo = [
                    'transaction_id' => "",
                    // 'amount' => $session->amount_total,
                    'status' => 'pending'
                ];
                event(new OrderPaymentUpdateEvent($orderId, $paymentInfo, 'COD'));
                $orderService->clearSession();
                return response()->json([
                    'status' => true,
                    'message' => 'Order placed successfully (COD)!',
                    'orderId' => $orderId
                ]);
            } elseif ($request->paymentMethod === 'card') {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $orderId = session()->get('order_id');
                $grandTotal = session()->get('grand_total');

                $session = Session::create([
                    'payment_method_types' => ['card'],

                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => ['name' => 'Order #' . $orderId],
                                'unit_amount' => intval($grandTotal) * 100,
                            ],
                            'quantity' => 1,
                        ]
                    ],

                    'mode' => 'payment',
                    'success_url' => route('front.stripeSuccess') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('stripe.cancel'),
                    'metadata' => [
                        'order_id' => $orderId,
                        'user_id' => $user->id
                    ]
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Stripe session created',
                    'url' => $session->url
                ]);
            } elseif ($request->paymentMethod === 'Paypal') {

            }
        }
    }
    // STRIPE SUCCESS CALLBACK
    public function stripeSuccess(Request $request)
    {
        $sessionId = $request->session_id;
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($sessionId);
        if ($session->payment_status === 'paid') {
            $orderId = $session->metadata->order_id;
            $paymentInfo = [
                'transaction_id' => $session->payment_intent,
                // 'amount' => $session->amount_total,
                'status' => 'completed'
            ];
            event(new OrderPaymentUpdateEvent($orderId, $paymentInfo, 'Stripe'));

            $orderService = new OrderService();
            $orderService->clearSession();
            // event(new OrderPlacedNotificationEvent(Order::find($orderId)));
            return redirect()->route('front.orderPlaced');
        }
        return redirect()->route('stripe.cancel');
    }


    function stripeCancel()
    {
        $this->transactionFailUpdateStatus('Stripe');
        return redirect()->route('front.payment');
    }
    function transactionFailUpdateStatus($gatewayName): void
    {
        $orderId = session()->get('order_id');
        $paymentInfo = [
            'transaction_id' => '',
            // 'currency' => '',
            'status' => 'Failed'
        ];

        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    }

}
