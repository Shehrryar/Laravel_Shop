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
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Services\OrderService;
use App\Mail\OrderEmail;
use App\Events\OrderPlacedNotificationEvent;
class PaymentController extends Controller
{
    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        // Validate payment method
        if (!in_array($request->paymentMethod, ['cod', 'card', 'Paypal'])) {
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

                $config = $this->setPaypalConfig();
                $provider = new PayPalClient($config);
                $provider->getAccessToken();

                $orderId = session()->get('order_id');
                $grandTotal = session()->get('grand_total');


                $response = $provider->createOrder([
                    'intent' => 'CAPTURE',
                    'application_context' => [
                        'return_url' => route('paypal.success'),
                        'cancel_url' => route('paypal.cancel'),
                    ],
                    'purchase_units' => [
                        [
                            'reference_id' => $orderId,
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => $grandTotal
                            ]
                        ]
                    ]
                ]);

                if (!isset($response['id'])) {
                    return response()->json([
                        'status' => false,
                        'message' => $response['error']['message'] ?? 'Unable to create PayPal order'
                    ], 500);
                }

                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return response()->json([
                            'status' => true,
                            'message' => 'PayPal session created',
                            'url' => $link['href']
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'PayPal approval link not found'
                ], 500);
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



    function setPaypalConfig(): array
    {
        $config = [
            'mode' => env('PAYPAL_MODE', 'sandbox'), // 'sandbox' or 'live'
            'sandbox' => [
                'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
                'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
                'app_id' => env('PAYPAL_SANDBOX_APP_ID', 'APP-80W284485P519543T'),
            ],
            'live' => [
                'client_id' => env('PAYPAL_LIVE_CLIENT_ID', ''),
                'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
                'app_id' => env('PAYPAL_LIVE_APP_ID', ''),
            ],
            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // 'Sale', 'Authorization' or 'Order'
            'currency' => env('PAYPAL_CURRENCY', 'USD'),
            'notify_url' => env('PAYPAL_NOTIFY_URL', ''),
            'locale' => env('PAYPAL_LOCALE', 'en_US'), // e.g., it_IT, es_ES, en_US
            'validate_ssl' => env('PAYPAL_VALIDATE_SSL', true),
        ];
        return $config;
    }



    function payWithPaypal()
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        /** calculate payable amount */
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.paypal_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('gatewaySettings.paypal_currency'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != NULL) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

    function paypalSuccess(Request $request, OrderService $orderService)
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);


        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $orderId = session()->get('order_id');

            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'currency' => $capture['amount']['currency_code'],
                'status' => 'completed'
            ];
            /** Clear session data */
            $orderService->clearSession();

            return redirect()->route('payment.success');
        } else {
            $this->transactionFailUpdateStatus('PayPal');
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

    function paypalCancel()
    {
        $this->transactionFailUpdateStatus('PayPal');
        return redirect()->route('payment.cancel');
    }



}