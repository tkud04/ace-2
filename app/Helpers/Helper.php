<?php
namespace App\Helpers;

use App\Helpers\Contracts\HelperContract; 
use Crypt;
use Carbon\Carbon; 
use Mail;
use Auth;
use \Swift_Mailer;
use \Swift_SmtpTransport;
use App\Models\ShippingDetails;
use App\Models\User;
use App\Models\Carts;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Discounts;
use App\Models\ProductData;
use App\Models\ProductImages;
use App\Models\Reviews;
use App\Models\Ads;
use App\Models\Banners;
use App\Models\AnonOrders;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Trackings;
use App\Models\Wishlists;
use App\Models\Senders;
use App\Models\Settings;
use App\Models\Plugins;
use App\Models\Couriers;
use App\Models\Comparisons;
use App\Models\Guests;
use App\Models\OrderReviews;
use \Cloudinary\Api;
use \Cloudinary\Api\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Codedge\Fpdf\Fpdf\Fpdf;

class Helper implements HelperContract
{    

    public $signals = ['okays'=> ["login-status" => "Welcome back!",            
    "signup-status" => "Welcome to your new account. As a welcome gift you get a discount N500 off your first order. Enjoy your shopping!",
    "profile-status" => "Profile updated!",
    "cpayment-status" => "Your request has been received, you will be notified via email shortly if your payment has been cleared.",
    "update-status" => "Account updated!",
    "config-status" => "Config added/updated!",
    "contact-status" => "Message sent! Our customer service representatives will get back to you shortly.",
    "add-review-status" => "Thanks for your feedback! It will be visible after review by admins",
    "add-to-cart-status" => "Added to cart!",
    "update-cart-status" => "Cart updated!",
    "remove-from-cart-status" => "Removed from cart!",
    "subscribe-status" => "Subscribed!",
    "pay-card-status" => "Payment successful! Your order is being processed.",
    "pay-bank-status" => "Payment successful! Your order is being processed.",
    "add-to-wishlist-status" => "Added to wishlist!",
    "add-to-compare-status" => "Added to compare list!",
    "remove-from-wishlist-status" => "Removed from wishlist!",
    "remove-from-compare-status" => "Removed from compare list!",
    "select-bank-status" => "Please select your bank",					 
    "no-cart-status" => "Your cart is empty.",
    "invalid-order-status" => "We couldn't find your order.",
    "review-order-status" => "Thank you for your review!",
    ],
    'errors'=> ["login-status-error" => "Wrong username or password, please try again.",
    "signup-status-error" => "There was a problem creating your account, please try again.",
    "profile-status-error" => "There was a problem updating your profile, please try again.",
    "update-status-error" => "There was a problem updating the account, please try again.",
    "contact-status-error" => "There was a problem sending your message, please try again.",
    "add-review-status-error" => "There was a problem sending your review, please try again.",
    "add-to-cart-status-error" => "Stock not sufficient.",
    "update-cart-status-error" => "Stock not sufficient.",
    "remove-from-cart-status-error" => "There was a problem removing this product from your cart, please try again.",
    "subscribe-status-error" => "There was a problem subscribing, please try again.",
    "pay-card-status-error" => "There was a problem making payment, please try again.",
    "pay-bank-status-error" => "There was a problem making payment, please try again.",
    "add-to-compare-status-error" => "There was a problem adding to compare list.",
    "add-to-wishlist-status-error" => "There was a problem adding to wishlist.",
    "remove-from-wishlist-status-error" => "There was a problem removing item from wishlist.",
    "remove-from-compare-status-error" => "There was a problem removing item from compare list.",
    "track-order-status-error" => "Invalid reference number, please try again.",
    "no-cart-status-error" => "Your cart is empty.",
    "invalid-order-status-error" => "We could not find your order.",
   ]
  ];

public $categories = [
'watches' => [
['name' => "Category_1",'url' => "#",'special' => "popular"],
['name' => "Category_2",'url' => "#",'special' => ""],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => "hot"],
['name' => "Category_5",'url' => "#",'special' => ""],
['name' => "Category_6",'url' => "#",'special' => "trending"],
],
'anklets' => [
['name' => "Category_1",'url' => "#",'special' => ""],
['name' => "Category_2",'url' => "#",'special' => ""],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => ""],
['name' => "Category_5",'url' => "#",'special' => "trending"],
['name' => "Category_6",'url' => "#",'special' => ""],
],
'bracelets' => [
['name' => "Category_1",'url' => "#",'special' => ""],
['name' => "Category_2",'url' => "#",'special' => "popular"],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => ""],
['name' => "Category_5",'url' => "#",'special' => ""],
['name' => "Category_6",'url' => "#",'special' => ""],
],
'brooches' => [
['name' => "Category_1",'url' => "#",'special' => ""],
['name' => "Category_2",'url' => "#",'special' => ""],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => "hot"],
['name' => "Category_5",'url' => "#",'special' => ""],
['name' => "Category_6",'url' => "#",'special' => ""],
],
'earrings' => [
['name' => "Category_1",'url' => "#",'special' => ""],
['name' => "Category_2",'url' => "#",'special' => ""],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => ""],
['name' => "Category_5",'url' => "#",'special' => ""],
['name' => "Category_6",'url' => "#",'special' => ""],
],
'necklaces' => [
['name' => "Category_1",'url' => "#",'special' => "hot"],
['name' => "Category_2",'url' => "#",'special' => ""],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => ""],
['name' => "Category_5",'url' => "#",'special' => ""],
['name' => "Category_6",'url' => "#",'special' => ""],
],
'rings' => [
['name' => "Category_1",'url' => "#",'special' => ""],
['name' => "Category_2",'url' => "#",'special' => ""],
['name' => "Category_3",'url' => "#",'special' => ""],
['name' => "Category_4",'url' => "#",'special' => ""],
['name' => "Category_5",'url' => "#",'special' => ""],
['name' => "Category_6",'url' => "#",'special' => "trending"],
]
];

public $categories_2 = ['watches' => "Watches",
                 'anklets' => "Anklets",
                 'bracelets' => "Bracelets",
                 'brooches' => "Brooches",
                 'earrings' => "Ear Rings",
                 'necklaces' => "Necklaces",
                 'rings' => "Rings"
                 ];


public $states = [
                  'abia' => 'Abia',
                  'adamawa' => 'Adamawa',
                  'akwa-ibom' => 'Akwa Ibom',
                  'anambra' => 'Anambra',
                  'bauchi' => 'Bauchi',
                  'bayelsa' => 'Bayelsa',
                  'benue' => 'Benue',
                  'borno' => 'Borno',
                  'cross-river' => 'Cross River',
                  'delta' => 'Delta',
                  'ebonyi' => 'Ebonyi',
                  'enugu' => 'Enugu',
                  'edo' => 'Edo',
                  'ekiti' => 'Ekiti',
                  'gombe' => 'Gombe',
                  'imo' => 'Imo',
                  'jigawa' => 'Jigawa',
                  'kaduna' => 'Kaduna',
                  'kano' => 'Kano',
                  'katsina' => 'Katsina',
                  'kebbi' => 'Kebbi',
                  'kogi' => 'Kogi',
                  'kwara' => 'Kwara',
                  'lagos' => 'Lagos',
                  'nasarawa' => 'Nasarawa',
                  'niger' => 'Niger',
                  'ogun' => 'Ogun',
                  'ondo' => 'Ondo',
                  'osun' => 'Osun',
                  'oyo' => 'Oyo',
                  'plateau' => 'Plateau',
                  'rivers' => 'Rivers',
                  'sokoto' => 'Sokoto',
                  'taraba' => 'Taraba',
                  'yobe' => 'Yobe',
                  'zamfara' => 'Zamfara',
                  'fct' => 'FCT'  
];  

/**






















**/

public $banks = [
'access' => "Access Bank", 
'citibank' => "Citibank", 
'diamond-access' => "Diamond-Access Bank", 
'ecobank' => "Ecobank", 
'fidelity' => "Fidelity Bank", 
'fbn' => "First Bank", 
'fcmb' => "FCMB", 
'globus' => "Globus Bank", 
'gtb' => "GTBank", 
'heritage' => "Heritage Bank", 
'jaiz' => "Jaiz Bank", 
'keystone' => "KeyStone Bank", 
'polaris' => "Polaris Bank", 
'providus' => "Providus Bank", 
'stanbic' => "Stanbic IBTC Bank", 
'standard-chartered' => "Standard Chartered Bank", 
'sterling' => "Sterling Bank", 
'suntrust' => "SunTrust Bank", 
'titan-trust' => "Titan Trust Bank", 
'union' => "Union Bank", 
'uba' => "UBA", 
'unity' => "Unity Bank", 
'wema' => "Wema Bank", 
'zenith' => "Zenith Bank"
];			

public $ip = "";

public $smtp = [
'ss' => "smtp.gmail.com",
'sp' => "587",
'sec' => "tls",
'sa' => "yes",
'su' => "aceluxurystoree@gmail.com",
'spp' => "Ace12345$",
'sn' => "Ace Luxury Store",
'se' => "aceluxurystoree@gmail.com"
];
//ace yahoo
//pass: Eca12345$





