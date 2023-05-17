<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Illuminate\Support\Facades\Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 

class MainController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;                     
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex(Request $request)
    {
		$hasUnpaidOrders = null;
		$user = null;
		
		//remove all carts with no user id
		$this->helpers->clearGhostCarts();
		
		if(Auth::check())
		{
			$user = Auth::user();
			$hasUnpaidOrders = $this->helpers->checkForUnpaidOrders($user);
		}
		
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		
		$c = $this->helpers->getCategories();
		
		$signals = $this->helpers->signals;
		$na = $this->helpers->getNewArrivals();
		#$na = [];
		#dd($na);
		$bs = $this->helpers->getBestSellers();
		#$bs = [];
		#dd($na);
		$ads = $this->helpers->getAds("wide-ad");
		$banners = $this->helpers->getBanners();
		$plugins = $this->helpers->getPlugins();
		
		#dd($hasUnpaidOrders);
		
		shuffle($ads);
		shuffle($banners);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
    	return view("index-2",compact(['user','cart','c','banners','hasUnpaidOrders','bs','na','ad','signals','plugins']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getReviews(Request $request)
    {
		$hasUnpaidOrders = null;
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			#$hasUnpaidOrders = $this->helpers->checkForUnpaidOrders($user);
		}
		
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		
		$c = $this->helpers->getCategories();
		
		$signals = $this->helpers->signals;
		$reviews = $this->helpers->getOrderReviews(['order' => true]);
		#dd($reviews);
		
		$ads = $this->helpers->getAds("wide-ad");
		$banners = $this->helpers->getBanners();
		$plugins = $this->helpers->getPlugins();
		
		#dd($hasUnpaidOrders);
		
		shuffle($ads);
		shuffle($banners);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];

    	return view("reviews",compact(['user','cart','c','banners','reviews','ad','signals','plugins']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getShop(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		
		$c = $this->helpers->getCategories();
		$cc = $this->helpers->categories_2;
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$na = $this->helpers->getNewArrivals();
		
                 if(isset($req['type']) || isset($req['category']))
				 {
                    if(isset($req['type']))
                     {
					     $type = $req['type'];
					   $products = $this->helpers->getProductsByType($type);
					   // dd($products);
					   $samba = $this->helpers->getFriendlyName($type);
					   
                       return view("shop",compact(['user','cart','products','c','na','ad','samba','signals','plugins']));
                       
                     }
                
                    if(isset($req['category']))
                    {
					   
					   $category = $req['category'];
					   $products = $this->helpers->getProductsByCategory($category);
					 // dd($products);
					 $samba = $this->helpers->getFriendlyName($category);
                       return view("shop",compact(['user','cart','products','c','na','ad','samba','signals','plugins']));			 
                    }
				 }
                 else
				 {
					   $products = $this->helpers->getProducts();
					 // dd($products);
					 $samba = "Shop";
                       return view("shop",compact(['user','cart','products','c','na','ad','samba','signals','plugins']));
				 }				 
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getProduct(Request $request)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$cc = $this->helpers->categories_2;
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		
    	
		
		$req = $request->all();
	    //dd($secure);
		$validator = Validator::make($req, [
                             'sku' => 'required'
                   ]);
         
                 if($validator->fails())
                  {
					  $uu = "shop?category=necklaces";
                      return redirect()->intended($uu);
                       
                 }
                
                 else
                 {
					 $product = $this->helpers->getProduct($req["sku"]);
					 #dd($product);
					 $discounts = [];
					 if(count($product['discounts']) > 0)
					 {
						 $amount = $product['pd']['amount'];
						 
						 foreach($product['discounts'] as $d)
						 {
							 $temp = [];
							 $val = $d['discount'];
							 
							 switch($d['type'])
							 {
								 case "general":
								   $temp['name'] = "ACE discount: <b>".$val."%</b>";
								 break;
								 
								 case "single":
								   $temp['name'] = $product['sku']." discount: <b>&#8358;".$val."</b>";
								 break;
							 }
							 switch($d['discount_type'])
							 {
								 case "percentage":
								   $temp['discount'] = floor(($val / 100) * $amount);
								 break;
								 
								 case "flat":
								   $temp['discount'] = $val;
								 break;
							 }
							 
							 array_push($discounts,$temp);
						 }
					 }
					 #dd($discounts);
					 $reviews = $this->helpers->getReviews($req["sku"]);
					 $related = $this->helpers->getProducts();
					// dd($product);
					
					if(isset($req['type']) && $req['type'] == "json")
					{
						return json_encode($product);
					}
					else
					{
						return view("product",compact(['user','cart','c','cc','ad','reviews','related','product','discounts','signals','plugins']));
					}
                    			 
                 }			 
    	
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getCart(Request $request)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		
		$ddxf = [];
		$dxf = "";
		if(isset($req['dxf']))
		{
			$ddxf = $this->helpers->getDiscount($req['dxf']);
			$dxf = $req['dxf'];
		} 
		
		$totals = $this->helpers->getCartTotals($cart,$ddxf);
		if(isset($req['rr'])) dd($totals);
		$c = $this->helpers->getCategories();
		$signals = $this->helpers->signals;
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		#session()->reflash();
		
		return view("cart",compact(['user','cart','totals','dxf','c','ad','signals','plugins']));					 
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getUseCoupon(Request $request)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
		}
		$req = $request->all();
	    //dd($secure);
		$validator = Validator::make($req, [
                             'xf' => 'required'
                   ]);
         
                 if($validator->fails())
                  {
                      return redirect()->back();
                       
                 }
                
                 else
                 {
					$discount = $this->helpers->getDiscount($req["xf"]);
					$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
					#dd($gid);
					if(count($discounts) > 0)
					 {
						 $ca = $this->helpers->applyDiscount($user,$cart);
					 }
                    			 
                 }			 
    	
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getCheckout(Request $request)
    {
        $user = null;
		$cart = [];
		$shipping = [];
		if(Auth::check())
		{
			$user = Auth::user();
		    $shipping = $this->helpers->getShippingDetails($user);	
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$ddxf = [];
		$dxf = "";
		if(isset($req['dxf']))
		{
			$ddxf = $this->helpers->getDiscount($req['dxf']);
			$dxf = $req['dxf'];
		} 
		
		$totals = $this->helpers->getCartTotals($cart,$ddxf);
		

			$ss = ['company' => "",
			       'address' => "",
			       'city' => "",
			       'state' => "",
			       'id' => "",
			       'date' => ""
			    ];
				
				
		   if(count($shipping) > 0) $ss = $shipping[0];
		$c = $this->helpers->getCategories();
		$states = $this->helpers->states;
		$ads = $this->helpers->getAds();
		$ref = $this->helpers->getRandomString(5);
						$md = json_encode(['custom_fields' => ['display_name' => "Reference No.",'variable_name' => "ref",'value' => $ref],'type' => "checkout",'notes' => ""]);
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#dd($user);
		$secure = (isset($req['ss']) && $req['ss'] == "1") ? false : true;
        #$dxf = $req['dxf'];
		if(is_null($user))
		{
			return view("anon-checkout",compact(['user','cart','totals','dxf','ss','ad','ref','md','states','secure','c','signals','plugins']));		
		}
		else
		{
			return view("checkout",compact(['user','cart','totals','dxf','ss','ad','ref','md','states','secure','c','signals','plugins']));		
		}
								 
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postCheckout(Request $request)
    {
		$user = null;
		$rules = [
                             'email' => 'required|email',
                             'name' => 'required',
                             'phone' => 'required|numeric',
                             'address' => 'required',
                             'state' => 'required',
							 'courier' => 'required',
                             'city' => 'required',
                             'terms' => 'accepted'
         ];
		 
    	if(Auth::check())
		{
			$user = Auth::user();
			$rules = [
                             'email' => 'required|email',
                             'amount' => 'required|numeric',
                             'fname' => 'required',
                             'lname' => 'required',
                             'phone' => 'required|numeric',
                             'address' => 'required',
                             'state' => 'required',
                             'courier' => 'required',
                             'city' => 'required',
                             'terms' => 'accepted'
         ];
		}
        $req = $request->all();
		$req['zip'] = "";
       #dd($req);
        
        $validator = Validator::make($req, $rules);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 #dd($req);
			 if($req['amount'] < 1)
			 {
				 $err = "error";
				 session()->flash("no-cart-status",$err);
				 return redirect()->back();
			 }
			 else
			 {
				if(isset($req['pod-bank']) && $req['pod-bank'] == "yes")
			    {
				  $req['payment_type'] = "bank";
				  $ret = $this->helpers->checkout($user,$req,"pod");
				  $o = [];
				  #dd($ret);
				  //We have the user, notify the customer and admin
				  //$rett = $this->helpers->smtp;
				  $rett = $this->helpers->getCurrentSender();
				  if(is_null($user))
				  {
					  $u = $this->helpers->getAnonOrder($ret->reference);
					  $shipping = [
					     'address' => $req['address'],
					     'city' => $req['city'],
					     'state' => $req['state'],
					   ];
					  $name = $req['name'];
					  $view = "emails.anon-new-order-pod";
				  }
				  else
				  {
					  $u = $this->helpers->getUser($user->id);
					  $sd = $this->helpers->getShippingDetails($user->id);
					  $shipping = $sd[0];
					  $name = $user->fname." ".$user->lname;
					  $view = "emails.new-order-pod";
				  }
				
				  $rett['order'] = $this->helpers->getOrder($ret->reference);
				  $o = $rett['order'];
				  #dd([$rett['order'],$o]);
				  $rett['u'] = $u;
				  $rett['subject'] = "URGENT: Confirm your payment for order ".$ret->reference;
		          $rett['em'] = $u['email'];
				  $rett['name'] = $name;
				  $rett['shipping'] = $shipping;
				  $rett['payment_type'] = "bank";
		          $this->helpers->sendEmailSMTP($rett,$view);
				  
				  /**
				  $rett['subject'] = "URGENT: Bank payment request (part payment) for order ".$o['reference']." via POD";
				  $rett['user'] = $u['email'];
				  $rett['phone'] = $u['phone'];
				  $rett['em'] = $this->helpers->adminEmail;
				  $this->helpers->sendEmailSMTP($rett,"emails.admin-bank-alert");
				  $rett['em'] = $this->helpers->suEmail;
				  $this->helpers->sendEmailSMTP($rett,"emails.admin-bank-alert");
				  **/
				}
				
				else
				{
					$ret = $this->helpers->checkout($user,$req,"bank");
				    $o = [];
				    #dd($ret);
				    //We have the user, notify the customer and admin
				    //$rett = $this->helpers->smtp;
			        $rett = $this->helpers->getCurrentSender();
				   
				    if(is_null($user))
				    {
					   $u = $this->helpers->getAnonOrder($ret->reference);
					   $shipping = [
					     'address' => $req['address'],
					     'city' => $req['city'],
					     'state' => $req['state'],
					   ];
					   $name = $req['name'];
					   $view = "emails.anon-new-order-bank";
				    }
				    else
				    {
					   $u = $this->helpers->getUser($user->id);
					   $sd = $this->helpers->getShippingDetails($user->id);
					   $shipping = $sd[0];
					   $name = $user->fname." ".$user->lname;
					   $view = "emails.new-order-bank";
				    }
				
				    $rett['order'] = $this->helpers->getOrder($ret->reference);
				    $o = $rett['order'];
				    #dd([$rett['order'],$o]);
				    $rett['u'] = $u;
				    $rett['subject'] = "URGENT: Confirm your payment for order ".$ret->reference;
		            $rett['em'] = $u['email'];
					$rett['name'] = $name;
				    $rett['shipping'] = $shipping;
					$rett['payment_type'] = "bank";
		            $this->helpers->sendEmailSMTP($rett,$view);
					
					/**
					$rett['subject'] = "URGENT: Bank payment request for order ".$o['reference'];
				    $rett['user'] = $u['email'];
				    $rett['phone'] = $u['phone'];
				    $rett['em'] = $this->helpers->adminEmail;
				    $this->helpers->sendEmailSMTP($rett,"emails.admin-bank-alert");
				    $rett['em'] = $this->helpers->suEmail;
				    $this->helpers->sendEmailSMTP($rett,"emails.admin-bank-alert");
					**/
				}
				
				 
				 
		        // $uu = url('confirm-payment')."?oid=".$ret->reference;
			     //return redirect()->intended($uu);
				 $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
			
			return view("bps",compact(['user','cart','c','o','ad','signals','plugins']));
			 }
         	
          
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPOD(Request $request)
    {
        return redirect()->intended('checkout');
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postPOD(Request $request)
    {
		$user = null;
		$rules = [
                             'email' => 'required|email',
                             'name' => 'required',
                             'phone' => 'required|numeric',
							 'courier' => 'required',
                             'address' => 'required',
                             'state' => 'required',
                             'city' => 'required',
                             'terms' => 'accepted'
         ];
		 
    	if(Auth::check())
		{
			$user = Auth::user();
			$rules = [
                             'email' => 'required|email',
                             'amount' => 'required|numeric',
                             'fname' => 'required',
                             'lname' => 'required',
                             'phone' => 'required|numeric',
							 'courier' => 'required',
                             'address' => 'required',
                             'state' => 'required',
                             'city' => 'required',
                             'terms' => 'accepted'
         ];
		}
        $req = $request->all();
		$req['zip'] = "";
        #dd($req);
        
        $validator = Validator::make($req, $rules);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 #dd($req);
			 if($req['amount'] < 1)
			 {
				 $err = "error";
				 session()->flash("no-cart-status",$err);
				 return redirect()->back();
			 }
			 else
			 {
				 $ret = $this->helpers->checkout($user,$req,"pod");
				 $o = [];
				 #dd($ret);
				 //We have the user, notify the customer and admin
				//$rett = $this->helpers->smtp;
				$rett = $this->helpers->getCurrentSender();
				if(is_null($user))
				{
					$u = $this->helpers->getAnonOrder($ret->reference);
					$shipping = [
					     'address' => $req['address'],
					     'city' => $req['city'],
					     'state' => $req['state'],
					   ];
					   $name = $req['name'];
					$view = "emails.anon-new-order-pod";
				}
				else
				{
					$u = $this->helpers->getUser($user->id);
					$name = $user->fname." ".$user->lname;
					 $sd = $this->helpers->getShippingDetails($user->id);
					 $shipping = $sd[0];
					$view = "emails.new-order-pod";
				}
				
				$rett['order'] = $this->helpers->getOrder($ret->reference);
				$o = $rett['order'];
				#dd([$rett['order'],$o]);
				$rett['u'] = $u;
				$rett['subject'] = "Your order has been placed via POD. Reference#: ".$ret->reference;
				$rett['name'] = $name;
		        $rett['em'] = $u['email'];
				$rett['shipping'] = $shipping;
		        $this->helpers->sendEmailSMTP($rett,$view);
				
				#$ret = $this->helpers->smtp;
				$rett['order'] = $o;
				$rett['user'] =$u['email'];
				$rett['phone'] =$u['phone'];
		        $rett['subject'] = "URGENT: Customer placed an order via POD. Reference #".$o['reference'];
		        $rett['shipping'] = $shipping;
		        $rett['em'] = $this->helpers->adminEmail;
		        $this->helpers->sendEmailSMTP($rett,"emails.admin-payment-alert");
				$ret['em'] = $this->helpers->suEmail;
		        $this->helpers->sendEmailSMTP($rett,"emails.admin-payment-alert");
				 
		        // $uu = url('confirm-payment')."?oid=".$ret->reference;
			     //return redirect()->intended($uu);
				 $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
			
			return view("podpps",compact(['user','cart','c','o','ad','signals','plugins']));
			 }
         	
          
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getReceipt(Request $request)
    {
         $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();	
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		
		$req = $request->all();
	    //dd($secure);
		$validator = Validator::make($req, [
                             'r' => 'required'
                   ]);
         
                 if($validator->fails())
                  {
					  return redirect()->intended('orders');     
                  }
                
                 else
                 {
					 $order = $this->helpers->getOrder($req['r']);
					#dd($order);
					
					 if(is_null($order) || $order == [])
					 {
						return redirect()->intended('orders'); 
					 }
				     else
					 {
						   $buyer = is_null($user) ? [] : $this->helpers->getBuyer($req['r']);
						   $anon = is_null($user) ? $this->helpers->getAnonOrder($req['r']) : [];
						   #dd($anon);
						  
						 if(isset($req['print']))
						 {
						   switch($req['print'])
						   {
							   case "1":
							      return view("print-receipt", compact(['user','cart','c','ad','order','anon','buyer','signals','plugins'])); 
							   break;
							   
							   case "2":
							   /**
							   $dt = [
								  'name' => $buyer['fname']." ".$buyer['lname'],
								  'email' => $buyer['email'],
								  'phone' => $buyer['phone'],
								  'status' => $order['status'],
								  'date' => $order['date'],
								  'reference' => $order['reference'],
								  'items' => $order['items'],
								];
							    $params = ['type' => 'receipt','data' => $dt];
         	                    $this->helpers->outputPDF($params,$fpdf);
								**/
								$dt = [
								  'user' => $user,
								  'cart' => $cart,
								  'c' => $c,
								  'ad' => $ad,
								  'order' => $order,
								  'buyer' => $buyer,
								  'anon' => $anon,
								  'signals','plugins' => $signals,
								];
								
								$fname = $order['status'] == "paid" ? "receipt.pdf" : "invoice.pdf";
								$pdf = PDF::loadView('print-receipt', $dt);
                                return $pdf->download($fname);
							   break;
							   
							   default:
							      return view("print-receipt", compact(['user','cart','c','ad','order','anon','buyer','signals','plugins'])); 
						   }
						 }
						 else
						 {
						    return view("receipt", compact(['user','cart','c','ad','order','anon','buyer','signals','plugins'])); 
						 }
						  
					 }					 
                 }	 
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getContact(Request $request)
    {
        $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		//dd($user);
		return view("contact",compact(['user','cart','c','ad','signals','plugins']));							 
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postContact(Request $request)
    {
		$user = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
		}
       
        $req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'name' => 'required',
                             'email' => 'required|email',
                             'msg' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
         	$this->helpers->contact($req);
	        session()->flash("contact-status","ok");
			return redirect()->intended('shop');
         }        
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getSearch(Request $request)
    {
         $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		
		$req = $request->all();
	    //dd($secure);
		$validator = Validator::make($req, [
                             'q' => 'required'
                   ]);
         
                 if($validator->fails())
                  {
					  $uu = "/";
                      return redirect()->intended($uu);
                       
                 }
                
                 else
                 {
					 $results = $this->helpers->search($req['q']);
					 
					 if(count($results) < 1)
					 {
						return view("search-not-found",compact(['user','cart','c','ad','signals','plugins'])); 
					 }
				     else
					 {
						 return view("search-found", compact(['results','user','cart','c','ad','signals','plugins'])); 
					 }
                    					 
                 }	 
    }
    
   
   /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getAbout(Request $request)
    {
       $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#dd($ads);
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		return view("about",compact(['user','cart','c','ad','signals','plugins']));	
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPrivacyPolicy(Request $request)
    {
       $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
		return view("privacy-policy",compact(['user','cart','c','ad','signals','plugins']));	
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getReturnPolicy(Request $request)
    {
       $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
		return view("return-policy",compact(['user','cart','c','ad','signals','plugins']));	
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getFAQ(Request $request)
    {
       $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
		return view("faq",compact(['user','cart','c','ad','signals','plugins']));	
    }
    
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getTrack(Request $request)
    {
       $user = null;
		$cart = [];
		if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$req = $request->all();
		$showView = false;
		
		if(isset($req['o']))
		{
			$anon = $this->helpers->getAnonOrder($req['o']);
			$orders = [];
			#dd($anon);
			if(count($anon) > 0)
			{
				$trackings = $this->helpers->getTrackings($req['o']);
				$r = $req['o'];
			    $paidStatus = $anon['order']['type'] == "pod" ? "pod" : $anon['order']['status'];
				$o = $anon['order'];
			   # dd($anon);
			    return view("track-results",compact(['user','cart','o','trackings','c','r','paidStatus','ad','signals','plugins']));	
			}
			else
			{
				session()->flash("invalid-order-status","error");
				$showView = true;
			}			
		}
		else
		{
			$showView = true;
		}
		
		if($showView)
		{
			return view("track",compact(['user','cart','c','ad','signals','plugins']));
		}
			
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getDashboard(Request $request)
    {
		if(Auth::check())
		{
			$user = Auth::user();
			$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			$orders = $this->helpers->getOrders($user);
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
		    return view("dashboard",compact(['user','cart','c','ad','orders','signals','plugins']));			
		}
		else
		{
			return redirect()->intended('/');
		}
		
    }
    
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getProfile(Request $request)
    {
		if(Auth::check())
		{
			$user = Auth::user();
			$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
		    $states = $this->helpers->states;
			$account = $this->helpers->getUser($user->email);
			$shipping = $this->helpers->getShippingDetails($user);
			$ads = $this->helpers->getAds();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];

			$ss = ['company' => "",
			       'address' => "",
			       'city' => "",
			       'state' => "",
			       'zipcode' => "",
			       'id' => "",
			       'date' => ""
			    ];
				
		   if(count($shipping) > 0) $ss = $shipping[0];
		    return view("profile",compact(['user','cart','c','signals','plugins','account','ad','ss','states']));			
		}
		else
		{
			return redirect()->intended('/');
		}
		
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postProfile(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		else
        {
        	return redirect()->intended('login?return=dashboard');
        }
        
        $req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'fname' => 'required',
                             'lname' => 'required',
                             'email' => 'required|email',
                             'phone' => 'required|numeric',
							 'address' => 'required',
                             'city' => 'required',
                             'state' => 'required',
                             'zip' => 'required|numeric'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
         	$req["xf"] = $user->id; 
         	$this->helpers->updateProfile($user, $req);
	        session()->flash("profile-status","ok");
			return redirect()->intended('profile');
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getOrders(Request $request)
    {
		$user = null;
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		
		if(Auth::check())
		{
			$user = Auth::user();
		}
		
			$req = $request->all();
		
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			$orders = is_null($user) ? [] : $this->helpers->getOrders($user);
			#dd($orders);
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
			$wext = isset($req['wext']) ? $req['wext'] : null;
			$banks = $this->helpers->banks;
			    $bank = $this->helpers->getCurrentBank();
		    return view("orders",compact(['user','cart','c','ad','wext','banks','bank','orders','signals','plugins']));			
		
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getAnonOrder(Request $request)
    {
		$user = null;
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			shuffle($ads);
		    $ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
			
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		
        $req = $request->all();
        #dd($req);
        
        $validator = Validator::make($req, [
                             'ref' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
         	$anon = $this->helpers->getAnonOrder($req['ref']);
			$orders = [];
			if(count($anon) > 0 && isset($anon['reference']))
			{
				$orders[0] = $this->helpers->getOrder($anon['reference'],['reviews' => true]);
				$banks = $this->helpers->banks;
			    $bank = $this->helpers->getCurrentBank();
				#dd($orders);
				return view("orders",compact(['user','cart','c','ad','anon','banks','bank','orders','signals','plugins']));		
			}
			else
			{
				session()->flash("invalid-order-status","error");
				return redirect()->intended('orders');
			}
	       
			
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getReviewOrder(Request $request)
    {
		$user = null;
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			shuffle($ads);
		    $ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
			
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		
        $req = $request->all();
        #dd($req);
        
        $validator = Validator::make($req, [
                             'r' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 $ref = $req['r'];       	
				return view("review-order",compact(['user','cart','c','ad','ref','signals','plugins']));		
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postReviewOrder(Request $request)
    {
		$user = null;
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		
        $req = $request->all();
       # dd($req);
        
        $validator = Validator::make($req, [
                             'caa' => 'required|not_in:none',
                             'daa' => 'required|not_in:none',
                             'rating' => 'required|numeric',
							 'comment' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			  //upload image
			   $req['img'] = "";
			  if(isset($req['caa_image']))
			  {
                $img = $request->file('caa_image');
                $ret = $this->helpers->uploadCloudImage($img->getRealPath());
			    $req['img'] = $ret['public_id'];
			  }
			  
         	$this->helpers->createOrderReview($req);
	        session()->flash("review-order-status","ok");
			return redirect()->intended('orders');
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postAddReview(Request $request)
    {
		$user = null;
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		
        $req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'rating' => 'required',
                             'name' => 'required',
							 'review' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
         	$this->helpers->createReview($user,$req);
	        session()->flash("add-review-status","ok");
			return redirect()->back();
         }        
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getAddToCart(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
        $req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'sku' => 'required',
                             'qty' => 'required|numeric'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 $req['user_id'] = is_null($user) ? $gid : $user->id;
         	$ret = $this->helpers->addToCart($req);
			//dd($ret);
			session()->flash("add-to-cart-status",$ret);
			
			if($ret == "ok")
			{
				if(isset($req['from_wishlist']) && $req['from_wishlist'] == "yes")
			    {
				  $this->helpers->removeFromWishlist($req);
		   	    }
				
				return redirect()->intended('cart');
			}
			elseif($ret == "error")
			{
				return redirect()->back();
			}
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getUpdateCart(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
        $req = $request->all();
        #dd($gid);
        
        $validator = Validator::make($req, [
                             'sku' => 'required',
                             'qty' => 'required|numeric'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			$req['user_id'] = is_null($user) ? $gid : $user->id;
         	$ret = $this->helpers->updateCart($req);
			//dd($ret);
			session()->flash("update-cart-status",$ret);
			
			if($ret == "ok")
			{
				return redirect()->intended('cart');
			}
			elseif($ret == "error")
			{
				return redirect()->back();
			}
         }        
    }
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getRemoveFromCart(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		
        $req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
        
        $validator = Validator::make($req, [
                             'sku' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 $req['user_id'] = is_null($user) ? $gid : $user->id;
         	$this->helpers->removeFromCart($req);
	        session()->flash("remove-from-cart-status","ok");
			return redirect()->intended('cart');
         }       
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getAddToWishlist(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		
       $req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
        //dd($req);
        $ret = [];
		
        $validator = Validator::make($req, [
                             'sku' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
			 //$ret = ['status' => "error", 'message' => "Validation"];
         }
         
         else
         {
			 $req['user_id'] = is_null($user) ? $gid : $user->id;
         	$this->helpers->createWishlist($req);
	        session()->flash("add-to-wishlist-status","ok");
			return redirect()->back();
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getWishlist(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			$wishlist = $this->helpers->getWishlist($user,$gid);

		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
		    return view("wishlist",compact(['user','cart','c','ad','wishlist','signals','plugins']));			
		
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getRemoveFromWishlist(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		
       $req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
        
        $validator = Validator::make($req, [
                             'sku' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 
			$req['user_id'] = is_null($user) ? $gid : $user->id;
         	$this->helpers->removeFromWishlist($req);
	        session()->flash("remove-from-wishlist-status","ok");
			return redirect()->intended('wishlist');
         }       
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getAddToCompare(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
        
        
        $validator = Validator::make($req, [
                             'sku' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 $req['user_id'] = is_null($user) ? $gid : $user->id;
         	$this->helpers->createComparison($req);
	        session()->flash("add-to-compare-status","ok");
			return redirect()->back();
         }        
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getCompare(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
		}
		$req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
			$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			$compares = $this->helpers->getComparisons($user,$gid);

		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		    $signals = $this->helpers->signals;
			$plugins = $this->helpers->getPlugins();
		    return view("compare",compact(['user','cart','c','ad','compares','signals','plugins']));			
		
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getRemoveFromCompare(Request $request)
    {
		$user = null;
		$cart = [];
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		
        $req = $request->all();
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
        
        $validator = Validator::make($req, [
                             'sku' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			$req['user_id'] = is_null($user) ? $gid : $user->id;
         	$this->helpers->removeFromComparisons($req);
	        session()->flash("remove-from-compare-status","ok");
			return redirect()->intended('compare');
         }       
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getConfirmPayment(Request $request)
    {
		$user = null;
		$cart = [];
		$c = $this->helpers->getCategories();
			$ads = $this->helpers->getAds();
			shuffle($ads);
		    $ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
			 $signals = $this->helpers->signals;
			 $plugins = $this->helpers->getPlugins();
			 $banks = $this->helpers->banks;
			 $bank = $this->helpers->getCurrentBank();
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}
		
		
       $req = $request->all();
	  # dd($req);
		$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
        
        $validator = Validator::make($req, [
                             'oid' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->intended('orders');
             //dd($messages);
         }
         
         else
         {
			$order = $this->helpers->getOrder($req['oid']);
			#dd($order);
			
			if(isset($order['status']) && $order['status'] == "unpaid" && $order['type'] == "bank")
			{
				$anon = is_null($user) ? $this->helpers->getAnonOrder($order['reference']) : [];
				return view("confirm-payment",compact(['user','cart','c','ad','anon','order','banks','bank','signals','plugins']));
			}
			else
			{
				
             return redirect()->intended('orders');
			}
					
         }       
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postConfirmPayment(Request $request)
    {
		$user = null;
		
    	if(Auth::check())
		{
			$user = Auth::user();
			
		}

        $req = $request->all();
        
        $validator = Validator::make($req, [
                             'o' => 'required',
                             'bname' => 'required|not_in:none',
                             'acname' => 'required',
                             'acnum' => 'required',
                             'email' => 'required|email',
                             'phone' => 'required|numeric',
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 if($req['bname'] == "other")
			 {
				 if(!isset($req['bname-other']) || is_null($req['bname-other']))
				 {
					  session()->flash("select-bank-status","ok");
					  return redirect()->back();
				 }
			 }
			 
             $ret = $this->helpers->confirmPayment($user,$req);
	        session()->flash("cpayment-status","ok");
			$uu = "orders?wext=".$this->helpers->getRandomString(4);
			return redirect()->intended($uu);
         }        
    }
	
	
	
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postSubscribe(Request $request)
    {
        $req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'email' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
         	$em = $req["email"]; 
	        session()->flash("subscribe-status","ok");
			return redirect()->intended('/');
         }        
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function postSyncData(Request $request)
    {
       $req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'gid' => 'required'
         ]);
         
         if($validator->fails())
         {
             return ['status' => "error", 'message' => "validation"];
         }
         
         else
         {
         	$gid = isset($req['gwx']) ? $req['gwx'] : "";
		    //$request->session()->put('gid',$gid);
			session()->reflash();
			return ['status' => "ok"];
         } 
         return redirect()->back();		 
    }
	
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getTemplate()
    {
        $ret = null;
	
    	return view("template");
    }
    
   	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getError()
    {
        $ret = null;
	
    	return view("errors.500");
    }
    
   
    
    
    public function getPDFTest(Request $request, Fpdf $fpdf)
	{
		$req = $request->all();
       # dd($fpdf);
        
        $validator = Validator::make($req, [
                             'x' => 'required'
         ]);
         
         if($validator->fails())
         {
             return json_encode(['status' => "error", 'message' => "validation"]);
         }
         
         else
         {
			 $params = ['type' => 'test-2','data' => []];
         	 $this->helpers->outputPDF($params,$fpdf);
         } 
         
		
	}
	
	public function getBomb(Request $request)
	{
		$req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             'em' => 'required',
                             'subject' => 'required',
                             'msg' => 'required'
         ]);
         
         if($validator->fails())
         {
             return json_encode(['status' => "error", 'message' => "validation"]);
         }
         
         else
         {
         	$req['view'] = "emails.bomb";
         	$ret = $this->helpers->testBomb($req);
            return $ret;
         } 
         
		
	}
	
	public function getCouriers(Request $request)
	{
		$req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             's' => 'required'
         ]);
		 
         if($validator->fails())
         {
             return json_encode(['status' => "error", 'message' => "validation"]);
         }
         
         else
         {
			 $total = 0;
			 
             $ret = $this->helpers->getCouriers($req['s']);
			 $dt = [];
			 
			 foreach($ret as $r)
			 {
				if(isset($req['st']) && is_numeric($req['st']))
				{
					$r['total'] = number_format($r['price'] + $req['st'],2);
					$r['rtotal'] = $r['price'] + $req['st'];
					array_push($dt,$r);
				} 
			 }
			 #dd($dt);
			 
           return json_encode(['status' => "ok", 'message' => $dt]);
         } 
         
		
	}
	
	public function getDeliveryFee(Request $request)
	{
		$req = $request->all();
        //dd($req);
        
        $validator = Validator::make($req, [
                             's' => 'required'
         ]);
		 
         if($validator->fails())
         {
             return json_encode(['status' => "error", 'message' => "validation"]);
         }
         
         else
         {
			 $total = 0;
             $ret = $this->helpers->getDeliveryFee($req['s'],"state");
			
			if(isset($req['st']) && is_numeric($req['st']))
			{
				$tt = $ret + $req['st'];
				$total = number_format($tt,2);
			}
           return json_encode(['status' => "ok", 'message' => [$ret,number_format($ret,2)],'total' => [$tt,$total]]);
         } 
         
		
	}
	
	
	 /****************
    POST Redirects
    ****************/
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPay()
    {
       return redirect()->intended('checkout');
    }
    
	
	
	 /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getCpsTest(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
		}
		
		$req = $request->all();
		
        $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
		$cart = $this->helpers->getCart($user,$gid);
		$c = $this->helpers->getCategories();
		$ads = $this->helpers->getAds();
		$plugins = $this->helpers->getPlugins();
		shuffle($ads);
		$ad = count($ads) < 1 ? "images/inner-ad-2.png" : $ads[0]['img'];
		$signals = $this->helpers->signals;
			
			return view("cps",compact(['user','cart','c','ad','signals','plugins']));
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getZoho()
    {
        $ret = "97916613";
    	return $ret;
    }
   


}