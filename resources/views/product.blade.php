@extends('layout')

 <?php
				   $sku = $product['sku'];
				   $name = $product['name'];
			   $uu = url('product')."?sku=".$sku;
			   $cu = url('add-to-cart')."?sku=".$sku;
			   $wu = url('add-to-wishlist')."?sku=".$sku;
			   $ccu = url('add-to-compare')."?sku=".$sku;
			   $pd = $product['pd'];
			   $description = $pd['description'];
			   $category = $pd['category'];
			   $in_stock = $pd['in_stock'];
			   $iss = ['in_stock' => "in stock",'out_of_stock' => "out of stock",'new' => "available for order"];
			   $amount = $pd['amount'];
			   
				  $imggs = $product['imggs'];
				
				$googleProductCategories = [
				              'bracelets' => "191",
							  'brooches' => "197",
							  'earrings' => "194",
							  'necklaces' => "196",
							  'rings' => "200",
							  'anklets' => "189",
							  'scarfs' => "177",
							  'Hair Accessories' => "171"
							  ];
				?>

@section('metas')
<meta property="og:title" content="{{$name}}">
<meta property="og:description" content="{{$description}}">
<meta property="og:url" content="{{$uu}}">
<meta property="og:image" content="{{$imggs[0]}}">
<meta property="product:brand" content="Ace Luxury Store">
<meta property="product:availability" content="{{$iss[$in_stock]}}">
<meta property="product:condition" content="new">
<meta property="product:price:amount" content="{{$amount}}">
<meta property="product:price:currency" content="NGN">
<meta property="product:retailer_item_id" content="{{$sku}}">
<meta property="product:item_group_id" content="{{$category}}">
<meta property="product:category" content="{{$googleProductCategories[$category]}}">
@stop

@section('title',$product['name'])

@section('content')
   <!--start of middle sec-->