//public $suEmail = "aquarius4tkud@yahoo.com";
public $adminEmail = "support@aceluxurystore.com";
public $suEmail = "aceluxurystore@yahoo.com";

public $newUserDiscount = "500";


#{'msg':msg,'em':em,'subject':subject,'link':link,'sn':senderName,'se':senderEmail,'ss':SMTPServer,'sp':SMTPPort,'su':SMTPUser,'spp':SMTPPass,'sa':SMTPAuth};
function sendEmailSMTP($data,$view,$type="view")
{
  // Setup a new SmtpTransport instance for new SMTP
$transport = "";
if($data['sec'] != "none") $transport = new Swift_SmtpTransport($data['ss'], $data['sp'], $data['sec']);

else $transport = new Swift_SmtpTransport($data['ss'], $data['sp']);

if($data['sa'] != "no"){
 $transport->setUsername($data['su']);
 $transport->setPassword($data['spp']);
}
// Assign a new SmtpTransport to SwiftMailer
$smtp = new Swift_Mailer($transport);

// Assign it to the Laravel Mailer
Mail::setSwiftMailer($smtp);

$se = $data['se'];
$sn = $data['sn'];
$to = $data['em'];
$subject = $data['subject'];
  if($type == "view")
  {
    Mail::send($view,$data,function($message) use($to,$subject,$se,$sn){
          $message->from($se,$sn);
          $message->to($to);
          $message->subject($subject);
         if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
         {
             foreach($data["attachments"] as $a) $message->attach($a);
         } 
         $message->getSwiftMessage()
         ->getHeaders()
         ->addTextHeader('x-mailgun-native-send', 'true');
    });
  }

  elseif($type == "raw")
  {
    Mail::raw($view,$data,function($message) use($to,$subject,$se,$sn){
           $message->from($se,$sn);
          $message->to($to);
          $message->subject($subject);
          if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
         {
             foreach($data["attachments"] as $a) $message->attach($a);
         } 
    });
  }
}

function bomb($data) 
{
$url = $data['url'];

  $client = new Client([
// Base URI is used with relative requests
'base_uri' => 'https://mail.aceluxurystore.com',
// You can set any number of default request options.
//'timeout'  => 2.0,
'headers' => isset($data['headers']) && count($data['headers']) > 0 ? $data['headers'] : []
]);
 

$dt = [
   
];

if(isset($data['auth']))
{
    $dt['auth'] = $data['auth'];
}
if(isset($data['data']))
{
   if(isset($data['type']) && $data['type'] == "raw")
   {
     $dt['body'] = $data['data'];
   }
   else
   {
     $dt['multipart'] = [];
     foreach($data['data'] as $k => $v)
     {
       $temp = [
         'name' => $k,
         'contents' => $v
        ];
        
        array_push($dt['multipart'],$temp);
     }
     
      if(isset($data['atts']))
      {
          foreach($data['atts'] as $a)
          {
              $n = $a['name']; $r = $a['content']; 
              $temp = [
                 'name' => 'attachment',
                 'filename' => $n,
                 'contents' => Psr7\Utils::tryFopen($r, 'r')
              ];
        
              array_push($dt['multipart'],$temp);
          }
      }
   }
  
}


try
{
   # dd($dt);
   $res = $client->request(strtoupper($data['method']),$url,$dt);
   $ret = $res->getBody()->getContents(); 
  //dd($ret);

}
catch(RequestException $e)
{
   dd($e);
   # $mm = (is_null($e->getResponse())) ? null: Psr7\str($e->getResponse());
    $mm = (is_null($e->getResponse())) ? null: $e->getResponse();
    $ret = json_encode(["status" => "error","message" => $mm]);
}
$rett = json_decode($ret);
return $ret; 
}


function text($user,$data) 
{
//form query string
// $qs = "sn=".$data['sn']."&sa=".$data['sa']."&subject=".$data['subject'];

$lead = $data['to'];

if($lead == null)
{
   $ret = json_encode(["status" => "ok","message" => "Invalid number"]);
}
else
{ 
 
 //Send request to nodemailer
// $url = "https://radiant-island-62350.herokuapp.com/?".$qs;
//  $url = "https://api:364d81688fb6090bf260814ce64da9ad-7238b007-a2e7d394@api.mailgun.net/v3/mailhippo.tk/messages";
  $url = "https://smartsmssolutions.com/api/".env('TWILIO_SID', '')."/Messages.json";


$client = new Client([
// Base URI is used with relative requests
'base_uri' => 'http://httpbin.org',
// You can set any number of default request options.
//'timeout'  => 2.0,
'headers' => [
    'MIME-Version' => '1.0',
    'Content-Type'     => 'text/html; charset=ISO-8859-1',           
   ]
]);
 

$dt = [
  'auth' => [env('TWILIO_SID', ''),env('TWILIO_TOKEN', '')],
   'multipart' => [
      [
         'name' => 'sender',
         'contents' => "Etuk NG"
      ],
      [
         'name' => 'token',
         'contents' => env('SMARTSMS_API_X_KEY', '')
      ],
      [
         'name' => 'to',
         'contents' => $data['to']
      ],
      [
         'name' => 'message',
         'contents' => $data['msg']
      ],
      [
         'name' => 'routing',
         'contents' => "2"
      ],
      [
         'name' => 'type',
         'contents' => "0"
      ]
   ]
];


try
{
  //$res = $client->request('POST', $url,['json' => $dt]);
  $res = $client->request('POST', $url,$dt);

  $ret = $res->getBody()->getContents(); 
  
/*******************
"""
{
"id": "<20191212163843.1.FF7C9DD921606F44@mg.btbusinesss.com>",
"message": "Queued. Thank you."
}
********************/
}
catch(RequestException $e)
{
    $mm = (is_null($e->getResponse())) ? null: Psr7\str($e->getResponse());
    $ret = json_encode(["status" => "error","message" => $mm]);
}

$rett = json_decode($ret);
if($rett->status == "queued" || $rett->status == "ok")
{
    $nb = $user->balance - 1;
    $user->update(['balance' => $nb]);
   //  $this->setNextLead();
   //$lead->update(["status" =>"sent"]);					
}
/**

else
{
   // $lead->update(["status" =>"pending"]);
}**/
}

return $ret; 
}

function signInAsGuest($data)
{


$uu = User::where('phone',$data['phone'])
       ->where('password',$data['phone']."@aceluxurystore.com")->first();
$remember = true;			

// dd($uu);
if(is_null($uu))
{
   $uu = $this->createUser($data);
}


return $uu;
}

function createUser($data)
{
$ret = User::create(['fname' => $data['fname'], 
                                     'lname' => $data['lname'], 
                                     'email' => $data['email'], 
                                     'phone' => $data['phone'], 
                                     'role' => $data['role'], 
                                     'status' => $data['status'], 
                                     'verified' => $data['verified'], 
                                     'account_status' => $data['account_status'], 
                                     'password' => bcrypt($data['pass']), 
                                     ]);
                                     
return $ret;
}

function getSetting($id)
{
$temp = [];
$s = Settings::where('id',$id)
    ->orWhere('name',$id)->first();

if($s != null)
{
     $temp['name'] = $s->name; 
      $temp['value'] = $s->value;                  
      $temp['id'] = $s->id; 
      $temp['date'] = $s->created_at->format("jS F, Y"); 
      $temp['updated'] = $s->updated_at->format("jS F, Y"); 
  
}      
return $temp;            	   
}

function createShippingDetails($data)
{
$zip = isset($data['zip']) ? $data['zip'] : "";
$ret = ShippingDetails::create(['user_id' => $data['user_id'],                                                                                                          
                                     'company' => $data['company'], 
                                     'zipcode' => $zip,                                                      
                                     'address' => $data['address'], 
                                     'city' => $data['city'], 
                                     'state' => $data['state'], 
                                     ]);
                                     
return $ret;
}


function getCart($user,$r="")
{
$ret = [];
$uu = "";		

if(is_null($user))
{
$uu = $r;
}
else
{
$uu = $user->id;

//check if guest mode has any cart items
$guestCart = Carts::where('user_id',$r)->get();
//dd($guestCart);
if(count($guestCart) > 0)
{
   foreach($guestCart as $gc)
   {
       $temp = ['user_id' => $uu,'sku' => $gc->sku,'qty' => $gc->qty];
       $this->addToCart($temp);
       $gc->delete();
   }
}				
}

$cart = Carts::where('user_id',$uu)->get();
#dd($uu);
if($cart != null)
{
  foreach($cart as $c) 
   {
       $temp = [];
       $temp['id'] = $c->id; 
       $temp['user_id'] = $c->user_id; 
       $temp['product'] = $this->getProduct($c->sku); 
       $temp['qty'] = $c->qty; 
       array_push($ret, $temp); 
  }
}                                 
           
return $ret;
}
function clearCart($user)
{
$uu = "";
if(is_null($user))
{
 $uu = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
}
else
{
$uu = $user->id;  
}

$ret = [];
$cart = Carts::where('user_id',$uu)->get();

if($cart != null)
{
  foreach($cart as $c) 
   {
       $c->delete(); 
  }
}                                 
}


