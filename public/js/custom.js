let mc = "", paymentType = "pod", courier = "", couriers = [];

$(document).ready(function() {
    "use strict";
	$('#payment-method-acd').hide();
    $("a.lno-cart").on("click", function(e) {
    	if(isMobile()){
    	  window.location = "cart";
       }
    })
    
	$("#ca-state").on("change", function(e) {
       // e.preventDefault();
	   console.log(paymentType);
      let s = $('#ca-state').val();
	   if(s == "none"){}
	   else{
	    getCouriers(s);   
	   }
    })
	
	$("#per-page").on("change", function(e) {
       // e.preventDefault();
       perPage = $('#per-page').val();
	   if(perPage == "none") perPage = 3;
	   showPage(1);
    })
	
    $(window).load(function() {
        $("#status").delay(350).fadeOut(),
        $("#preloader").delay(350).fadeOut("slow");
		
		
        $("#bname-other").hide();
		 $('#checkout-new').hide();
		 $('#checkout-anon').hide();
		 $('#payment-method-acd').hide();
		
		/**
		getCart()
		.then(res => {
			console.log("getCart(): ",res);
		})
		.catch(err =>{
			console.log("err: ",err);
		});
		**/
    }),
    $(".colors-panel").styleSwitcher({
        useCookie: !0
    }),
    $("#switcher").on("click", function() {
        jQuery(this).hasClass("hide-panel") ? (jQuery(".switcher-container").css({
            left: 0
        }),
        jQuery("#switcher").removeClass("hide-panel").addClass("show-panel")) : jQuery(this).hasClass("show-panel") && (jQuery(".switcher-container").css({
            left: "-50px"
        }),
        jQuery("#switcher").removeClass("show-panel").addClass("hide-panel"))
    }),
    $(".dropdown").on("mouseover", function() {
        $(this).find(".dropdown-menu").first().stop(!0, !0).delay(200).slideDown()
    }),
    $(".dropdown").on("mouseout", function() {
        $(this).find(".dropdown-menu").first().stop(!0, !0).delay(100).slideUp()
    }),
    $("html").niceScroll({
        styler: "fb",
        zindex: "9998"
    }),
    $("#banner").slick({
        centerMode: !1,
        autoplay: !0,
        infinite: !0,
        arrows: !0,
        dots: !0,
        fade: !0,
        slidesToShow: 1,
        centerPadding: "0px",
        responsive: [{
            breakpoint: 1e3,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: !0,
                arrows: !1
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: !0,
                arrows: !1,
                dots: !0
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: !0,
                arrows: !1,
                dots: !1
            }
        }]
    }),
    $("#best-deals").slick({
        centerMode: !1,
        slidesToShow: 4,
        autoplay: !1,
        arrows: !0,
        dots: !1,
        centerPadding: "5px",
        cssEase: "ease-in-out",
        responsive: [{
            breakpoint: 1e3,
            settings: {
                slidesToShow: 3,
                autoplay: !0,
                slidesToScroll: 1,
                infinite: !0,
                arrows: !1
            }
        }, {
            breakpoint: 768,
            settings: {
                autoplay: !0,
                infinite: !0,
                arrows: !1,
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 480,
            settings: {
                arrows: !1,
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    }),
    $("#brands").slick({
        centerMode: !1,
        autoplay: !0,
        infinite: !0,
        speed: 300,
        dots: !1,
        arrows: !1,
        slidesToShow: 5,
        slidesToScroll: 5,
        cssEase: "ease-in-out",
        responsive: [{
            breakpoint: 1e3,
            settings: {
                centerMode: !1,
                centerPadding: "5px",
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 768,
            settings: {
                centerMode: !1,
                centerPadding: "5px",
                slidesToShow: 2
            }
        }, {
            breakpoint: 480,
            settings: {
                centerMode: !1,
                slidesToShow: 1
            }
        }]
    }),
    $(".flip").on("click", function() {
        $(this).find(".card").toggleClass("flipped")
    }),
    $('select[name="colorpicker-bootstrap3-form"]').simplecolorpicker({
        theme: "ionicons"
    }),
    $("#list").on("click", function(e) {
        e.preventDefault(),
        $("#products .product-item-container").addClass("list-group-item-list")
    }),
    $("#grid").on("click", function(e) {
        e.preventDefault(),
        $("#products .product-item-container").removeClass("list-group-item-list").addClass("grid-group-item")
    }),
    $("#carousel").carousel({
        pause: !0,
        interval: !1
    }),
    $("#new-items").tab().tabCollapse().tab().tabCollapse(),
    $("#men .product-item-container").slice(0, 8).show(),
    $("#men .load-more a").on("click", function(e) {
        e.preventDefault(),
        $("#men .product-item-container:hidden").slice(0, 4).show(),
        0 == $("#men .product-item-container:hidden").length && ($("#men .load-less").show(),
        $("#men .load-more").hide())
    }),
    $("#men .load-less a").on("click", function(e) {
        e.preventDefault();
        var o = $("#men .product-item-container").length;
        $("#men .product-item-container").slice(8, o).hide(),
        $("#men .load-less").hide(),
        $("#men .load-more").show()
    }),
    $("#women .product-item-container").slice(0, 8).show(),
    $("#women .load-more a").on("click", function(e) {
        e.preventDefault(),
        $("#women .product-item-container:hidden").slice(0, 4).show(),
        0 == $("#women .product-item-container:hidden").length && ($("#women .load-less").show(),
        $("#women .load-more").hide())
    }),
    $("#women .load-less a").on("click", function(e) {
        e.preventDefault();
        var o = $("#women .product-item-container").length;
        $("#women .product-item-container").slice(8, o).hide(),
        $("#women .load-less").hide(),
        $("#women .load-more").show()
    }),
    $("#children .product-item-container").slice(0, 8).show(),
    $("#children .load-more a").on("click", function(e) {
        e.preventDefault(),
        $("#children .product-item-container:hidden").slice(0, 4).show(),
        0 == $("#children .product-item-container:hidden").length && ($("#children .load-less").show(),
        $("#children .load-more").hide())
    }),
    $("#children .load-less a").on("click", function(e) {
        e.preventDefault();
        var o = $("#children .product-item-container").length;
        $("#children .product-item-container").slice(8, o).hide(),
        $("#children .load-less").hide(),
        $("#children .load-more").show()
    }),
    $("#accessories .product-item-container").slice(0, 8).show(),
    $("#accessories .load-more a").on("click", function(e) {
        e.preventDefault(),
        $("#accessories .product-item-container:hidden").slice(0, 4).show(),
        0 == $("#accessories .product-item-container:hidden").length && ($("#accessories .load-less").show(),
        $("#accessories .load-more").hide())
    }),
    $("#accessories .load-less a").on("click", function(e) {
        e.preventDefault();
        var o = $("#accessories .product-item-container").length;
        $("#accessories .product-item-container").slice(8, o).hide(),
        $("#accessories .load-less").hide(),
        $("#accessories .load-more").show()
    }),
    $("#comment-body").characterCounter({
        counterCssClass: "help-block"
    }),
    $(".nudge a").on("mouseover", function() {
        $(this).animate({
            paddingLeft: "10px"
        }, 400)
    }),
    $(".nudge a").on("mouseout", function() {
        $(this).animate({
            paddingLeft: 0
        }, 400)
    }),
    $(".menu-nudge a").on("mouseover", function() {
        $(this).animate({
            paddingLeft: "20px"
        }, 400)
    }),
    $(".menu-nudge a").on("mouseout", function() {
        $(this).animate({
            paddingLeft: "10px"
        }, 400)
    }),
    $(".inner-zoom").zoom(),
    $("#price-slider").slider(),
    $(".qty-btngroup").each(function() {
        var e = $(this)
          , o = e.children('input[type="text"]')
          , n = o.val();
        e.children(".plus").on("click", function() {
            o.val(++n)
        }),
        e.children(".minus").on("click", function() {
            0 != n && o.val(--n)
        })
    }),
    $(".selectpicker").selectpicker({
        style: "btn-select",
        size: 6
    });
    var e = new WOW({
        boxClass: "wow",
        animateClass: "animated",
        offset: 0,
        mobile: !0,
        live: !0,
        callback: function() {}
    });
    e.init(),
    (new WOW).init();
    var o;
    o = document.getElementById("particles"),
    "undefined" != typeof o && null !== o && particleground(document.getElementById("particles"), {
        dotColor: "#ededed",
        lineColor: "#ededed"
    }),
    $("#countdown-one").countdown({
        date: "30 June 2016 09:00:00",
        format: "on"
    }),
    $("#countdown-two").countdown({
        date: "20 June 2016 04:00:00",
        format: "on"
    }),
    $("#countdown-three").countdown({
        date: "19 June 2016 01:30:00",
        format: "on"
    }),
    $("#countdown-four").countdown({
        date: "16 June 2016 01:30:00",
        format: "on"
    }),
    $("#countdown-five").countdown({
        date: "19 June 2016 01:30:00",
        format: "on"
    }),
    $("#countdown-six").countdown({
        date: "24 June 2016 03:30:00",
        format: "on"
    }),
    $("#countdown-soon").countdown({
        date: "19 June 2016 01:30:00",
        format: "on"
    }),
    $("#countdown-end").countdown({
        date: "1 March 2015 01:00:00",
        format: "on"
    }),
    $("#countdown-end-two").countdown({
        date: "1 March 2015 01:00:00",
        format: "on"
    }),
    $("#comment-body").characterCounter({
        counterCssClass: "help-block"
    }),
	 $("#add-to-cart-btn").on("click", function(e) {
        e.preventDefault();
       let qty = $($(this).attr('data-qty')).val();
	   console.log("qty: ",qty);
	   
	  
    }),
	$("#add-to-cart-btn-2").on("click", function(e) {
        e.preventDefault();
       let qty = $("#qty").val();
	   console.log("qty: ",qty);
	   
    })
});

//populateQV({sku:'{{$sku}}',description:'{{$description}}',amount:'{{$amount}}',oldAmount:'{{$amount + 1000}}',inStock:'{{ucwords($in_stock)}}',imgg:'{{$imggs[0]}}'})
				
function populateQV(dt){
	console.log("skju",dt);
        $("#quickviewboxLabel").html(dt.name);
        $("#quickviewboxDescription").html(dt.description);
        $("#quickviewboxAmount").html(dt.amount);
        $("#quickviewboxInStock").html(dt.inStock);
        $("#quickviewboxOldAmount").html(dt.oldAmount);
        $("#quickviewboxImg").attr("src",dt.imgg);
}


function setPaymentType(t){
	paymentType = t;
	$('#ca-state').val("none");
	$('#ca-state').selectpicker({
        style: "btn-select",
        size: 6
    });
}

function payNow(){
	console.log("pay now");
	setPaymentType("prepaid");
	$('#payment-type-acd').hide();
	$('#payment-method-acd').fadeIn();
	//setPaymentAction("cod");
}

function paymentMethodsBack(){
	setPaymentType("pod");
	$('#payment-method-acd').hide();
	$('#payment-type-acd').fadeIn();
}

function payOnDelivery(){
	paymentType = "pod";
    setPaymentAction("pod");
}

function payBank(dt){
	console.log("pay to bank account");
	try
	{
		if (dt.pod != null) {
	      $('#ca-pod').val("yes");
        }
	}
	catch(e)
	{
		//console.log("exception caught: ",e)
		 $('#ca-pod').val("no");
	}
	
	setPaymentAction("cod");
}

function payCard(dt){
	 	let x3 = "{{url('/')}}";
	
	Swal.fire({
    title: `Order reference: ${dt.ref}`,
  imageUrl: "images/paystack.png",
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: `Pay for order ${dt.ref} with card`,
  showCloseButton: true,
  html:
     "<h4 class='text-danger'><b>NOTE: </b>Make sure you note down your reference number above, as it will be required in the case of any issues regarding this order.</h4><p class='text-primary'>Click OK below to redirect to our secure payment gateway to complete this payment.</p>"
}).then((result) => {
  if (result.value) {
	  
    payWithCard(dt);
  }
});

}

function payWithCard(dt){
	 mc['notes'] = $('#notes').val();
	 if(dt.anon){
		 mc['name'] = $('#ca-name').val();
		 mc['email'] = $('#ca-email').val();
		 mc['phone'] = $('#ca-phone').val();
		 mc['address'] = $('#ca-address').val();
		 mc['city'] = $('#ca-city').val();
		 mc['state'] = $('#ca-state').val();
		 mc['courier'] = courier.id;
	 }
	 if(dt.pod){
		 let hp = $('#ca-amount').val();
		 $('#ca-amount').val(parseInt(hp) / 2);
		 mc['pod'] = "yes";
	 }
	 $('#nd').val(JSON.stringify(mc)); 
	console.log(mc);
	setPaymentAction("card");
}

function setPaymentAction(type){
	let paymentURL = "";
	$('#ca-courierr').val(courier.id);
	if(type == "cod"){
		
		paymentURL = $("#bank-action").val();  
   }
   else if(type == "card"){
		paymentURL = $("#card-action").val();  
   }
   else if(type == "pod"){
		paymentURL = $("#pod-action").val();  
   }
   
   //console.log(paymentURL);
   $('#checkout-form').attr('action',paymentURL);
   $('#checkout-form').submit();
}

function fi_preview(){
	if(courier.type){
	  if(courier.type == "prepaid"){
		  $('#ca-preview-pod').hide();
		  $('#ca-preview-prepaid').fadeIn();
	  }	
	  else if(courier.type == "pod"){
		  $('#ca-preview-prepaid').hide();
		  $('#ca-preview-pod').fadeIn();
	  }	
	
	  fi_next(3);
	}
	else{
		Swal.fire({
			     icon: 'error',
                 title: "Select a payment/delivery method."
               })
	}
	
}

function fi_pod(){
	let amt = $('#ca-amount').val();
	
	if(parseInt(amt) > 0){
	  $('#pod-amount').html(amt/200);
	  fi_next(4);
	}
	else{
		Swal.fire({
			     icon: 'error',
                 title: "Please add a product to your cart"
               })
	}
}

function fi_submit(){
	
}

function bomb(dt,url){

	//create request
	const req = new Request(url,{method: 'POST', headers: {'Content-Type': 'application/json'}, body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
	   })
	   .then(res => {
		   console.log(res);
		   let ev = true;
			
		   if(res.status == "ok"){
			   if(res.message === "finished"){
			      alert("All messages have been sent. To send more messages you need to delete the old leads and select new ones");
				  ev = false;
				  $("#stop-btn").hide();
		          $("#send-btn").fadeIn();
			    }
				else{
				  let ug = res.ug;
		          let bdg = $('#bdg-' + ug);
			      $('#rmk-' + ug).html("Message Sent!");			  
			      bdg.removeClass(bdg.attr("data-badge"));
			      bdg.addClass("badge-success");
                  bdg.html("sent");				  
				}
		   }
		   else if(res.status == "error"){
			   if(res.message == "Network error"){
				     alert("An unknown network error has occured. Please refresh the app or try again later");
                     ev = false;					 
			   }
			   else{
			   let ug = res.ug;
		       let bdg = $('#bdg-' + ug);
			   $('#rmk-' + ug).html("Failed to send message: " + res.message);
			   bdg.removeClass(bdg.attr("data-badge"));
			   bdg.addClass("badge-danger");
			   bdg.html("failed");
			   }
		   }
		   
		   if(ev === true){
		      setTimeout(function(){
		       bomb(dt,url);
		      },5000);
		    }
		   
	   }).catch(error => {
		    alert("Failed to send message: " + error);			
	   });
}

function selectBank(){
       let bname = $("#bname").val();
	   if(bname == "other"){
		   $('#bname-other').fadeIn();
	   }
	   else{
		   $('#bname-other').hide();
	   }
}

function printElem(html)
{
    let mywindow = window.open('', 'PRINT');
    let content = `
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>${document.title}</title>
<!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<!-- Ionicons font -->
<link href="css/ionicons.min.css" rel="stylesheet">
<!-- Bootstrap styles-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!--custom styles-->
<link href="css/custom.css" rel="stylesheet" />
<link href="css/custom-pink.css" rel="stylesheet"/>
<link href="css/custom-turquoise.css" rel="stylesheet" />
<link href="css/custom-purple.css" rel="stylesheet" />
<link href="css/custom-orange.css" rel="stylesheet" />
<link href="css/custom-blue.css" rel="stylesheet" />
<link href="css/custom-green.css" rel="stylesheet" />
<link href="css/custom-red.css" rel="stylesheet" />
<link href="css/custom-gold.css" rel="stylesheet" id="style">
<!--tooltiop-->
<link href="css/hint.css" rel="stylesheet">
<!-- animation -->
<link href="css/animate.css" rel="stylesheet" />
<!--select-->
<link href="css/bootstrap-select.min.css" rel="stylesheet">
<!--color picker-->
<link href="css/jquery.simplecolorpicker.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
<!-- favicon -->

<link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">

<!--jQuery--> 
<script src="js/jquery.min.js"></script> 
<!--SweetAlert--> 
<script src="lib/sweet-alert/all.js"></script>
</head><body>
${html}
</body></html>
	`;
    
	mywindow.document.write(content);
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    //mywindow.print();
    //mywindow.close();

    return true;
}

function supportsLocalStorage(){
	try{
	  return 'localStorage' in window && window['localStorage'] !== null;
	}
	catch(e){
		return false;
	}
}

const generateRandomString = (length) => {
	let chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	let ret = '';
	
	for(let i = length; i > 0; --i){
		ret += chars[Math.floor(Math.random() * chars.length)];
	}
	return ret;
}


function addToCart(dt)
{
	if(!dt.fromWishlist) dt.fromWishlist = "no";
    
	if(!dt.qty){
		dt.qty = $('#qty').val();
	}
  let cu = `add-to-cart?sku=${dt.sku}&from_wishlist=${dt.fromWishlist}&qty=${dt.qty}&gid=${gid}`;
  console.log("cu: ",cu);
  
  fbq('track', 'AddToCart', {
	currency: "NGN",
	contents: [{
      id: dt.sku,
      quantity: dt.qty
    }],
    content_type: 'product'
	});
  
  window.location = cu;
}

function updateCart(dt)
{    
  let qty = $(`#qty-${dt.sku}`).val();
  let upu = `update-cart?sku=${dt.sku}&qty=${qty}&gid=${gid}`;
  console.log("upu: ",upu);
  window.location = upu;
}

function removeFromCart(dt)
{
  let ru = `remove-from-cart?sku=${dt.sku}&gid=${gid}`;
  console.log("ru: ",ru);
  window.location = ru;
}

function addToWishlist(dt)
{
  let wu = `add-to-wishlist?sku=${dt.sku}&gid=${gid}`;
  console.log("wu: ",wu);
  window.location = wu;
}

function removeFromWishlist(dt)
{
  let wu = `remove-from-wishlist?sku=${dt.sku}&gid=${gid}`;
  window.location = wu;
}

function addToCompare(dt)
{
  let cu = `add-to-compare?sku=${dt.sku}&gid=${gid}`;
  window.location = cu;
}

function removeFromCompare(dt)
{
  let wu = `remove-from-compare?sku=${dt.sku}&gid=${gid}`;
  window.location = wu;
}

function showCheckout(type){
	switch(type){
		case 'new':
		 $('#checkout-anon').hide();
		 $('#checkout-new').fadeIn();
		break;
		
		case 'anon':
		 $('#checkout-new').hide();
		 $('#checkout-anon').fadeIn();
		break;
	}
}

function setCourier(id){
	prevCourier = courier;
	let ccc = couriers.find(i => i.id == id);
    if(ccc){
	   $(`#ca-action-${ccc.id}`).html(`<span class="label label-success">SELECTED</span>`);
	   if(prevCourier != "") $(`#ca-action-${prevCourier.id}`).html(`<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="setCourier(${prevCourier.id})">Select</a>`);
	   
	   $('#deliv').html("&#8358;" + ccc.price);
	   
	   if(parseInt(ccc.rtotal) > 0){
	     $('#checkout-total').html("&#8358;" + ccc.total);
         let camt = parseInt(ccc.rtotal) * 100;		 
	     $('#ca-amount').val(camt);  //for paystack
	   }
	   
	   if(ccc.type == "pod"){
		   $('#ca-preview-prepaid').hide();
		   $('#ca-preview-pod').fadeIn();
	   }
	   else if(ccc.type == "prepaid"){
		   $('#ca-preview-pod').hide();
		   $('#ca-preview-prepaid').fadeIn();
	   }

       courier = ccc;	   
	}
}

function getCouriers(dt){

	//create request
	let subtotal = $('#checkout-subtotal').val();
	const req = `gc?s=${dt}&st=${subtotal}`;
	console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
	   })
	   .then(res => {
		   console.log(res);
		   
		   if(res.status == "ok"){
			   let data = res.message;
			    let hh = ``;
				
			   if(data.length < 1){
				   Swal.fire({
			     icon: 'error',
                 title: "No couriers available in your area.."
               })
			   }
			   else{
				  
				   for(let r = 0; r < data.length; r++){
					   let cc = data[r], cvg = "", ttype = "";
					   let ss = `<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="setCourier(${cc.id})">Select</a>`;
					   let dtime = `3 to 5 working days`;
					   if(courier == cc.id) ss = `<span class="label label-success">SELECTED</span>`;
					   if(cc.coverage == "lagos"){
                        cvg = "Lagos state";
                         dtime = `2 to 3 working days`;
                       }
					   else if(cc.coverage == "sw"){
                         cvg = "Southwest states";
                       }
					   else cvg = "Other states";
					   
					   if(cc.type == "prepaid") ttype = "Pay now";
					   if(cc.type == "pod") ttype = "Pay on delivery";
					   
					   hh += `
					    <tr>
						  <td>${cc.name}</td>
						  <td>${ttype}</td>
						  <td>${cvg}</td>
						  <td>${dtime}</td>
						  <td>&#8358;${cc.price}</td>
						  <td id="ca-action-${cc.id}">${ss}</td>
						</tr>
					   `;
					   
					   couriers.push({id: cc.id,price: cc.price, total: cc.total, rtotal: cc.rtotal, type: cc.type});
				   }
			   }
			      	$('#courier-table > tbody').html(hh);
                    $('#ca-preview-prepaid').hide();
	                $('#ca-preview-pod').hide();					
				}
			else{
				Swal.fire({
			     icon: 'error',
                 title: "An error occured: " + res.message
               })
			}
		 
		  
	   }).catch(error => {
             Swal.fire({
			 icon: 'error',
             title: "Failed to send message: " + error
           })			
	   });
}

function getDeliveryFee(dt){

	//create request
	let subtotal = $('#checkout-subtotal').val();
	const req = `gdf?s=${dt}&st=${subtotal}`;
	console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
	   })
	   .then(res => {
		   console.log(res);
		   
		   if(res.status == "ok"){
			      $('#deliv').html("&#8358;" + res.message[1]);
				  if(parseInt(res.total) > 0){
					$('#checkout-total').html("&#8358;" + res.total[1]);  
					$('#ca-amount').val(res.total[0] * 100);  //for paystack
				  } 
                  $('#payment-method-acd').fadeIn();				  
				}
		  
	   }).catch(error => {
		    alert("Failed to send message: " + error);			
	   });
}

