@extends('layout')

@section('title',"Order Placed")

@section('content')
<script>
let cidcontents = [];
</script>
<?php
$uu = url('confirm-payment')."?oid=".$o['reference'];
$vu = url('anon-order')."?ref=".$o['reference'];
$amount = 0;
if(isset($o)) $amount = $o['amount'];

$items = $o['items'];

foreach($items as $i)
{
	$product = $i['product'];
	$sku = $product['sku'];
	$name = $product['name'];
	$qty = $i['qty'];
	$img = $product['imggs'][0];
?>
<script>
cidcontents.push({
      id: "{{$sku}}",
      quantity: "{{$qty}}"
    });
</script>
<?php
}
?>
<div class="row">
<div class="col-md-12">
<h3 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Order Placed Successfully</h3>

<b>Your order has been placed.</b><br>

<p>Redirecting.. <a href="{{$vu}}">Click here</a> if you are not redirected within 10 seconds.</p>
</div>
</div>
@stop


@section('scripts')
<script>
fbq('track', 'Purchase', {
	currency: "NGN",
	contents: cidcontents,
    content_type: 'product',
	value: "{{$amount}}"
	});

setTimeout(() => {
	window.location = "{{$vu}}";
},15000);
</script>
@stop