function getUser($id)
{
$ret = [];
$u = User::where('email',$id)
       ->orWhere('id',$id)->first();

if($u != null)
{
      $temp['fname'] = $u->fname; 
      $temp['lname'] = $u->lname; 
      //$temp['wallet'] = $this->getWallet($u);
      $temp['phone'] = $u->phone; 
      $temp['email'] = $u->email; 
      $temp['role'] = $u->role; 
      $temp['status'] = $u->status; 
      $temp['verified'] = $u->verified; 
      $temp['account_status'] = $u->account_status; 
      $temp['id'] = $u->id; 
      $temp['date'] = $u->created_at->format("jS F, Y"); 
      $ret = $temp; 
}                          
                                     
return $ret;
}


function getShippingDetails($user)
{
$ret = [];
$uid = isset($user->id) ? $user->id: $user;
$sdd = ShippingDetails::where('user_id',$uid)->get();

if($sdd != null)
{
  foreach($sdd as $sd)
  {
     $temp = [];
         $temp['company'] = $sd->company; 
      $temp['address'] = $sd->address; 
      $temp['city'] = $sd->city;
      $temp['state'] = $sd->state; 
      $temp['zipcode'] = $sd->zipcode; 
      $temp['id'] = $sd->id; 
      $temp['date'] = $sd->created_at->format("jS F, Y"); 
      array_push($ret,$temp); 
  }
}                         
                                     
return $ret;
}


function updateProfile($user, $data)
{  
$ret = 'error'; 

if(isset($data['xf']))
{
  $u = User::where('id', $data['xf'])->first();
  
       if($u != null && $user == $u)
       {
           $role = $u->role;
           if(isset($data['role'])) $role = $data['role'];
           $status = $u->status;
           if(isset($data['status'])) $role = $data['status'];
           
           $u->update(['fname' => $data['fname'],
                             'lname' => $data['lname'],
                             'email' => $data['email'],
                             'phone' => $data['phone'],
                             'role' => $role,
                             'status' => $status,
                             #'verified' => $data['verified'],
                          ]);
                          
           $this->updateShippingDetails($user,$data);
                          
                          $ret = "ok";
       }                                    
}                                 
 return $ret;                               
}

function updateShippingDetails($user, $data)
{		
$company = isset($data['company']) ? $data['company'] : "";
$z = isset($data['zip']) ? $data['zip'] : "";
$xf = isset($data['xf']) ? $data['xf'] : $user->id;

$ss = ShippingDetails::where('user_id', $xf)->first();

if(is_null($ss))
{
   $shippingDetails =  ShippingDetails::create(['user_id' => $user->id,                                                                                                          
                                     'company' => $company, 
                                     'address' => $data['address'],
                                    'city' => $data['city'],
                               'state' => $data['state'],
                             'zipcode' => $z 
                                     ]);	
}
else
{
   $ss->update(['company' => $company, 
                                     'address' => $data['address'],
                                    'city' => $data['city'],
                               'state' => $data['state'],
                             'zipcode' => $z 
                                     ]);	
}
   
}		   

function getProducts($c="all")
{
$ret = [];
$rr = [];
/**
$products = Products::where('qty','>',"0")
                  ->where('status',"enabled")->get();
**/				
#dd($rr);			   

$products = Products::cursor()->filter(function ($p) {
                                           return ($p->qty > 0 && $p->status == "enabled");
                                         });


$products = $products->sortByDesc('created_at');				   



if($products != null)
{
 foreach($products as $p)
 {
        $pp = $this->getProduct($p->id);
        array_push($ret,$pp); 
 }
}                         
                                     
return $ret;
}

function getProductsByCategory($cat)
{
$ret = [];
$pds = ProductData::where('category',$cat)->get();
$pds = $pds->sortByDesc('created_at');	

if($pds != null)
{
 foreach($pds as $p)
 {
     $pp = $this->getProduct($p->sku);
     if($pp['status'] == "enabled" && $pp['qty'] > 0) array_push($ret,$pp);
 }
}                         
                 
return $ret;
}

function getProductsByType($t)
{
//WORK NEEDS TO BE DONE HERE
$ret = [];
$pds = ProductData::where('id','>','0')->get();
$pds = $pds->sortByDesc('created_at');	

if($pds != null)
{
 foreach($pds as $p)
 {
     $pp = $this->getProduct($p->sku);
     if($pp['status'] == "enabled" && $pp['qty'] > 0) array_push($ret,$pp);
 }
}                         
                 
return $ret;
}

function getProduct($id)
{
$ret = [];
$product = Products::where('id',$id)
            ->orWhere('sku',$id)->first();

if($product != null)
{
 $temp = [];
 $temp['id'] = $product->id;
 $temp['name'] = $product->name;
 $temp['shortname'] = strlen($temp['name']) > 12 ? substr($temp['name'],0,12).".." : $temp['name'];
 $temp['sku'] = $product->sku;
 $temp['qty'] = $product->qty;
 $temp['status'] = $product->status;
 $temp['discounts'] = $this->getDiscounts($product->sku);
 $temp['pd'] = $this->getProductData($product->sku);
 $imgs = $this->getImages($product->sku);
 $temp['imggs'] = $this->getCloudinaryImages($imgs);
 $ret = $temp;
}                         
                                     
return $ret;
}

function createDiscount($data)
{
$uid = "";

if($data['type'] == "single") $uid = $data['sku'];
else if($data['type'] == "category") $uid = $data['category'];

$ret = Discounts::create(['uid' => $uid,                                                                                                          
                                     'code' => $data['code'], 
                                     'discount_type' => $data['discount_type'], 
                                     'discount' => $data['discount'], 
                                     'type' => $data['type'], 
                                     'status' => $data['status'], 
                                     ]);
                                     
return $ret;
}

function getDiscounts($id,$type="product")
{
$ret = [];

if($id == "all")
{
$discounts = Discounts::where('id','>',"0")->get();
}
else
{
$discounts = Discounts::where('uid',$id)
            ->orWhere('type',$type)
            ->where('status',"enabled")->get(); 
}


if($discounts != null)
{
 foreach($discounts as $d)
 {
   $temp = [];
   $temp['id'] = $d->id;
   $temp['uid'] = $d->uid;
   $temp['code'] = $d->code;
   $temp['discount_type'] = $d->discount_type;
   $temp['discount'] = $d->discount;
   $temp['type'] = $d->type;
   if($temp['type'] == "category") $temp['category'] = $this->getCategory($temp['uid']);
   $temp['status'] = $d->status;
   array_push($ret,$temp);  
 }
}                         
                                     
return $ret;
}

function getDiscount($id)
{
$ret = [];
$disc = Discounts::where('id',$id)
                ->orWhere('code',$id)->first();              
            
   if($disc != null)
   {
   
           $temp = [];
           $temp['id'] = $disc->id;
           $temp['uid'] = $disc->uid;
           $temp['code'] = $disc->code;
           $temp['discount_type'] = $disc->discount_type;
           $temp['discount'] = $disc->discount;
           $temp['type'] = $disc->type;
           if($temp['type'] == "category") $temp['category'] = $this->getCategory($temp['uid']);
           $temp['status'] = $disc->status;
           $ret = $temp;
   }                      
                                     
return $ret;
}

function getDiscountPrices($amount,$discounts)
{
$newAmount = 0;
       $dsc = [];
    
    if(count($discounts) > 0)
    { 
        foreach($discounts as $d)
        {
            $temp = 0;
            $val = $d['discount'];
            
            switch($d['discount_type'])
            {
                case "percentage":
                  $temp = floor(($val / 100) * $amount);
                break;
                
                case "flat":
                  $temp = $val;
                break;
            }
            
            array_push($dsc,$temp);
        }
    }
  return $dsc;
}


function getProductData($sku)
{
$ret = [];
$pd = ProductData::where('sku',$sku)->first();

if($pd != null)
{
 $temp = [];
 $temp['id'] = $pd->id;
 $temp['sku'] = $pd->sku;
 $temp['amount'] = $pd->amount;
 $temp['description'] = $pd->description;
 $temp['in_stock'] = $pd->in_stock;
 $temp['category'] = $pd->category;
 $ret = $temp;
}                         
                                     
return $ret;
}

function getProductImages($sku)
{
$ret = [];
$pis = ProductImages::where('sku',$sku)->get();


if($pis != null)
{
 foreach($pis as $pi)
 {
   $temp = [];
   $temp['id'] = $pi->id;
   $temp['sku'] = $pi->sku;
   $temp['cover'] = $pi->cover;
   $temp['url'] = $pi->url;
   array_push($ret,$temp);
 }
}                         
                                     
return $ret;
}

function isCoverImage($img)
{
return $img['cover'] == "yes";
}