const getCart = () => {
	let cart = null;
	
    try{
		let c = localStorage.getItem('cart');
		if(c){
			cart = JSON.parse(c);
			console.log("cart: ",cart);
		}
		else{
			cart = [];
		}
	}
	
	catch(err){
		console.log("err in getCart(): ",err);
		cart = [];
	}
	
	return cart;
}

const setCartData = (cart) => {
	document.querySelector('#cart-badge').innerHTML = cart.length;
			let cartMenu = document.querySelector('#cart-menu');
			let htt = cartMenu.innerHTML;
			
			for(let j = 0; j < cart.length; j++){
				let cc = cart[j];
				htt += `
                  <li><div class="lnt-cart-products text-success"><i class="ion-android-checkmark-circle icon"></i> {{$item['sku']}} <b>x{{$qty}}</b><span class="lnt-cart-total">&#8358;{{number_format($itemAmount * $qty, 2)}}</span> </div></li>
				 `; 
				 
			}
			htt += `<li class="lnt-cart-actions text-center"> <a class="btn btn-default btn-lg hvr-underline-from-center-default" href="{{url('cart')}}">View cart</a> <a class="btn btn-primary hvr-underline-from-center-primary" href="{{url('checkout')}}">Checkout</a> </li>`;
			cartMenu.innerHTML = htt;
}

