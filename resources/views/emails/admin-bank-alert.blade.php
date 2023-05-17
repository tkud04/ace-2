<?php
 $totals = $order['totals'];
 $items = $order['items'];
 $itemCount = $totals['items'];
 $uu = "http://admin.aceluxurystore.com/confirm-payment?o=".$order['reference'];
 $cr = $order['courier'];
?>
<center><img src="http://www.aceluxurystore.com/images/logo.png" width="150" height="150"/></center>
<h3 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Bank payment request for order {{$order['reference']}}, paid via {{$order['type']}}</h3>
Hello admin,<br> please be informed that a new bank payment request has been received. See the details below:<br><br>
Reference #: <b>{{$order['reference']}}</b><br>
Customer: <b>{{$name}}</b><br>
Customer contact: <b>{{$phone}} | {{$user}}</b><br>
<?php
foreach($items as $i)
{
	$product = $i['product'];
	$sku = $product['sku'];
	$name = $product['name'];
	$qty = $i['qty'];
	$pu = url('product')."?sku=".$product['sku'];
	$img = $product['imggs'][0];
	
?>

<a href="{{$pu}}" target="_blank">
  <img style="vertical-align: middle;border:0;line-height: 20px;" src="{{$img}}" alt="{{$sku}}" height="80" width="80" style="margin-bottom: 5px;"/>
	  {{$name}}
</a> (x{{$qty}})<br>
<?php
}
?>
Total: <b>&#8358;{{number_format($order['amount'],2)}}</b><br><br>

<h6>Shipping Details</h6>
<p><b>{{$cr['name']}}</b> (&#8358;{{number_format($cr['price'],2)}})</p>
<p>Address: {{$shipping['address']}}</p>
<p>City: {{$shipping['city']}}</p>
<p>State: {{$shipping['state']}}</p><br><br>


<h5 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Next steps</h5>

<p>If the payment has been cleared, please click the button below to confirm the order. Alternatively you can follow up the customer.</p><br>
<p style="color:red;"><b>NOTE:</b> If the payment has not been cleared, do not confirm the order.</p><br><br>

<a href="{{$uu}}" target="_blank" style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Confirm this order</a><br><br>