function getImage($pi)
{
   $temp = [];
$temp['id'] = $pi['id'];
$temp['sku'] = $pi['sku'];
$temp['cover'] = $pi['cover'];
$temp['url'] = $pi['url'];

return $temp;
}

function getImages($sku)
{
$ret = [];
$records = collect($this->getProductImages($sku));
$s = $sku;
$coverImage = $records->first(function ($value, $key) use($s) {
                              return ($value['sku'] == $s) && ($value['cover'] == "yes");
                           });
                         
$otherImages = $records->where('sku',$sku)
                     ->where('cover',"!=","yes");

#dd([$coverImage,$otherImages]);
if($coverImage != null)
{
  $temp = $this->getImage($coverImage);
  array_push($ret,$temp);
}

if($otherImages != null)
{
  foreach($otherImages as $oi)
  {
      $temp = $this->getImage($oi);
      array_push($ret,$temp);
  }
}

return $ret;
}

function getCloudinaryImages($dt)
{
$ret = [];
        
if(count($dt) < 1) { $ret = ["img/no-image.png"]; }

else
{
  $ird = $dt[0]['url'];
  if($ird == "none")
   {
      $ret = ["img/no-image.png"];
   }
  else
   {
      for($x = 0; $x < count($dt); $x++)
        {
            $ird = $dt[$x]['url'];
           $imgg = "https://res.cloudinary.com/dahkzo84h/image/upload/v1585236664/".$ird;
           array_push($ret,$imgg); 
        }
   }
}

return $ret;
}

function getCloudinaryImage($dt)
{
$ret = [];
 //dd($dt);       
if(is_null($dt)) { $ret = "img/no-image.png"; }

else
{
   $ret = "https://res.cloudinary.com/dahkzo84h/image/upload/v1585236664/".$dt;
}

return $ret;
}

function getNewArrivals()
{
$ret = [];
$pdss = ProductData::where('in_stock',"new")->get();
$pdss = $pdss->sortByDesc('created_at');	
$pds = $pdss->chunk(24);
#dd($pds);
if($pds != null)
{
 foreach($pds[0] as $p)
 {
     #dd($p);
     $pp = $this->getProduct($p->sku);
     if($pp['status'] == "enabled" && $pp['qty'] > 0) array_push($ret,$pp);
 }
}                         
                 
return $ret;
}

function getBestSellers()
{
$ret = [];
$pdss = ProductData::where('in_stock',"new")->get();
$pdss = $pdss->sortByDesc('created_at');	
$pds = $pdss->chunk(24);
#dd($pds);
if($pds != null)
{
 foreach($pds[0] as $p)
 {
     #dd($p);
     $pp = $this->getProduct($p->sku);
     if($pp['status'] == "enabled" && $pp['qty'] > 0) array_push($ret,$pp);
 }
}                         
                 
return $ret;
}

function createReview($user,$data)
{
$userId = $user == null ? $this->generateTempUserID() : $user->id;
$ret = Reviews::create(['user_id' => $userId, 
                                     'sku' => $data['sku'], 
                                     'rating' => $data['rating'],
                                     'name' => $data['name'],
                                     'review' => $data['review'],
                                     'status' => "pending",
                                     ]);
                                     
return $ret;
}

function getReviews($sku)
{
$ret = [];
$reviews = Reviews::where('sku',$sku)
               ->where('status',"enabled")->get();
$reviews = $reviews->sortByDesc('created_at');	

if($reviews != null)
{
 foreach($reviews as $r)
 {
     $temp = [];
     $temp['id'] = $r->id;
     $temp['user_id'] = $r->user_id;
     $temp['sku'] = $r->sku;
    $temp['rating'] = $r->rating;
     $temp['name'] = $r->name;
     $temp['review'] = $r->review;
     array_push($ret,$temp);
 }
}                         
                 
return $ret;
}

function getRating($sku)
{
$ret = 0;

$reviews = $this->getReviews($sku);

if($reviews != null && count($reviews) > 0)
{
 $sum = 0; $count = 0;
 foreach($reviews as $r)
 {
     $sum += $r['rating']; ++$count;
 }
 
 if($sum > 0 && $count > 0)
 {
     $ret = floor($sum / $count);
 }				  
}

return $ret;
}

function createOrderReview($data)
{
#  $userId = $user == null ? $this->generateTempUserID() : $user->id;
$ret = OrderReviews::create(['reference' => $data['ref'], 
                                     'caa' => $data['caa'], 
                                     'daa' => $data['daa'],
                                     'caa_img' => $data['img'],
                                     'rating' => $data['rating'],
                                     'comment' => $data['comment'],
                                     'status' => "pending",
                                     ]);
                                     
return $ret;
}

function getOrderReviews($params=[])
{
$ret = [];
$reviews = OrderReviews::where('status',"enabled")->get();
$reviews = $reviews->sortByDesc('created_at');	

if($reviews != null)
{
 foreach($reviews as $r)
 {
     $temp = [];
     $temp['id'] = $r->id;
     $temp['reference'] = $r->reference;
     if(isset($params['order']) && $params['order']) $temp['order'] = $this->getAnonOrder($r->reference);
     $temp['rating'] = $r->rating;
     $temp['caa'] = $r->caa;
     $temp['img'] = $this->getCloudinaryImage($r->caa_img);
    $temp['daa'] = $r->daa;
     $temp['comment'] = $r->comment;
     $temp['status'] = $r->status;
     array_push($ret,$temp);
 }
}                         
                 
return $ret;
}

function getOrderReview($ref,$params=[])
{
$ret = [];
$r = OrderReviews::where('reference',$ref)->first();

if($r != null)
{
 
     $temp = [];
     $temp['id'] = $r->id;
     $temp['reference'] = $r->reference;
     if(isset($params['order']) && $params['order']) $temp['order'] = $this->getOrder($r->reference);
     $temp['rating'] = $r->rating;
     $temp['caa'] = $r->caa;
     $temp['img'] = $this->getCloudinaryImage($r->caa_img);
    $temp['daa'] = $r->daa;
     $temp['comment'] = $r->comment;
     $temp['status'] = $r->status;
     $ret = $temp;
}                         
                 
return $ret;
}

function generateTempUserID()
{
$ret = "user_".getenv("REMOTE_ADDR");
                                     
return $ret;
}

function setIP($ip)
{
$this->ip = $ip;
}

function getIP()
{
$r = new Request();
$i = $r->ip();
dd("i: ".$i);
return $this->ip;
}

function getGuest($ip)
{
$ret = Guests::where('ip',$ip)->first();

if(is_null($ret))
{
  $ret = Guests::create([
    'ip' => $ip,
    'status' => "ok"
  ]);
}

return $ret;
}

function addToCart($data)
{

$userId = $data['user_id'];
$ret = "error";

$c = Carts::where('user_id',$userId)
      ->where('sku',$data['sku'])->first();

$p = Products::where('sku',$data['sku'])->first();

if(!is_null($p))
{
if($data['qty'] <= $p->qty)
{
   
 if(is_null($c))
 {
    $c = Carts::create(['user_id' => $userId, 
                                     'sku' => $data['sku'], 
                                     'qty' => $data['qty']
                                     ]); 
                                     
 }
 else
 {
    $c->update(['qty' => $data['qty']]);
 }
 #dd($c);
 $ret = "ok";
}
}

return $ret;
}

function updateCart($dt)
{
# dd($dt);
 $userId = $dt['user_id'];
$ret = "error";

$c = Carts::where('user_id',$userId)
      ->where('sku',$dt['sku'])->first();
$p = Products::where('sku',$dt['sku'])->first();

if($c != null && $p != null && $p->qty >= $dt['qty'])
{
$c->update(['qty' => $dt['qty']]);				
$ret = "ok";
}        
                                     
return $ret;
}	
function removeFromCart($data)
{
#$ret = ["subtotal" => 0, "delivery" => 0, "total" => 0];
$userId = $data['user_id'];
$cc = Carts::where('user_id', $userId)->get();

if(!is_null($cc))
{
foreach($cc as $c)
           {
               if($c->sku == $data['sku'] || $c->id == $data['sku']){$c->delete(); break; }
           }
}
                    
                                     
return "ok";
}

function getDeliveryFee($u=null,$type="user")
{
$ret = 2000;
$state = "";

switch($type)
{
case "user":
if(!is_null($u))
{
  $shipping = $this->getShippingDetails($u);
  $s = $shipping[0];				  
  $state = $s['state'];
}
break;

case "state":
 $state = $u;
break;				 
}

if($state != null && $state != "")
{
if($state == "ekiti" || $state == "lagos" || $state == "ogun" || $state == "ondo" || $state == "osun" || $state == "oyo") $ret = 1000;   
}


return $ret;
}

