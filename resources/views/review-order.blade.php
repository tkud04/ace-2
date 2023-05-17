@extends('layout')

@section('title',"Leave A Review")

@section('styles')
  <!-- DataTables CSS -->
  <link href="lib/datatables/css/buttons.bootstrap.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" /> 
@stop

@section('content')
<?php
$legendText = "leave a review about order ".$ref." below";
?>
   <!--start of middle sec-->
<div class="middle-sec wow fadeIn animated animated" data-wow-offset="10" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s;">
    <div class="page-header">
      <div class="container text-center">
        <h2 class="text-primary text-uppercase">review orders</h2>		
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
                <li class="active">review order</li>
              </ol>
            </div>
			<div class="col-sm-12">
			      <form role="form" action="{{url('review-order')}}" method="post" enctype="multi-part/formdata">
					  {!! csrf_field() !!}
					  <input type="hidden" id="ovr-2" name="rating">
					  <input type="hidden" name="ref" value="{{$ref}}">
					  <fieldset class="col-md-12">
                        <legend>{{$legendText}}</legend>
                        
                        <!--  -->
                         <div class="row">
                          <div class="col-sm-6 form-group">
                            <label class="control-label">Did the product(s) come as expected? <span class="req">*</span></label>
                            <select class="form-control" name="caa">
							   <option value="none">Select an option</option>
							   <option value="yes">Yes</option>
							   <option value="no">No</option>
							</select>                        
						  </div>
						  
						  <div class="col-sm-6 form-group">
                            <label class="control-label">Was the order delivered during the time frame advertised? <span class="req">*</span></label>
                            <select class="form-control" name="daa">
							   <option value="none">Select an option</option>
							   <option value="yes">Yes</option>
							   <option value="no">No</option>
							</select>                        
						  </div>
						  <!--
						    <div class="col-sm-6 form-group">
                            <label class="control-label">upload a pic of your order</label>
                            <input type="file" name="caa_image" class="form-control">                     
						  </div>
						  -->
						  <div class="col-sm-6 form-group">
                            <label class="control-label">Rate your order: <span id="ovr" class="large-text">0</span></label>
							<p class="form-control-plaintext">
							 <?php
							   for($i = 0; $i < 5; $i++)
							   {
								   $iru = "setRating(".($i+1).")";
							 ?>
                             <a id="rbn-{{$i}}" href="javascript:void(0)" onclick="{{$iru}}" class="fa fa-star-o large-text"></a>   
							 <?php
							   }
							 ?>
                            </p>							 
						  </div>
						  
						  <div class="col-sm-12 form-group">
                            <label class="control-label" for="mail">your comment <span class="req">*</span></label>
                            <textarea name="comment" class="form-control" rows="10" placeholder="Your comment.."></textarea>                     
						  </div>
						 
                         </div>
					 </fieldset>
					 
					 <div class="row" style="margin-bottom: 20px;">
					  <div class="col-sm-12">
					    <input type="submit" class="btn btn-primary" value="Submit">
					  </div>
					</div>
				  </form>
			    </div>
			
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
