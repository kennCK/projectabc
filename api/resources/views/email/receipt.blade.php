@component('email.header')
@endcomponent
<div class="holder">
    <span class="thank-you-header">
        <h1 style="line-height: 125px;">Thank you for your order, {{$user->username}}!</h1>
        <label><b>Order # {{$dataReceipt->order_number}}</b></label>
        <label>We've sent an email for your receipt and payment notification at {{$user->email}}.</label>
    </span>
    <span class="thank-you-item">
        <label><b>Summary</b></label>
    </span>
    <span class="thank-you-item">
        <label><b>Products</b></label>
        <label><b>Quantity</b></label>
        <label><b>Price</b></label>
    </span>
    @for($i = 0; $i < sizeof($data->templates); $i++)
        <span class="thank-you-item">
            <label>Template: {{$data->templates[$i]->template->title}}</label>
            <label>1</label>
            <label>{{$data->templates[$i]->price}}</label>
        </span>
    @endfor
    @if($dataReceipt['employees'] != null)
        <span class="thank-you-item">
            <label>ID's</label>
            <label>{{sizeof($dataReceipt['employees'])}}</label>
            <label>100</label>
        </span>
    @endif
    <span class="thank-you-item">
        <label></label>
        <label>Subtotal</label>
        <label class="pull-right" style="padding-right: 10px;">PHP {{$data->sub_total}}</label>
    </span>
    <span class="thank-you-item">
        <label></label>
        <label>Tax</label>
        <label class="pull-right" style="padding-right: 10px;">PHP {{$data->tax}}</label>
    </span>
    @if($dataReceipt['coupon'] != null)
        <span class="thank-you-item">
            <label>  </label>
            <label class="text-primary">
            <b>Promo Code</b>: 
                if($dataReceipt['coupon'] != null)
                    <b>{{$dataReceipt['coupon']['code']}}</b>
                @endif
                @if($dataReceipt['coupon'] != null && $dataReceipt['coupon']['type'] == 'percentage')
                    <b> (-{{$dataReceipt['coupon']['value']}}%)</b>
                @elseif($dataReceipt['coupon'] != null && $dataReceipt['coupon']['type'] == 'fixed_amount')
                    <b> (-{{$dataReceipt['coupon']['value']}})</b>
                @endif
            </label>
            <label class="pull-right">
                PHP {{$dataReceipt['discount']}}
            </label>
        </span>
    @endif
    <span class="thank-you-item">
        <label></label>
        <label><b>Total</b></label>
        <label class="pull-right" style="padding-right: 10px;"><b>PHP {{$data->total}}</b></label>
    </span>
    <span class="thank-you-item">
        <label></label>
        <label>Payment Method</label>
        @if($dataReceipt['method']['stripe'] != null)
            <label class="pull-right" style="padding-right: 10px;">
                <i class="fa fa-credit-card"></i>
                ********{{$dataReceipt['method']['stripe']['last4']}}
            </label>
        @elseif($dataReceipt['method']['payload'] == 'cod')
            <label class="pull-right" style="padding-right: 10px;">
                {{$dataReceipt['method']['payload_value']}}
            </label>
        @elseif($dataReceipt['method']['paypal'] != null)
            <label class="pull-right" style="padding-right: 10px;">
                <i class="fa fa-paypal"></i> {{$dataReceipt['method']['paypal']['email']}}
            </label>
        @endif
    </span>
</div>
@component('email.footer')
@endcomponent