function getCartTotals($cart,$discount=[])
{
$ret = ["subtotal" => 0, "delivery" => 0, "items" => 0,'discounts' => []];
$userId = null;

if($cart != null && count($cart) > 0)
{           	
  foreach($cart as $c) 
   {
       $dsc = [];
       
       if(is_null($userId)) $userId = $c['user_id'];
       $amount = $c['product']['pd']['amount'];
       #dd($discount);
       
       if(count($discount) > 0)
       {
       switch($discount['type'])
       {
           case "category":
             if($c['product']['pd']['category'] == $discount['category']['category'])
             {
                 $dsc = $this->getDiscountPrices($amount,[$discount]);
                # dd($dsc);
             }
           break;
           
           case "general":
             
                 $dsc = $this->getDiscountPrices($amount,[$discount]);
                # dd($dsc);
            
           break;
       }
       
       $newAmount = 0;
       if(count($dsc) > 0)
       {
         foreach($dsc as $d)
         {
           if($newAmount < 1)
           {
             $newAmount = $amount - $d;
           }
           else
           {
             $newAmount -= $d;
           }
         }
         $amount = $newAmount;
         array_push($ret['discounts'],$d);	
       }
       }
       $qty = $c['qty'];
       $ret['items'] += $qty;
       $ret['subtotal'] += ($amount * $qty);
                   
   }
   
    $u = User::where('id',$userId)->first();
   #dd([$u,$userId]);
   if($u != null && $u->account_status == "new")
         {
             $newDiscount = $this->getSetting('nud');
             #dd($newDiscount);
           if($ret['subtotal'] > $newDiscount['value'])
           {
               $ret['subtotal'] -= $newDiscount['value'];
               array_push($ret['discounts'],$newDiscount['value']);	
           } 
           
         }
   
 
  $ret['delivery'] = $this->getDeliveryFee($u);
 
}                                 
 # dd($ret);                                  
return $ret;
}

function addCategory($data)
{
$category = Categories::create([
'name' => $data['name'],
'category' => $data['category'],
'special' => $data['special'],
'status' => $data['status'],
]);                          
return $ret;
}

function getCategories()
{
$ret = [];
$categories = Categories::where('id','>','0')->get();
// dd($cart);

if($categories != null)
{           	
  foreach($categories as $c) 
   {
       $temp = [];
       $temp['name'] = $c->name;
       $temp['category'] = $c->category;
       $temp['special'] = $c->special;
       $temp['status'] = $c->status;
       array_push($ret,$temp);
   }
  
}                                 
                                     
return $ret;
}	
function getCategory($id)
{
$ret = [];
$c = Categories::where('id',$id)->first();
// dd($cart);

if($c != null)
{           	
       $temp = [];
       $temp['id'] = $c->id;
       $temp['name'] = $c->name;
       $temp['category'] = $c->category;
       $temp['special'] = $c->special;
       $temp['status'] = $c->status;
       $ret = $temp;
}                                 
                                     
return $ret;
}

function getFriendlyName($n)
{
$rett = "";
$ret = explode('-',$n);
//dd($ret);
if(count($ret) == 1)
{
 $rett = ucwords($ret[0]);
}
elseif(count($ret) > 1)
{
 $rett = ucwords($ret[0]);
 
 for($i = 1; $i < count($ret); $i++)
 {
     $r = $ret[$i];
     $rett .= " ".ucwords($r);
 }
}
return $rett;
}

function createAds($data)
{
$ret = Ads::create(['img' => $data['img'], 
                                     'type' => $data['type'], 
                                     'status' => $data['status'] 
                                     ]);
                                     
return $ret;
}

function getAds($type="wide-ad")
{
$ret = [];
$ads = Ads::where('status',"enabled")
         ->where('type',$type)->get();
#dd($ads);
if(!is_null($ads))
{
  foreach($ads as $ad)
  {
      $temp = [];
      $temp['id'] = $ad->id;
      $img = $ad->img;
      $temp['img'] = $this->getCloudinaryImage($img);
      $temp['type'] = $ad->type;
      $temp['status'] = $ad->status;
      array_push($ret,$temp);
  }
}

return $ret;
}	

function getAd($id)
{
$ret = [];
$ad = Ads::where('id',$id)->first();
#dd($ads);

if(!is_null($ad))
{
      $temp = [];
      $temp['id'] = $ad->id;
      $img = $ad->img;
      $temp['img'] = $this->getCloudinaryImage($img);
      $temp['type'] = $ad->type;
      $temp['status'] = $ad->status;
      $ret = $temp;
}

return $ret;
}		   

function contact($data)
{
#dd($data);
$ret = $this->getCurrentSender();
$ret['data'] = $data;
$ret['subject'] = "New message from ".$data['name'];	

try
{
$ret['em'] = $this->adminEmail;
$this->sendEmailSMTP($ret,"emails.contact");
$ret['em'] = $this->suEmail;
$this->sendEmailSMTP($ret,"emails.contact");
$s = ['status' => "ok"];
}

catch(Throwable $e)
{
#dd($e);
$s = ['status' => "error",'message' => "server error"];
}

return json_encode($s);
}	

function getBanners()
{
$ret = [];
$banners = Banners::where('id',">",'0')
                ->where('status',"enabled")->get();
#dd($ads);
if(!is_null($banners))
{
  foreach($banners as $b)
  {
      $temp = [];
      $temp['id'] = $b->id;
      $img = $b->img;
      $temp['img'] = $this->getCloudinaryImage($img);
      $temp['title'] = $b->title;
      $temp['subtitle'] = $b->subtitle;
      $temp['copy'] = $b->copy;
      $temp['status'] = $b->status;
      array_push($ret,$temp);
  }
}

return $ret;
}

function checkout($u,$data,$type="paystack")
{
//dd($data);
$ret = [];

switch($type)
{
 case "bank":
    $ret = $this->payWithBank($u, $data);
 break;
 case "paystack":
    $ret = $this->payWithPayStack($u, $data);
 break;
 case "pod":
    $ret = $this->payOnDelivery($u, $data);
 break;
}

return $ret;
}

function getRandomString($length_of_string) 
{ 

// String of all alphanumeric character 
$str_result = '0123456789abcdefghijklmnopqrstuvwxyz'; 

// Shufle the $str_result and returns substring of specified length 
return substr(str_shuffle($str_result),0, $length_of_string); 
} 

function getPaymentCode($r=null)
{
$ret = "";

if(is_null($r))
{
  $ret = "ACE_".rand(1,99)."LX".rand(1,99);
}
else
{
  $ret = "ACE_".$r;
}
return $ret;
}

function payWithBank($user, $md)
{	
# dd([$user,$md]);		   
$dt = [];
$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";

if(is_null($user))
{
   $cart = $this->getCart($user,$gid);
   $totals = $this->getCartTotals($cart);
   
   $dt['name'] = $md['name'];
   $dt['email'] = $md['email'];
   $dt['phone'] = $md['phone'];
   $dt['address'] = $md['address'];
   $dt['city'] = $md['city'];
   $dt['state'] = $md['state'];
}
else
{
   $this->updateShippingDetails($user,$md);
}

$dt['amount'] = $md['amount'] / 100;
$dt['courier_id'] = $md['courier'];
  $dt['ref'] = $this->getRandomString(5);
$dt['notes'] = isset($md['notes']) ? $md['notes'] : "";
$dt['payment_type'] = "bank";
$dt['type'] = "bank";
$dt['status'] = "unpaid";

#create order
#dd($dt);
$o = $this->addOrder($user,$dt,$gid);
return $o;
}

function payWithPayStack($user, $payStackResponse)
{ 
$md = $payStackResponse['metadata'];
#dd($md);
$amount = $payStackResponse['amount'] / 100;
$psref = $payStackResponse['reference'];
$ref = $md['ref'];
$type = $md['type'];
$dt = [];

if($type == "checkout"){
  $dt['amount'] = $amount;
$dt['ref'] = $ref;
$dt['notes'] = isset($md['notes']) ? $md['notes'] : "";
$dt['courier_id'] = $md['courier'];
$dt['payment_type'] = "card";
$dt['ps_ref'] = $psref;
$dt['type'] = "card";
$dt['status'] = "paid";

if(is_null($user))
{
   $dt['name'] = $md['name'];
   $dt['email'] = $md['email'];
   $dt['phone'] = $md['phone'];
   $dt['address'] = $md['address'];
   $dt['city'] = $md['city'];
   $dt['state'] = $md['state'];
}
else
{
   $this->updateShippingDetails($user,$md);
}
}

#create order

$this->addOrder($user,$dt);
return ['status' => "ok",'dt' => $dt];
}

function payOnDelivery($user, $md)
{	
#dd([$user,$md]);		   
$dt = [];
$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";

if(is_null($user))
{
   $cart = $this->getCart($user,$gid);
   $totals = $this->getCartTotals($cart);
   #dd($totals);
   $dt['name'] = $md['name'];
   $dt['email'] = $md['email'];
   $dt['phone'] = $md['phone'];
   $dt['address'] = $md['address'];
   $dt['city'] = $md['city'];
   $dt['state'] = $md['state'];
}
else
{
   $this->updateShippingDetails($user,$md);
}

$dt['amount'] = $md['amount'] / 100;
$dt['courier_id'] = $md['courier'];
  $dt['ref'] = isset($md['ref']) ? $md['ref'] : $this->getRandomString(5);
$dt['notes'] = isset($md['notes']) ? $md['notes'] : "";
$dt['payment_type'] = $md["payment_type"];
$dt['type'] = "pod";
$dt['status'] = "pod";

#create order
#dd($dt);
$o = $this->addOrder($user,$dt,$gid);
return $o;
}

