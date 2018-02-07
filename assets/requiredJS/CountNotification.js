$(document).ready(function(){
		$request();
});

var rented_items;
var onprocess_request;
var unpaid_transaction;
var $request=function(){
		$.when(this).done(function(r){
			 $.ajax({
				  type: "POST",
			      url: 'phpscript/notification/getCounts.php',
			      dataType   : 'json',
			      success: function (data)
			      {
			      		 
			      		  if(data.rented_items>0 && data.rented_items!=rented_items){
			      		  	 rented_items=data.rented_items;
			      		  	
			      		  	  //notification for on rented items
			      		  	 $(".rented_items").show().removeClass('bounceIn animated').addClass('bounceIn animated').text(data.rented_items);
			      		  }else if(data.rented_items==0){
			      		  	 $(".rented_items").removeClass('bounceIn animated').hide();
			      		  }

			      		   //notification for on process request
			      		  if(data.onprocess_request>0 && data.onprocess_request!=onprocess_request){
			      		  	 onprocess_request=data.onprocess_request;
			      		  
			      		  	 $(".onprocess_request").show().removeClass('bounceIn animated').addClass('bounceIn animated').text(data.onprocess_request);
			      		  }else if(data.onprocess_request==0){
			      		  	 $(".onprocess_request").removeClass('bounceIn animated').hide();
			      		  }

			      		  //notification for unpaid transaction
			      		  if(data.unpaid_transaction>0 && data.unpaid_transaction!=unpaid_transaction){
			      		  	 unpaid_transaction=data.unpaid_transaction;
			   
			      		  	 $(".unpaid_transaction").show().removeClass('bounceIn animated').addClass('bounceIn animated').text(data.unpaid_transaction);
			      		  }else if(data.unpaid_transaction==0){
			      		  	 $(".unpaid_transaction").removeClass('bounceIn animated').hide();
			      		  }


			              setTimeout(function() { $request(); },5000);                     
			      }
			  }); 
		})
	// POST values in the background the the script URL
	  

}