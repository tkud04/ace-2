@extends('layout')

@section('title',"Compare")

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
        <h2 class="text-primary text-uppercase">compare</h2>
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
                <li class="active">compare</li>
              </ol>
            </div>
            <!--start of columns-->
            <div class="col-sm-12">
              <div class="row extra-btm-padding">
			  <ul class="list-group list-group-horizontal">
			    <?php
					  if(count($compares) > 0)
					  {
						 foreach($compares as $cmp)
						 {
							 $product = $cmp['product'];
							 $pd = $product['pd'];
							 $sku = $product['sku'];
							 $amount = $pd['amount'];
							 $statusClass = $pd['in_stock'] == "new" ? "success" : "info";
							 $uu = url('add-to-cart')."?from_wishlist=yes&qty=1&sku=".$sku;
							 $du = url('remove-from-compare')."?sku=".$sku;
							 $pu = url('product')."?sku=".$sku;
							 
							  $imggs = $product['imggs'];
			                  if(count($imggs) < 2){
				                $oll = $imggs[0];
				                array_push($imggs,$oll);
			                  }
				    ?>
               <li class="list-group-item list-group-horizontal-li">
			      <ul class="list-group list-group-flush compare-list">
				    <li>
					   <img class="img img-responsive" src="{{$imggs[0]}}" width="150" height="150"  alt=""/>
					   <a href="{{$pu}}" target="_blank">{{$sku}}</a>
					</li>
					<li>{!! $pd['description'] !!}</li>
					<li>&#8358;{{number_format($pd['amount'],2)}}</li>
					<li><span class="label label-{{$statusClass}}">{{strtoupper($pd['in_stock'])}}</span></li>
					<li>
					   <a class="btn btn-info" href="javascript:void(0)" onclick="addToCart({sku:'{{$sku}}',fromWishlist:'yes',qty:'1'})">Add to cart</span></a>
					   <a class="btn btn-danger" href="javascript:void(0)" onclick="removeFromCompare({sku:'{{$sku}}'})"><span class="ion-android-delete"></span></a>
					</li>
				  </ul>
			   </li>
			   <?php
						 }  
					  }
                    ?>	
              </ul>

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