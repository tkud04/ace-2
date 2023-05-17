<?php
  $totals = $order['totals'];
 $items = $order['items'];
 $itemCount = $totals['items'];
  $uu = "http://www.aceluxurystore.com/track?o=".$order['reference'];
?>
<center><img src="http://www.aceluxurystore.com/images/logo.png" width="150" height="150"/></center>

<h3 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Your order reference # is #{{$order['reference']}}</h3>

Hello {{$name}},<br> You just placed an order via card. See the details below:<br><br>

Reference #: <b>{{$order['reference']}}</b><br>
Notes: <b>{{$order['notes']}}</b><br><br>
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

<h5 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Next steps</h5>

<p>Kindly click the button below to track your delivery. Alternatively you can log in to your Dashboard to track your order (go to Orders and click the Track button beside the order).<br> If you don't have an account you can simply click on <b>Orders</b> on our website and enter your order reference number (<b>{{$order['reference']}})</b></p><br>
<p style="color:red;"><b>NOTE:</b> Orders are delivered within 48 hours in Lagos.<br><br>Orders outside Lagos are delivered between 3 – 7 days.</p><br><br>

<a href="{{$uu}}" target="_blank" style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Track your order</a><br><br>