const setCookie = (k,v) => {
	var d = new Date;
            d.setTime(d.getTime() + 24 * 60 * 60 * 60 * 1e3);
            var e = "; expires=" + d.toGMTString();
	 document.cookie = k + "=" + v + e;
}

const getCookie = (name) => {
  var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
  if (match) return match[2];
}

const getParameterByName = (name, url) => {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

const syncData = (dt) => {
    let url = "sync-data";
	//create request
	const req = new Request(url,{method: "POST",body: dt});
	console.log("dt: ",dt);
	
	
	//fetch request
	return fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
	   })
	   .then(res => {
		   console.log("syncData returned: ",res);
		   
	   }).catch(error => {
		    alert("Failed to call getProducts: " + error);			
	   });
}

const searchToCart = (s) => {
	 let qty = $(`#search-qty-${s}`).val();
	   //console.log("qty: ",qty);
	   addToCart({sku: s,qty: qty});
}

const showPage = (p) => {
	//console.log("arr length: ",productsLength);
	//console.log("show per page: ",perPage);
	$('#pagination-row').hide();
	$('#products').html("");
	let start = 0, end = 0;
	
	if(productsLength < perPage){
		end = productsLength;
	}
	else{
		start = (p * perPage) - perPage;
		end = p * perPage;
	}
	
	//console.log(`start: ${start}, end: ${end}`);
	let hh = "", cids = [];

	for(let i = start; i < end; i++){
		if(i < productsLength)
		{
		let p = products[i];
		//console.log(p);
		cids.push(p.sku);
		let nnn = p.name;
		if(p.name.length > 12){
			nnn = `${p.name.substr(0,12)}..`;
		}
		let nn = p.name == "" ? p.sku : nnn;
		let imggs = JSON.parse(p.imggs);
		let ppd = p.pd.replace(/(?:\r\n|\r|\n)/g, '<br>'), pd = JSON.parse(ppd);
		let description = `${pd.description}`;
 	
		hh = `
				    <!--start of product item container-->
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 product-item-container effect-wrap effect-animate">
                          <div class="product-main">
                            <div class="product-view">
                              <figure class="double-img"><a href="${p.uu}" title="${p.name}"><img class="btm-img" src="${imggs[0]}" width="215" height="240"  alt=""/> <img class="top-img" src="${imggs[1]}" width="215" height="240"  alt=""/></a></figure>
                            </div>
                            <div class="product-btns  effect-content-inner">
                              <p class="effect-icon"> <a href="javascript:void(0)"  onclick="addToCart({sku:'${pd.sku}',qty: 1})" class="hint-top" data-hint="Add To Cart"><span class="cart ion-bag"></span></a></p>
                              <p class="effect-icon"> <a href="javascript:void(0)"  onclick="addToWishlist({sku:'${pd.sku}'})" class="hint-top" data-hint="Wishlist"><span class="fav ion-ios-star"></span></a></p>
                              <p class="effect-icon"> <a href="javascript:void(0)"  onclick="addToCompare({sku:'${pd.sku}'})" class="hint-top" data-hint="Compare"> <span class="compare ion-android-funnel"></span> </a></p>
                               <p class="effect-icon">
		   <a data-toggle="modal" data-target="#quick-view-box" onclick="populateQV({sku:'${p.sku}',name:'${p.name}',description:'${description}',amount:${pd.amount},oldAmount:'${pd.amount + 1000}',inStock:'${pd.in_stock}',imgg:'${imggs[0]}'})" class="hint-top" data-hint="Quick View"><span class="ion-ios-eye view"></span> </a>
		  				  </p>
                            </div>
                          </div>
                          <div class="product-info">
                            <h3 class="product-name"><a href="${p.uu}" title="${p.name}">${nn}</a></h3>
                            <p class="group inner list-group-item-text">${pd.description}</p>
                            <div class="product-price"><span class="real-price text-info"><strong>&#8358;${pd.amount}</strong></span></div>
                            <div class="product-evaluate text-info"> <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star-half"></i> </div>
                          </div>
                        </div>
                        <!--end of product item container-->
		`;
		$('#products').append(hh);
		
	  }
	}
	
	//Pagination
	$('ul.cd-pagination').html("");
	let pages = productsLength < perPage ? 1 : Math.ceil(productsLength / perPage);
	$('ul.cd-pagination').append(` <li class="button"><a href="javascript:void(0)" onclick="showPreviousPage();">Prev</a> </li>`);
	for(let x = 0; x < pages; x++){
		$('ul.cd-pagination').append(`<li><a href="javascript:void(0)" onclick="showPage(${x+1});">${x+1}</a> </li>`);
	}
	$('ul.cd-pagination').append(`<li class="button"><a href="javascript:void(0)" onclick="showNextPage();">Next</a></li>`);
	
	page = p;
	$('#pagination-row').fadeIn();
	document.querySelector('#pagination-row').scrollIntoView();
	fbq('track', 'ViewContent', {content_ids: cids, currency: "NGN", content_type: 'product'});
}