<div class="middle-sec wow fadeIn animated animated" data-wow-offset="10" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s;">
    <div class="page-header">
      <div class="container text-center">
        <h2 class="text-primary text-uppercase">{{$product['name']}}</h2>
        <p>View more information about this product.</p>
      </div>
    </div>
    <section class="container">
      <div class="row">
	   @if($agent->isDesktop())
        <div class="col-sm-12">
          <div class="inner-ad">
            <figure><img class="img-responsive" src="{{$ad}}" width="1170" height="100" alt=""></figure>
          </div>
        </div>
	   @endif
        <div class="col-sm-12 equal-height-container">
          <div class="row">
		    @if($agent->isDesktop())
            <div class="col-sm-4 col-md-3  sub-data-left sub-equal">
              <section>
                <h5 class="sub-title text-info text-uppercase">Categories</h5>
                <ul class="list-group nudge">
				<?php
				  $i = 0;
				 foreach($cc as $key => $value)
				 {
					 $style = $i == 0 ? 'style="padding-left: 0px;"' : '';
					 $uu = url('shop')."?category=".$key;
				?>
                  <li class="list-group-item"><a href="{{$uu}}"{{$style}}>{{$value}}</a></li>
				<?php
				 }
				?>
                  
                </ul>
              </section>        
              <section> <img width="820" height="703" alt="" src="images/banner5.png" class="img-responsive"> </section>
              <section class="col-sm-12 tags">
                <h5 class="sub-title text-info text-uppercase">popular tags</h5>
                <a href="javascript:void(0)">earrings</a> <a href="javascript:void(0)">rings</a> <a href="javascript:void(0)">brooches</a> <a href="javascript:void(0)">watches</a> <a href="javascript:void(0)">bracelets</a> <a href="javascript:void(0)">fashion</a></section>
            </div>
			@endif
            <div class="col-sm-8 col-md-9  main-sec">
              <div class="row">
                <div class="col-sm-12">
                  <ol class="breadcrumb  dashed-border">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('shop')}}">Shop</a></li>
                    <li class="active">{{$product['name']}}</li>
                  </ol>
                </div>
                <!--start of product details-->
               
                <div class="col-sm-12 product-details">
                  <div class="row">
                    <div class="col-sm-6">
                      <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
						   <?php
						   for($k = 0; $k < count($imggs); $k++)
						   {
							   $class = $k == 0 ? "item active" : "item";
						   ?>
                           <div class="{{$class}}"><span class="inner-zoom" style="position: relative; overflow: hidden;"><img class="img-responsive" src="{{$imggs[$k]}}" width="700" height="700" alt=""><img src="{{$imggs[$k]}}" class="zoomImg" style="position: absolute; top: -270.367px; left: -6.04768px; opacity: 0; width: 700px; height: 700px; border: none; max-width: none; max-height: none;"></span></div>
					       <?php
						   }
						   ?>
                        </div>
                        <div class="carousel-link clearfix">
						  @for($j = 0; $j < count($imggs); $j++)
                          <div data-target="#carousel" data-slide-to="{{$j}}" class="thumb"><img src="{{$imggs[$j]}}" alt="{{$sku}}"></div>
                          @endfor					  
						</div>
                      </div>
                    </div>
                    <div class="col-sm-6 sub-info">
					 <input type="hidden" id="sku" value="{{$product['sku']}}">
					 <input type="hidden" id="cu" value="{{$cu}}">
                      <div class="product-name">
                        <h5 class="text-primary text-uppercase">{{$sku}} - {{$name}}</h5>
                      </div>
                      <div class="product-description">
                        <h5 class="text-primary text-uppercase">Quick Overview</h5>
                        <p> {{$description}}</p>
                      </div>
                      <div class="product-availability in-stock">				
                        <p>Availability: <span class="text-info">{{$in_stock}}</span></p>
						<?php
					   $oldAmount = $amount; $newAmount = 0;
			   
			   if(count($discounts) > 0)
			   {
				   foreach($discounts as $d)
				   {
					   ?>
					   <p><em><span class="ion-scissors" style="margin-right: 4px"></span><span class="text-primary">{!!$d['name']!!}</span></em></p>
					   <?php
					   if($newAmount < 1)
					   {
						   $newAmount = $oldAmount - $d['discount'];
					   }
					   else
					   {
						   $newAmount -= $d['discount'];
					   }
				   }
			   }
			       if($newAmount == 0)$newAmount = $amount;
					  ?>                        
                      </div>
                      <div class="product-price clearfix">
					    <span class="pull-left btn btn-primary"><strong>&#8358;{{number_format($newAmount, 2)}}</strong></span>
						@if($newAmount != $oldAmount)
					    <span class="pull-left btn btn-link"><del>&#8358;{{number_format($oldAmount, 2)}}</del></span>
					    @endif
					  </div>
                     
                      <div class="product-quantity">
                        <h5 class="text-primary text-uppercase">select quantity</h5>
                        <div class="qty-btngroup clearfix pull-left">
                          <button type="button" class="minus">-</button>
                          <input type="text" id="qty" value="1">
                          <button type="button" class="plus">+</button>
                        </div>
                        <a href="javascript:void(0)"  onclick="addToCart({sku:'{{$sku}}'})" class="btn btn-primary pull-left hvr-underline-from-center-primary">Add To Cart</a> </div>
                    </div>
                  </div>
                  <hr>
                </div>
                
                <!--end of product deatils--> 
                
                <!--start of product data-->
                <div class="col-sm-12 accordion">
                  <div role="tabpanel"> 
                    
                    <!-- Nav tabs -->
                    
                    <ul id="product-tabs" class="nav nav-tabs text-uppercase" role="tablist">
                      <li role="presentation" class="active"><a href="#descreption" aria-controls="descreption" role="tab" data-toggle="tab">Description</a></li>
                      <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
                      <li role="presentation"><a href="#tags" aria-controls="tags" role="tab" data-toggle="tab">Add your review</a></li>
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class=" tab-pane product-pane fade in active clearfix" id="descreption">
                        <p>{{$description}} </p>
                      </div>
                      <div role="tabpanel" class=" tab-pane product-pane fade in clearfix" id="reviews">
					   <?php
						foreach($reviews as $r)
						{
							$name = $r['name'];
							$review = $r['review'];
							$rating = $r['rating'];
						?>
                        <div class="single-review clearfix">
						<h5 class="text-primary">{{$name}} <small class=" text-info"><strong>{{date("jS F, Y")}}</strong></small> </h5>
                          <p><span class="reviews-ratings text-info">
						  @for($x = 0; $x < $rating; $x++)
						    <i class="ion-android-star"></i>
						  @endfor
						  </span></p>
                          <p>{{$review}}</p>
                          <hr>
                        </div>
                        <?php
						}
						?>
                      </div>
                      <div role="tabpanel" class=" tab-pane product-pane fade in clearfix" id="tags">
                        <form role="form" method="post" action="{{url('add-review')}}">
							{!! csrf_field() !!}
							<input type="hidden" name="sku" value="{{$product['sku']}}">
                          <fieldset>
                            <h5 class="sub-title text-primary text-uppercase">rating</h5>
                            <div class="form-group">
                              <div class="radio radio-inline">
                                <input type="radio" id="inlineRadio1" value="1" name="rating">
                                <label class="control-label" for="inlineRadio5"> 1 Star</label>
                              </div>
                              <div class="radio radio-inline">
                                <input type="radio" id="inlineRadio2" value="2" name="rating">
                                <label class="control-label" for="inlineRadio2"> 2 Stars </label>
                              </div>
                              <div class="radio radio-inline">
                                <input type="radio" id="inlineRadio3" value="3" name="rating">
                                <label class="control-label" for="inlineRadio3"> 3 Stars </label>
                              </div>
                              <div class="radio radio-inline">
                                <input type="radio" id="inlineRadio4" value="4" name="rating">
                                <label class="control-label" for="inlineRadio4"> 4 Stars </label>
                              </div>
                              <div class="radio radio-inline">
                                <input type="radio" id="inlineRadio5" value="5" name="rating">
                                <label class="control-label" for="inlineRadio5"> 5 Stars </label>
                              </div>
                            </div>
                          </fieldset>
                          
                          <br>
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label class="control-label" for="exampleInputName">Your Name <span class="req">*</span></label>
                                <input type="text" placeholder="" name="name" id="exampleInputName" class="form-control txt">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label class="control-label" for="exampleInputReview">Review <span class="req">*</span></label>
                                <textarea placeholder="" rows="4" name="review" id="exampleInputReview" class="form-control"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="action">
                            <button type="submit" class="btn btn-primary hvr-underline-from-center-primary">SUBMIT</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
                <!--end of product data--> 
                
                <!--start of related products-->
                <div class="col-sm-12">
                  <div class="row"> 
                    <!--start of big title-->
                    <div class="col-sm-12">
                      <h5 class="sub-title text-primary text-uppercase">related products</h5>
                    </div>
                    <!--end of big title--> 
                    <!--start of product item container-->
                    <?php
					shuffle($related);
		   for($i = 0; $i < 3 && $i < count($related); $i++)
		   {
			   $n = $related[$i];
			   
			   
			   if($n['sku'] != $product['sku'])
			   {
			   $sku = $n['sku'];
			   $name = $n['name'];
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
                              <figure class="double-img"><a href="{{$uu}}"><img class="btm-img" src="{{$imggs[1]}}" width="215" height="240"  alt=""/> <img class="top-img" src="{{$imggs[0]}}" width="215" height="240"  alt=""/></a></figure>
                            </div>
                            <div class="product-btns  effect-content-inner">
		   <p class="effect-icon"> <a href="javascript:void(0)" onclick="addToCart({sku:'{{$sku}}',qty:'1'})" class="hint-top" data-hint="Add To Cart"><span class="cart ion-bag"></span></a></p>
                              <p class="effect-icon"> <a href="javascript:void(0)" onclick="addToWishlist({sku:'{{$sku}}'})" class="hint-top" data-hint="Wishlist"><span class="fav ion-ios-star"></span></a></p>
                              <p class="effect-icon"> <a href="javascript:void(0)" onclick="addToCompare({sku:'{{$sku}}'})" class="hint-top" data-hint="Compare"> <span class="compare ion-android-funnel"></span> </a></p>
                               <p class="effect-icon">
		   <a data-toggle="modal" data-target="#quick-view-box" onclick="populateQV({sku:'{{$sku}}',description:`{{$description}}`,amount:'{{$amount}}',oldAmount:'{{$amount + 1000}}',inStock:'{{ucwords($in_stock)}}',imgg:'{{$imggs[0]}}'})" class="hint-top" data-hint="Quick View"><span class="ion-ios-eye view"></span> </a>
		  				  </p>
                            </div>
                          </div>
                          <div class="product-info">
                            <h3 class="product-name"><a href="{{$uu}}">{{$name}}</a></h3>
                            <p class="group inner list-group-item-text">{{$description}}</p>
                            <div class="product-price"><span class="real-price text-info"><strong>&#8358;{{number_format($amount,2)}}</strong></span> <!--  <span class="old-price">&#8358;{{number_format($amount + 1000,2)}}</span> --></div> 
                          <div class="product-evaluate text-info"> <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star-half"></i> </div>
                          </div>
                        </div>
                        <!--end of product item container-->
			<?php
			}
		   }
			?>
                    
                  </div>
                </div>
                <!--end of related products--> 
                
              </div>
            </div>
			@if($agent->isMobile())
            <div class="col-sm-4 col-md-3  sub-data-left sub-equal">
              <section>
                <h5 class="sub-title text-info text-uppercase">Categories</h5>
                <ul class="list-group nudge">
				<?php
				  $i = 0;
				 foreach($cc as $key => $value)
				 {
					 $style = $i == 0 ? 'style="padding-left: 0px;"' : '';
					 $uu = url('shop')."?category=".$key;
				?>
                  <li class="list-group-item"><a href="{{$uu}}"{{$style}}>{{$value}}</a></li>
				<?php
				 }
				?>
                  
                </ul>
              </section>        
              <section> <img width="820" height="703" alt="" src="images/banner5.png" class="img-responsive"> </section>
              <section class="col-sm-12 tags">
                <h5 class="sub-title text-info text-uppercase">popular tags</h5>
                <a href="javascript:void(0)">earrings</a> <a href="javascript:void(0)">rings</a> <a href="javascript:void(0)">brooches</a> <a href="javascript:void(0)">watches</a> <a href="javascript:void(0)">bracelets</a> <a href="javascript:void(0)">fashion</a></section>
            </div>
			@endif
          </div>
        </div>
      </div>
    </section>
  </div>
  <!--end of middle sec--> 
    
@stop

@section('scripts')
<script>
fbq('track', 'ViewContent', {content_ids: ["{{$sku}}"], currency: "NGN", value: "{{$amount}}", content_type: "product"});
</script>
@stop