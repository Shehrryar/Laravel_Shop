@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <form action="" id="order_form" method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="firstname" id="firstname" class="form-control"
                                            placeholder="First Name" value = "{{!empty($customerAddress) ? $customerAddress->firstname : ''}}" >
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="lastname" id="lastname" class="form-control"
                                            placeholder="Last Name" value="{{!empty($customerAddress) ? $customerAddress->lastname : ''}}" >
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control"
                                            placeholder="Email" value="{{!empty($customerAddress) ? $customerAddress->email : ''}}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select a Country</option>
                                            @if ($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                    <option {{!empty($customerAddress) &&  $customerAddress->country_id ==  $country->id? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address"
                                            class="form-control">{{!empty($customerAddress) ? $customerAddress->address : ''}}</textarea>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" id="apartment" class="form-control"
                                            placeholder="Apartment, suite, unit, etc. (optional)" value="{{!empty($customerAddress) ? $customerAddress->apartment : ''}}" >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control"
                                            placeholder="City" value="{{!empty($customerAddress) ? $customerAddress->city : ''}}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control"
                                            placeholder="State" value="{{!empty($customerAddress) ? $customerAddress->state : ''}}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{!empty($customerAddress) ? $customerAddress->zip : ''}}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control"
                                            placeholder="Mobile No." value="{{!empty($customerAddress) ? $customerAddress->mobile : ''}}">
                                        <p></p>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2"
                                            placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">

                            @foreach (Cart::content() as $item)

                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                    <div class="h6">{{$item->price * $item->qty}}</div>
                                </div>

                            @endforeach

                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="shipping_charges">${{$total_shipping}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grand_total">${{(float)Cart::subtotal() + (float)$total_shipping}}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="card payment-form ">
                        <h3 class="card-title h5 mb-3">Payment Details</h3>

                        <div class="">
                            <input checked type="radio" name='payment_method' value='cod' onclick="payment_method_1()"
                                id='payment_method_1'>
                            <label class="form-check-label" for="payment_method">COD</label>
                        </div>

                        <div class="">
                            <input type="radio" name='payment_method' value='cod' onclick="payment_method_1()"
                                id='payment_method_2'>
                            <label class="form-check-label" for="payment_method">Stripe</label>
                        </div>


                        <div class="card-body p-0 d-none" id='card-payment-form'>
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number"
                                    class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <!-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> -->
                            <button class="btn-dark btn btn-block w-100" type="submit">Pay Now</button>
                        </div>
                    </div>


                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('customJs')
<script>

    $('#payment_method_1').click(function () {
        if ($(this).is(":checked")) {
            $("#card-payment-form").addClass('d-none');
        }
    });

    $('#payment_method_2').click(function () {
        if ($(this).is(":checked")) {
            $("#card-payment-form").removeClass('d-none');
        }
    });

    $('#order_form').submit(function () {
        event.preventDefault();
        $.ajax({
            url: '{{route('front.processCheckout')}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                if (response.status == false) {
                    var errors = response.errors;
                    if (errors.first_name) {
                        $('#firstname').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.firstname);
                    } else {
                        $('#firstname').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }

                    if (errors.lastname) {
                        $('#lastname').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.lastname);
                    } else {
                        $('#lastname').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.email) {
                        $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                    } else {
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.country) {
                        $('#country').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.country);
                    } else {
                        $('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.address) {
                        $('#address').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.address);
                    } else {
                        $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.city) {
                        $('#city').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.city);
                    } else {
                        $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.state) {
                        $('#state').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.state);
                    } else {
                        $('#state').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.zip) {
                        $('#zip').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.zip);
                    } else {
                        $('#zip').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if (errors.mobile) {
                        $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.mobile);
                    } else {
                        $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                } 
                else{
                    window.location.href = "{{ route('front.home') }}";
                    
                }
            }
        });
    });

    $("#country").change(function(){
        $.ajax({
            url:'{{route('front.getOrderSummary')}}',
            type:'post',
            data:{
                country_id:$(this).val()
            },
            dataType:'json',
            success:function(response){
                if(response.status == true){
                    $('#shipping_charges').html(response.shipping_charge);
                    $('#grand_total').html(response.grand_total);

                }
            }
        });
    });


</script>
@endsection