function updateStock($s,$q)
{
$p = Products::where('sku',$s)->first();

if($p != null)
{
  $oldQty = ($p->qty == "" || $p->qty < 0) ? 0: $p->qty;
  $qty = $p->qty - $q;
  if($qty < 0) $qty = 0;
  $p->update(['qty' => $qty]);
}
}

function clearNewUserDiscount($u)
{
# dd($user);
if(!is_null($u))
{
$u->update(['account_status' => "old"]);
}
}

function addOrder($user,$data,$gid=null)
{
#dd($data);
$cart = [];
$gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";  
 $order = $this->createOrder($user, $data);

if($user == null && $gid != null) $cart = $this->getCart($user,$gid);
else $cart = $this->getCart($user);
#dd($cart);

#create order details
foreach($cart as $c)
{
  $dt = [];
  $dt['sku'] = $c['product']['sku'];
  $dt['qty'] = $c['qty'];
  $dt['order_id'] = $order->id;
  if($data["status"] == "paid") $this->updateStock($dt['sku'],$dt['qty']);
  $oi = $this->createOrderItems($dt);                    
}

#send transaction email to admin
//$this->sendEmail("order",$order);  


//clear cart
$this->clearCart($user);

//if new user, clear discount
$this->clearNewUserDiscount($user);
return $order;
}

function createOrder($user, $dt)
{
#dd($dt);
$psref = isset($dt['ps_ref']) ? $dt['ps_ref'] : "";

if(is_null($user))
{
  $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
  $anon = AnonOrders::create(['email' => $dt['email'],
                    'reference' => $dt['ref'],
                    'name' => $dt['name'],
                    'phone' => $dt['phone'],
                    'address' => $dt['address'],
                    'city' => $dt['city'],
                    'state' => $dt['state'],
            ]);
  
  $ret = Orders::create(['user_id' => "anon",
                     'reference' => $dt['ref'],
                     'ps_ref' => $psref,
                     'amount' => $dt['amount'],
                     'courier_id' => $dt['courier_id'],
                     'type' => $dt['type'],
                     'payment_type' => $dt['payment_type'],
                     'notes' => $dt['notes'],
                     'status' => $dt['status'],
            ]); 
}

else
{
$ret = Orders::create(['user_id' => $user->id,
                     'reference' => $dt['ref'],
                     'ps_ref' => $psref,
                     'amount' => $dt['amount'],
                     'courier_id' => $dt['courier_id'],
                     'type' => $dt['type'],
                     'payment_type' => $dt['payment_type'],
                     'notes' => $dt['notes'],
                     'status' => $dt['status'],
            ]);   
}

return $ret;
}

function createOrderItems($dt)
{
$ret = OrderItems::create(['order_id' => $dt['order_id'],
                     'sku' => $dt['sku'],
                     'qty' => $dt['qty']
            ]);
return $ret;
}

function getOrderTotals($items,$uid=null)
{
$ret = ["subtotal" => 0, "delivery" => 0, "items" => 0,"discount" => 0];
# dd($items);
$oid = "";

if($items != null && count($items) > 0)
{      
$oid = $items[0]['order_id'];
$o = Orders::where('id',$oid)->first();	

  foreach($items as $i) 
   {
       if(count($i['product']) > 0)
       {
       $amount = $i['product']['pd']['amount'];
       $dsc = $this->getDiscountPrices($amount,$i['product']['discounts']);
       $newAmount = 0;
       if(count($dsc) > 0)
       {
         foreach($dsc as $d)
         {
           if($newAmount < 1)
           {
             $newAmount = $amount - $d;
           }
           else
           {
             $newAmount -= $d;
           }
           $ret['discount'] += $d;
         }
         $amount = $newAmount;
       }
       $qty = $i['qty'];
       $ret['items'] += $qty;
       $ret['subtotal'] += ($amount * $qty);	
      }
 }
   
   if($uid == "anon")
   {
       
   }
   else
   {
       $u = User::where('id',$uid)->first();
       $c = $this->getCourier($o->courier_id);
       #dd([$c,$o]);
       $price = isset($c['price']) ? $c['price'] : 0;
         $ret['delivery'] = $price;
   }
  

 
}                                 
                                     
return $ret;
}

function getOrders($user)
{
$ret = [];

$orders = Orders::where('user_id',$user->id)->get();
$orders = $orders->sortByDesc('created_at');

#dd($uu);
if($orders != null)
{
    foreach($orders as $o) 
   {
       $temp = $this->getOrder($o->reference);
       array_push($ret, $temp); 
   }
}                                 
           
return $ret;
}

function getOrder($ref,$params=[])
{
$ret = [];

$o = Orders::where('id',$ref)
             ->orWhere('reference',$ref)->first();
#dd($o);
if($o != null)
{
 $temp = [];
 $temp['id'] = $o->id;
 $temp['user_id'] = $o->user_id;
 $temp['reference'] = $o->reference;
 $temp['amount'] = $o->amount;
 $temp['type'] = $o->type;
 $temp['courier_id'] = $o->courier_id;
 $c = $this->getCourier($o->courier_id);
 $temp['courier'] = $c;
 $temp['payment_type'] = $o->payment_type;
 $temp['notes'] = $o->notes;
 $temp['status'] = $o->status;
 $temp['items'] = $this->getOrderItems($o->id);
 $temp['totals'] = $this->getOrderTotals($temp['items'],$o->user_id);
 if($o->user_id == "anon")
 {
       $anon = $this->getAnonOrder($o->reference,false);
       
           if($o->type == "admin")
       {
           
       }
           else
       {
             $temp['totals']['delivery'] = $c['price'];  
       }
 }
 if(isset($params['reviews']) && $params['reviews']) $temp['reviews'] = $this->getOrderReview($temp['reference']);
 $temp['date'] = $o->created_at->format("jS F, Y");
 $ret = $temp; 
}                                 
           
return $ret;
}

function getBuyer($ref)
{
$ret = [];

$o = Orders::where('id',$ref)
             ->orWhere('reference',$ref)->first();
#dd($uu);
if($o != null)
{ 
 $ret = $this->getUser($o['user_id']); 
}                                 
           
return $ret;
}


function getOrderItems($id)
{
$ret = [];

$items = OrderItems::where('order_id',$id)->get();
#dd($uu);
if($items != null)
{
    foreach($items as $i) 
   {
       $temp = [];
       $temp['id'] = $i->id; 
       $temp['order_id'] = $i->order_id; 
       $temp['product'] = $this->getProduct($i->sku); 
       $temp['qty'] = $i->qty; 
       array_push($ret, $temp); 
   }
}			   
           
return $ret;
}

function getTrackings($reference="")
{
$ret = [];
if($reference == "") $trackings = Trackings::where('id','>',"0")->get();
else $trackings = Trackings::where('reference',$reference)->get();
$trackings = $trackings->sortByDesc('created_at');

if(!is_null($trackings))
{
  foreach($trackings as $t)
  {
      $temp = [];
      $temp['id'] = $t->id;
      $temp['user_id'] = $t->user_id;
      $temp['reference'] = $t->reference;
      $temp['description'] = $t->description;
      $temp['status'] = $t->status;
      $temp['date'] = $t->created_at->format("jS F, Y h:i A");
      array_push($ret,$temp);
  }
}

return $ret;
}

function createWishlist($dt)
{
$ret = null;

$w = Wishlists::where('user_id',$dt['user_id'])
                   ->where('sku',$dt['sku'])->first();

if(is_null($w))
{
$ret = Wishlists::create(['user_id' => $dt['user_id'],
                     'sku' => $dt['sku']
            ]);
}


return $ret;
}		   

function getWishlist($user,$r)
{
$ret = [];
$uu = null;

if(is_null($user))
{
  $uu = $r;
}
else
{
  $uu = $user->id;
//check if guest mode has any wishlist items
$guestWishlists = Wishlists::where('user_id',$r)->get();
//dd($guestCart);
if(count($guestWishlists) > 0)
{
   foreach($guestWishlists as $gw)
   {
       $temp = ['user_id' => $uu,'sku' => $gw->sku];
       $this->createWishlist($temp);
       $gw->delete();
   }
}  
}


$wishlist = Wishlists::where('user_id',$uu)->get();

if(!is_null($wishlist))
{
  foreach($wishlist as $w)
  {
      $temp = [];
      $temp['id'] = $w->id;
      $temp['product'] = $this->getProduct($w->sku);
      $temp['date'] = $w->created_at->format("jS F, Y h:i A");
      array_push($ret,$temp);
  }
}
//dd($ret);
return $ret;
}