const showPreviousPage = () => {
	let sp = productsLength < perPage ? 1 : Math.ceil(productsLength / perPage), pp = page - 1;
	//console.log(`page: ${page},sp: ${sp},pp: ${pp}`);
	
	if(sp > pp && pp > 0){
		showPage(pp);
	}
	
}

const showNextPage = () => {
		let sp = productsLength < perPage ? 1 : Math.ceil(productsLength / perPage), pp = page + 1;
	//console.log(`page: ${page},sp: ${sp},pp: ${pp}`);
	
	if(sp >= pp){
		showPage(pp);
	}
}

const changePerPage = () =>{
	       perPage = $('#per-page').val();
		   if(perPage == "none") perPage = 3;

}

const isMobile = () =>{
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	return isMobile;
}

const fi_back = n => {
	let pp = n - 1;
	
	if(pp > 0){
		$(`#fieldset-${n}`).hide();
		$(`#fieldset-${pp}`).fadeIn();
	}
	
}

const fi_next = n => {
			let pp = n + 1;
	
	if(pp < 6){
		$(`#fieldset-${n}`).hide();
		$(`#fieldset-${pp}`).fadeIn();
	}
}

const setRating = n => {
		$(`#ovr`).html(n);
		$(`#ovr-2`).val(n);
		
		for(let i = 0; i < 5; i++){
			$(`#rbn-${i}`).removeClass('fa-star');
			$(`#rbn-${i}`).addClass('fa-star-o');
		}
		
		for(let i = 0; i < n; i++){
			$(`#rbn-${i}`).removeClass('fa-star-o');
			$(`#rbn-${i}`).addClass('fa-star');
		}
}

const useCoupon = (url) => {
		let xf = $(`#coupon`).val();
		
		if(xf == ""){
			Swal.fire({
			 icon: 'error',
             title: "Enter a coupon code"
           })	
		}
		
		else{
			window.location = `${url}?dxf=${xf}`;
		}
}
