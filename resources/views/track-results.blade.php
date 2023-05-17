@extends('layout')

@section('title',"Track Your Order")

@section('styles')
  <!-- DataTables CSS -->
  <link href="lib/datatables/css/buttons.bootstrap.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" /> 
@stop


@section('content')
   <!--start of middle sec-->
<div class="middle-sec wow fadeIn animated animated" data-wow-offset="10" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s;">
    <div class="page-header">
      <div class="container text-center">
        <h2 class="text-primary text-uppercase">Tracking order #{{$r}}</h2>
      </div>
    </div>
    <section class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="inner-ad">
                <figure>
                  <figure><img class="img-responsive" src="{{$ad}}" width="1170" height="100" alt=""></figure>
                </figure>
              </div>
            </div>
            <div class="col-sm-12">
              <ol class="breadcrumb dashed-border row">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">track your order</li>
              </ol>
            </div>
            <!--start of columns-->
            <div class="col-sm-12">
              <div class="row extra-btm-padding">
                <div class="table-responsive m-t-40 wow fadeInUp">
                	   <table class="table ace-table">
				   <thead>
                        <tr>
                                    <th>Date</th>
                                    <th>Status</th>                                                                       
                                    <th>Description</th>                                                                       
                                </tr>
                       </thead>
					<tbody>
					<?php
					  if(count($trackings) > 0)
					  {
						 foreach($trackings as $t)
						 {
				    ?>
					 <tr>
					   <td>{{$t['date']}}</td>
					   <td>{{$t['status']}}</td>
					   <td>{{strtoupper($t['description'])}}</td>
					 </tr>
					<?php
						 }  
					  }
					  else
					  {
						  $descc = "Your order is being processed and will be dispatched soon.";
						  if($paidStatus == "unpaid") $descc = "We are yet to receive payment for your order. Please ensure to add your reference number <b>$r</b> if you are paying via bank transfer.<br><br>If you have made payment please be patient your order will be processed as soon as your payment is cleared.";
				    ?>
					<tr>
					   <td>{{date("jS F Y h:i A")}}</td>
					   <td><span style="color: red;">Pending</span></td>
					   <td>{!!$descc!!}</td>
					 </tr>
					<?php
					  }
                    ?>						  
					</tbody>
				  </table>
				</div>
              </div>
            
            </div>
            <!--start of columns--> 
          </div>
        </div>
      </div>
	  <div class="row">
         <div class="col-sm-12">
		   @if(count($o) > 0)
			   <h3 class="mb-2">Your Order</h3>
			   <div class="table-responsive m-t-40 wow fadeInUp">
                 <table class="table ace-table">
				   <thead>
                        <tr>
                                    <th>Reference #</th>
                                    <th>Items</th>
                                    <th>Amount</th>                                                    
                                </tr>
                       </thead>
					<tbody>
					<?php
					  $items = isset($o['items']) ? $o['items'] : [];
					  $totals = $o['totals'];
					?>
					<tr>
					   <td>{{$o['reference']}}</td>
					   <td>
						<?php
						 if(count($items) > 0)
						 {
						 foreach($items as $i)
						 {
							   $product = $i['product'];
							   $sku = $product['sku'];
							   $name = $product['name'];
							   $pu = url('product')."?sku=".$product['sku'];
							   $img = $product['imggs'][0];
							 
							 $qty = $i['qty'];
						 ?>
						 
						 <a href="{{$pu}}" target="_blank">
						   <img class="img img-fluid" src="{{$img}}" alt="{{$sku}}" height="80" width="80" style="margin-bottom: 5px;"/>
							   {{$name}}
						 </a> (x{{$qty}})<br>
						 <?php
						 }
						 }
						?>
					   </td>
					   <td>&#8358;{{number_format($o['amount'],2)}}</td>
					</tr>
					</tbody>
                 </table>
               </div>				 
		   @endif
         </div>
	  </div>
    </section>
  </div>
  <!--end of middle sec--> 
    
@stop

@section('scripts')
    <!-- DataTables js -->
       <script src="lib/datatables/js/datatables.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="lib/datatables/js/datatables-init.js"></script>
@stop