function removeFromWishlist($dt)
{
$ret = [];
$w = Wishlists::where('user_id',$dt['user_id'])
                   ->where('sku',$dt['sku'])->first();

if(!is_null($w))
{
 $w->delete();
}
}


function createComparison($dt)
{
$ret = null;

$c = Comparisons::where('user_id',$dt['user_id'])
                   ->where('sku',$dt['sku'])->first();

if(is_null($c))
{
$ret = Comparisons::create(['user_id' => $dt['user_id'],
                     'sku' => $dt['sku']
            ]);
}

return $ret;
}

function getComparisons($user,$r)
{
$ret = [];

$uu = null;

if(is_null($user))
{
  $uu = $r;
}
else
{
  $uu = $user->id;
//check if guest mode has any compare items
$guestComparisons = Comparisons::where('user_id',$r)->get();
//dd($guestCart);
if(count($guestComparisons) > 0)
{
   foreach($guestComparisons as $gc)
   {
       $temp = ['user_id' => $uu,'sku' => $gc->sku];
       $this->createComparison($temp);
       $gc->delete();
   }
}  
}

$comparisons = Comparisons::where('user_id',$uu)->get();

if(!is_null($comparisons))
{
  foreach($comparisons as $c)
  {
      $temp = [];
      $temp['id'] = $c->id;
      $temp['product'] = $this->getProduct($c->sku);
      $temp['date'] = $c->created_at->format("jS F, Y h:i A");
      array_push($ret,$temp);
  }
}

return $ret;
}

function removeFromComparisons($dt)
{
$ret = [];
$c = Comparisons::where('user_id',$dt['user_id'])
                   ->where('sku',$dt['sku'])->first();

if(!is_null($c))
{
 $c->delete();
}
}	

function search($q)
{
$ret = [];
$uu = null;

$results1 = Products::where('sku',"LIKE","%".$q."%")->get();
$results2 = ProductData::where('description',"LIKE","%".$q."%")
                     ->orWhere('amount',"LIKE","%".$q."%")
                     ->orWhere('in_stock',"LIKE","%".$q."%")
                     ->orWhere('category',"LIKE","%".$q."%")->get();

if(!is_null($results1))
{
  foreach($results1 as $r1)
  {
      $temp = [];
      $temp['product'] = $this->getProduct($r1->sku);
      $temp['rating'] = $this->getRating($r1->sku);
      array_push($ret,$temp);
  }
}

if(!is_null($results2))
{
  foreach($results2 as $r2)
  {
      $temp = [];
      $temp['product'] = $this->getProduct($r2->sku);
       $temp['rating'] = $this->getRating($r2->sku);
      array_push($ret,$temp);
  }
}

//dd($ret);
return $ret;
}

function confirmPayment($u,$data)
{
$o = $this->getOrder($data['o']);
#dd([$u,$data]);
//$ret = $this->smtp;
$ret = $this->getCurrentSender();
$ret['order'] = $o;

if(is_null($u))
{
$ret['user'] = $data['email'];
$md = $this->getAnonOrder($data['o']);
#dd($md);
$shipping = [
        'address' => $md['address'],
        'city' => $md['city'],
        'state' => $md['state'],
      ];
}
else
{
$ret['user'] = $u->email;
$sd = $this->getShippingDetails($u->id);
      $shipping = $sd[0];
}
$ret['subject'] = "URGENT: Confirm payment for order ".$o['reference'];
$ret['acname'] = $data['acname'];
$bname =  $data['bname'] == "other" ? $data['bname-other'] : $this->banks[$data['bname']];
$ret['bname'] = $bname;
$ret['acnum'] = $data['acnum'];
$ret['shipping'] = $shipping;

try
{
$ret['em'] = $this->adminEmail;
$this->sendEmailSMTP($ret,"emails.admin-confirm-payment");
$ret['em'] = $this->suEmail;
$this->sendEmailSMTP($ret,"emails.admin-confirm-payment");
$s = ['status' => "ok"];
}

catch(Throwable $e)
{
#dd($e);
$s = ['status' => "error",'message' => "server error"];
}

return json_encode($s);
}		   

function testBomb($data)
{

//$ret = $this->smtp2;
$ret = $this->getCurrentSender();
$ret['subject'] = $data['subject'];
$ret['em'] = $data['em'];
$ret['msg'] = $data['msg'];

$this->sendEmailSMTP($ret,$data['view']);

return json_encode(['status' => "ok"]);
}

function pdfHeader($ph)
{
$img = public_path()."/images/logoo.png";
$ph->Cell(80);
$ph->Image($img,80,10,50);
$ph->Ln(55);
$ph->SetFont('Arial', 'BU', 18);
$ph->SetX(-60);
$ph->Cell(0, 10, 'Ace Luxury Store',0,1);
$ph->SetFont('Arial', '', 15);
$ph->SetX(-125);
$ph->Cell(0, 10, '3 Oshikomaiya Close, Demurin Road, Ketu, Lagos',0,1);
$ph->SetX(-55);
$ph->Cell(0, 10, '(+234) 809 703 9692',0,1);
$ph->SetFont('Arial', 'IU', 15);
$ph->SetTextColor(0,0,120);
$ph->SetX($ph->GetPageWidth() - ($ph->GetStringWidth('support@aceluxurystore.com') + 5));
$ph->Cell(0, 10, 'support@aceluxurystore.com',0,1);
$ph->Ln(20);
$ph->Line(0,$ph->GetY() - 10,$ph->GetPageWidth(),$ph->GetY() - 10);
}

function pdfFooter($ph)
{
$ph->SetY(-30);
$ph->SetFont('Arial','I',8);
$ph->SetTextColor(128);
$ph->Cell(0,5,'Page '.$ph->PageNo().'/{nb}',0,0,'C');
}

function pdfTable($ph, $header, $data)
{
// Colors, line width and bold font
$ph->SetFillColor(141,154,165);
$ph->SetTextColor(255);
$ph->SetDrawColor(255);
$ph->SetLineWidth(.3);
$ph->SetFont('','B');
// Header
$w = array(10, 95, 20, 45);
for($i=0;$i<count($header);$i++)
$ph->Cell($w[$i],7,$header[$i],1,0,'C',true);
$ph->Ln();
// Color and font restoration
$ph->SetFillColor(224,235,255);
$ph->SetTextColor(0);
$ph->SetFont('');
// Data
$fill = false;
$x = 0;
foreach($data as $i)
{
++$x;
$product = $i['product'];
$sku = $product['sku'];
$qty = $i['qty'];
$pd = $product['pd'];
$pu = url('product')."?sku=".$product['sku'];
$img = $product['imggs'][0];
#dd($img);

$ph->Cell($w[0],6,$x,'LR',0,'L',$fill);
//$ph->Image($img,$w[1],10,50,50,'png');
$ph->Cell($w[1],6,$sku,'LR',0,'L',$fill);
$ph->Cell($w[2],6,$qty,'LR',0,'R',$fill);
$ph->Cell($w[3],6,"N".number_format($pd['amount'] * $qty,2),'LR',0,'R',$fill);
$ph->Ln();
$fill = !$fill;
}
// Closing line
$ph->Cell(array_sum($w),0,'','T');
}

function outputPDF($data,$fpdf)
{	
$dt = $data['data'];
switch($data['type'])
{
case 'test':
$fpdf->AddPage();
$fpdf->SetFont('Arial', 'BU', 18);
$fpdf->Cell(80);
$fpdf->Cell(20, 10, 'Creating PDF documents from helpers up',0,1,'C');
$fpdf->SetFont('Arial', '', 15);
$fpdf->Cell(20, 10, 'Creating PDF documents from helpers');
break;

case 'test-2':
$fpdf->AliasNbPages();
$fpdf->AddPage();
$this->pdfHeader($fpdf);
$fpdf->SetFont('Arial', '', 15);
$fpdf->SetTextColor(0);
$fpdf->Cell(20, 10, 'RECEIPT',0,1);
$fpdf->SetFont('Arial', 'B', 18);
$fpdf->Cell(20, 10, 'John SNow',0,1);
$fpdf->SetFont('Arial', '', 15);
$fpdf->Cell(20, 10, '07054329101',0,1);
$fpdf->SetFont('Arial', 'IU', 15);
$fpdf->SetTextColor(0,0,120);
$fpdf->Cell(20, 10, 'myemail@yahoo.com',0,1);
$this->pdfFooter($fpdf);
break;

case 'receipt':
$rows = [
['1',"item 1 with image","qty 1","amount 1"],
['2',"item 2 with image","qty 2","amount 2"],
['3',"item 3 with image","qty 3","amount 3"],
['4',"item 4 with image","qty 4","amount 4"],
];
$fpdf->AliasNbPages();
$fpdf->AddPage();
$this->pdfHeader($fpdf);
$fpdf->SetFont('Arial', '', 15);
$fpdf->SetTextColor(0);
$fpdf->Cell(20, 10, 'RECEIPT',0,1);
$fpdf->SetFont('Arial', 'B', 18);
$fpdf->Cell(20, 10, $dt['name'],0,1);
$fpdf->SetFont('Arial', '', 15);
$fpdf->Cell(20, 10,  $dt['phone'],0,1);
$fpdf->SetFont('Arial', 'IU', 15);
$fpdf->SetTextColor(0,0,120);
$fpdf->Cell(20, 10,  $dt['email'],0,1);
$fpdf->SetX(-40);
$fpdf->SetFont('Arial', '', 15);
$fpdf->SetTextColor(0);
$fpdf->Cell(0, 10, 'STATUS: '.strtoupper($dt['status']),0,1);
$fpdf->SetX(-83);
$fpdf->SetFont('Arial', '', 13);
$fpdf->SetTextColor(150,150,150);
$fpdf->Cell(0, 10, "Receipt generated on: ".$dt['date'],0,1);
$fpdf->SetX(-50);
$fpdf->Cell(0, 10, "Reference #: ".$dt['reference'],0,1);
$fpdf->Ln();
$fpdf->SetX(0);
$this->pdfTable($fpdf,['#','Items','Qty','Total'],$dt['items']);
$this->pdfFooter($fpdf);

break;
}

$fpdf->Output('D');
}

