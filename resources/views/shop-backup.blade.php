@extends('layout')

@section('title',ucwords($samba))

@section('content')
   <!--start of middle sec-->
  <div class="middle-sec wow fadeIn" data-wow-offset="10" data-wow-duration="2s">
    <div class="page-header">
      <div class="container text-center">
        <h2 class="text-primary text-uppercase">Shop</h2>
        <p>Browse through our catalog of amazing products! </p>
      </div>
    </div>
    <section class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="inner-ad">
            <figure><img class="img-responsive" src="{{$ad}}" width="1170" height="100" alt=""/></figure>
          </div>
        </div>
        <div class="col-sm-12 equal-height-container">
          <div class="row">
            <div class="col-sm-4 col-md-3  sub-data-left sub-equal">
              <section>
                <h5 class="sub-title text-info text-uppercase">Categories</h5>
                <ul class="list-group nudge">
				<?php
				  $i = 0;
				 foreach($c as $cc)
				 {
					 $style = $i == 0 ? 'style="padding-left: 0px;"' : '';
					  $ccu = url('shop')."?category=".$cc['category'];
					  ++$i;
				?>
                  <li class="list-group-item"><a href="{{$ccu}}"{{$style}}>{{ucwords($cc['category'])}}</a></li>
				<?php
				 }
				?>
                  
                </ul>
              </section>        
              <section> <img width="820" height="703" alt="" src="images/banner4.jpg" class="img-responsive"> </section>
              <section class="col-sm-12 tags">
                <h5 class="sub-title text-info text-uppercase">popular tags</h5>
				<?php
				  $e
				?>
                <a href="#">travel</a> <a href="#">blog</a> <a href="#">lifestyle</a></section>
            </div>
            <div class="col-sm-8 col-md-9 col-lg-9 main-sec">
              <div class="row"> 
                
                <!--start of breadcrumb-->
                <div class="col-sm-12">
                  <ol class="breadcrumb dashed-border">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('shop')}}">Shop</a></li>
                    <li class="active">{{$samba}}</li>
                  </ol>
                </div>
                <!--end of breadcrumb--> 
                
				 @if(count($products) > 0)
                <!--start of display settings-->
                
                <div class="col-sm-12">
                  <div class="dashed-border ">
                    <ul class="list-inline view-style top-menu row">
                      <li class="col-sm-3 col-md-2">
                        <select class="selectpicker">
                          <option>Sort By</option>
                          <option>Position</option>
                          <option>Name</option>
                          <option>Price</option>
                        </select>
                      </li>
                      <li  class="col-sm-3 col-md-2">
                        <select class="selectpicker">
                          <option>Show</option>
                          <option>9</option>
                          <option>12</option>
                          <option>15</option>
                        </select>
                      </li>
                      <li class="text-right col-sm-6 col-md-8">
                        <div class="btn-group">
                          <button id="grid" class="btn btn-primary hvr-underline-from-center-primary" > <span class="ion-android-apps"></span> </button>
                          <button id="list" class="btn btn-primary hvr-underline-from-center-primary" > <span class="ion-android-menu"></span> </button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!--end of display settings-->
				@endif
                
                <div class="col-sm-12">
				 @if(count($products) > 0)
                  <div class="row">
                    <div class="col-sm-12">
                      <div id="products" class="row">
					  <script>
					   let products = [];
					  </script>
		  <?php
		   foreach($products as $n)
		   {
			   $sku = $n['sku'];
			   $uu = url('product')."?sku=".$sku;
			   $cu = url('add-to-cart')."?sku=".$sku."&qty=1";
			   $wu = url('add-to-wishlist')."?sku=".$sku;
			   $ccu = url('add-to-compare')."?sku=".$sku;
			   $pd = $n['pd'];
			   $description = $pd['description'];
			   $in_stock = $pd['in_stock'];
			   $amount = $pd['amount'];
			   $imggs = $n['imggs'];
			   if(count($imggs) < 2){
				   $oll = $imggs[0];
				   array_push($imggs,$oll);
			   }
			    
		  ?>
		    <!--start of product item container-->
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 product-item-container effect-wrap effect-animate">
                          <div class="product-main">
                            <div class="product-view">
                              <figure class="double-img"><a href="{{$uu}}"><img class="btm-img" src="{{$imggs[0]}}" width="215" height="240"  alt=""/> <img class="top-img" src="{{$imggs[1]}}" width="215" height="240"  alt=""/></a></figure>
                            </div>
                            <div class="product-btns  effect-content-inner">
                              <p class="effect-icon"> <a href="{{$cu}}" class="hint-top" data-hint="Add To Cart"><span class="cart ion-bag"></span></a></p>
                              <p class="effect-icon"> <a href="{{$wu}}" class="hint-top" data-hint="Wishlist"><span class="fav ion-ios-star"></span></a></p>
                              <p class="effect-icon"> <a href="{{$ccu}}" class="hint-top" data-hint="Compare"> <span class="compare ion-android-funnel"></span> </a></p>
                               <p class="effect-icon">
		   <a data-toggle="modal" data-target="#quick-view-box" onclick="populateQV({sku:'{{$sku}}',description:`{{$description}}`,amount:'{{$amount}}',oldAmount:'{{$amount + 1000}}',inStock:'{{ucwords($in_stock)}}',imgg:'{{$imggs[0]}}'})" class="hint-top" data-hint="Quick View"><span class="ion-ios-eye view"></span> </a>
		  				  </p>
                            </div>
                          </div>
                          <div class="product-info">
                            <h3 class="product-name"><a href="{{$uu}}">{{$sku}}</a></h3>
                            <p class="group inner list-group-item-text">{{$description}}</p>
                            <div class="product-price"><span class="real-price text-info"><strong>&#8358;{{number_format($amount,2)}}</strong></span> <span class="old-price">&#8358;{{number_format($amount + 1000,2)}}</span> </div>
                            <div class="product-evaluate text-info"> <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star-half"></i> </div>
                          </div>
                        </div>
                        <!--end of product item container-->
			<?php
			}
			?>
		              </div>
                    </div>
                    <!--start of pagination-->
                    <div class="col-sm-12">
                      <nav role="navigation">
                        <ul class="cd-pagination">
                          <li class="button"><a href="#0">Prev</a> </li>
                          <li><a href="#0">1</a> </li>
                          <li><a href="#0">2</a> </li>
                          <li><a href="#0" class="current">3</a> </li>
                          <li><a href="#0">4</a> </li>
                          <li><span>...</span> </li>
                          <li><a href="#0">20</a> </li>
                          <li class="button"><a href="#0">Next</a></li>
                        </ul>
                      </nav>
                    </div>
                    <!--end of pagination--> 
                  </div>
				  @else
					  <div class="row">
                    <div class="col-sm-12">
                      <div class="row">
					    <div class="col-sm-12">
						  <h2 class="text-primary">Nothing found in that category</h2><br>
						  <h4 class="text-primary">Check out our new arrivals instead:</h4>
						</div><br><br>
		  <?php
		   foreach($na as $n)
		   {
			   $sku = $n['sku'];
			   $uu = url('product')."?sku=".$sku;
			   $cu = url('add-to-cart')."?sku=".$sku."&qty=1";
			   $wu = url('add-to-wishlist')."?sku=".$sku;
			   $ccu = url('add-to-compare')."?sku=".$sku;
			   $pd = $n['pd'];
			   $description = $pd['description'];
			   $in_stock = $pd['in_stock'];
			   $amount = $pd['amount'];
			   $imggs = $n['imggs'];
			   if(count($imggs) < 2){
				   $oll = $imggs[0];
				   array_push($imggs,$oll);
			   }
			    
		  ?>
		    <!--start of product item container-->
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 product-item-container effect-wrap effect-animate">
                          <div class="product-main">
                            <div class="product-view">
                              <figure class="double-img"><a href="{{$uu}}"><img class="btm-img" src="{{$imggs[0]}}" width="215" height="240"  alt=""/> <img class="top-img" src="{{$imggs[1]}}" width="215" height="240"  alt=""/></a></figure>
                            </div>
                            <div class="product-btns  effect-content-inner">
                              <p class="effect-icon"> <a href="{{$cu}}" class="hint-top" data-hint="Add To Cart"><span class="cart ion-bag"></span></a></p>
                              <p class="effect-icon"> <a href="{{$wu}}" class="hint-top" data-hint="Wishlist"><span class="fav ion-ios-star"></span></a></p>
                              <p class="effect-icon"> <a href="{{$ccu}}" class="hint-top" data-hint="Compare"> <span class="compare ion-android-funnel"></span> </a></p>
                              <p class="effect-icon">
		   <a data-toggle="modal" data-target="#quick-view-box" onclick="populateQV('{{$sku}}','{{$description}}','{{$amount}}','{{$amount + 1000}}','{{ucwords($in_stock)}}','{{$imggs[0]}}')" class="hint-top" data-hint="Quick View"><span class="ion-ios-eye view"></span> </a>
							  </p>
                            </div>
                          </div>
                          <div class="product-info">
                            <h3 class="product-name"><a href="{{$uu}}">{{$sku}}</a></h3>
                            <p class="group inner list-group-item-text">{{$description}}</p>
                            <div class="product-price"><span class="real-price text-info"><strong>&#8358;{{number_format($amount,2)}}</strong></span> <span class="old-price">&#8358;{{number_format($amount + 1000,2)}}</span> </div>
                            <div class="product-evaluate text-info"> <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star-half"></i> </div>
                          </div>
                        </div>
                        <!--end of product item container-->
			<?php
			}
			?>
		              </div>
                    </div>
				   </div>
				  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!--end of middle sec--> 
    
@stop