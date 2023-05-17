@extends('layout')

@section('title',"Verify Payment")

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
        <h2 class="text-primary text-uppercase">your orders</h2>
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
                <li class="active">your orders</li>
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
                                    <th>Reference #</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Payment code</th>
                                    <th>Status</th>                                                                       
                                    <th>Actions</th>                                                                       
                                </tr>
                       </thead>
					<tbody>
					<?php
					  if(count($orders) > 0)
					  {
						 foreach($orders as $o)
						 {
							 $items = $o['items'];
							 $totals = $o['totals'];
							 $statusClass = $o['status'] == "paid" ? "success" : "danger";
							 $uu = "#";
				    ?>
					 <tr>
					   <td>{{$o['date']}}</td>
					   <td>{{$o['reference']}}</td>
					    <td>
						<?php
						 foreach($items as $i)
						 {
							 $product = $i['product'];
							 $qty = $i['qty'];
							 $pu = url('product')."?sku=".$product['sku'];
							 $tru = url('track')."?o=".$o['reference'];
							 $iu = url('receipt')."?r=".$o['reference'];
						 ?>
						 <a href="{{$pu}}" target="_blank">{{$product['sku']}}</a> (x{{$qty}})<br>
						 <?php
						 }
						?>
					   </td>
					   <td>&#8358;{{number_format($o['amount'],2)}}</td>		  
					   <td>{{$o['payment_code']}}</td>
					   <td><span class="label label-{{$statusClass}}">{{strtoupper($o['status'])}}</span></td>
					   <td>
					     <a class="btn btn-primary" href="{{$tru}}">Track</span>
					     <a class="btn btn-info" href="{{$iu}}" target="_blank">Receipt</span>
					   </td>
					 </tr>
					<?php
						 }  
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