function checkForUnpaidOrders($u)
{
$ret = Orders::where([
              'user_id' => $u->id,
              'status' => "unpaid",
              'type' => "bank"
            ])->count();
#dd($ret);
return $ret > 0;
}	

function getAnonOrder($id,$all=true)
{
$ret = [];
if($all)
{
$o = AnonOrders::where('reference',$id)->first();
       
$o2 = Orders::where('reference',$id)->first();
       #dd([$o,$o2]);
if($o != null || $o2 != null)
{
  if($o != null)
  {
    $temp['name'] = $o->name; 
      $temp['reference'] = $o->reference; 
      //$temp['wallet'] = $this->getWallet($u);
      $temp['phone'] = $o->phone; 
      $temp['email'] = $o->email; 
      $temp['address'] = $o->address; 
      $temp['city'] = $o->city; 
      $temp['state'] = $o->state; 
      $temp['id'] = $o->id; 
      #dd($o2);
      if($o2 != null) $temp['order'] = $this->getOrder($id);
      $temp['date'] = $o->created_at->format("jS F, Y"); 
      $ret = $temp;  
  }
  else if($o2 != null)
  {
      $u = $this->getUser($o2->user_id);
      $sd = $this->getShippingDetails($u['id']);
      $shipping = $sd[0];
      
     if(count($u) > 0)
      {
        $temp['name'] = $u['fname']." ".$u['lname']; 
        $temp['reference'] = $o2->reference;                 
        $temp['phone'] = $u['phone']; 
        $temp['email'] = $u['email']; 
        $temp['address'] = $shipping['address']; 
        $temp['city'] = $shipping['city']; 
        $temp['state'] = $shipping['state']; 
        $temp['id'] = $o2->id; 
        $temp['order'] = $this->getOrder($id);
        $temp['date'] = $o2->created_at->format("jS F, Y"); 
        $ret = $temp;  
      }  
  }
  
       
}
}

else
{
$o = AnonOrders::where('reference',$id)
       ->orWhere('id',$id)->first();
       
if($o != null)
  {
    $temp['name'] = $o->name; 
      $temp['reference'] = $o->reference; 
      //$temp['wallet'] = $this->getWallet($u);
      $temp['phone'] = $o->phone; 
      $temp['email'] = $o->email; 
      $temp['address'] = $o->address; 
      $temp['city'] = $o->city; 
      $temp['state'] = $o->state; 
      $temp['id'] = $o->id; 
      $temp['date'] = $o->created_at->format("jS F, Y"); 
      $ret = $temp;  
  }
}
                        

$reviews = [];
if(isset($ret['reference'])) $reviews = $this->getOrderReview($ret['reference']);
$ret['reviews'] = $reviews;
return $ret;
}

function isDuplicateUser($data)
{
$ret = false;

$dup = User::where('email',$data['email'])
  ->orWhere('phone',$data['phone'])->get();

if(count($dup) > 0) $ret = true;		
return $ret;
}

function giveDiscount($user,$dt)
{
$ret = $this->createDiscount([
'id' => $user->id,                                                                                                          
'discount_type' => $dt['type'], 
'discount' => $dt['amount'], 
'status' => "enabled",	   
]);
return $ret;
}

function getSender($id)
{
$ret = [];
$s = Senders::where('id',$id)->first();

if($s != null)
{
      $temp['ss'] = $s->ss; 
      $temp['sp'] = $s->sp; 
      $temp['se'] = $s->se;
      $temp['sec'] = $s->sec; 
      $temp['sa'] = $s->sa; 
      $temp['su'] = $s->su; 
      $temp['current'] = $s->current; 
      $temp['spp'] = $s->spp; 
      $temp['type'] = $s->type;
      $sn = $s->sn;
      $temp['sn'] = $sn;
       $snn = explode(" ",$sn);					   
      $temp['snf'] = $snn[0]; 
      $temp['snl'] = count($snn) > 0 ? $snn[1] : ""; 
      
      $temp['status'] = $s->status; 
      $temp['id'] = $s->id; 
      $temp['date'] = $s->created_at->format("jS F, Y"); 
      $ret = $temp; 
}                          
                                     
return $ret;
}

function getCurrentSender()
{
$ret = [];
$s = Senders::where('current',"yes")->first();

if($s != null)
{
  $ret = $this->getSender($s['id']);
}

return $ret;
}
function getCurrentBank()
{
$ret = [];
$s = Settings::where('name',"bank")->first();

if($s != null)
{
  $val = explode(',',$s->value);
  $ret = [
    'bname' => $val[0],
    'acname' => $val[1],
    'acnum' => $val[2]
  ];
}

return $ret;
}

function getPlugins()
{
$ret = [];

$plugins = Plugins::where('id','>',"0")->get();

if(!is_null($plugins))
{
foreach($plugins as $p)
{
if($p->status == "enabled")
{
$temp = $this->getPlugin($p->id);
array_push($ret,$temp); 
}
}
}

return $ret;
}

function getPlugin($id)
{
$ret = [];
$p = Plugins::where('id',$id)->first();

if($p != null)
{
      $temp['name'] = $p->name; 
      $temp['value'] = $p->value; 	   
      $temp['status'] = $p->status; 
      $temp['id'] = $p->id; 
      $temp['date'] = $p->created_at->format("jS F, Y"); 
      $temp['updated'] = $p->updated_at->format("jS F, Y"); 
      $ret = $temp; 
}                          
                                     
return $ret;
}

function getCouriers($s)
{
$ret = [];
$cvg = "";

switch($s)
{
case "lagos":
$cvg = "lagos";
break;

case "ekiti":
case "ogun":
case "oyo":
case "osun":
case "ondo":
$cvg = "sw";
break;
default:
$cvg = "others";
}

$couriers = Couriers::where('coverage',$cvg)
          ->orWhere('coverage',$s)->get();

if(!is_null($couriers))
{
foreach($couriers as $c)
{
$temp = $this->getCourier($c->id);
array_push($ret,$temp);
}
}

return $ret;
}

function getCourier($id)
{
$ret = [];
$c = Couriers::where('id',$id)->first();

if($c != null)
{
      $temp['id'] = $c->id;  
      $temp['status'] = $c->status; 
      $temp['nickname'] = $c->nickname; 
      $temp['name'] = $c->name; 
      $temp['price'] = $c->price; 
      $temp['type'] = $c->type; 
      $temp['coverage'] = $c->coverage; 
      $temp['date'] = $c->created_at->format("jS F, Y"); 
      $temp['updated'] = $c->updated_at->format("jS F, Y"); 
      $ret = $temp; 
}                          
                                     
return $ret;
}

function sendMessage($dt)
{
$ret = ['status' => "error",'msg' => "nothing happened"];
$c = "";

switch($dt['type'])
{
case "contact":
$c = "";
break;
}

$rr = [
'auth' => ["api",env('MAILGUN_API_KEY')],
'data' => [
'from' => "Ace Luxury Store <noreply@aceluxurystore.com>",
'to' => $dt['t'],
'subject' => $dt['s'],
'html' => $c
],
'headers' => [],
'url' => env('MAILGUN_BASE_URL')."/messages",
'method' => "post"
];

$ret2 = $this->bomb($rr);

#dd($ret2);
if(isset($ret2->message) && $ret2->message == "Queued. Thank you.") $ret = ['status' => "ok"];
}

function clearGhostCarts()
{
Carts::where('user_id',"")->delete();
}

function webmailSend($dt)
{
$rr = [
'data' => [
'u' => "admin",
'tk' => "kt",
't' => $dt['t'],
's' => $dt['s'],
'c' => $dt['c']
],
'headers' => [],
'url' => "https://mail.aceluxurystore.com/api/new-message",
'method' => "post"
];

$ret2 = $this->bomb($rr);

dd($ret2);
if(isset($ret2->message) && $ret2->message == "Queued. Thank you.") $ret = ['status' => "ok"];
}         
           
}
?>