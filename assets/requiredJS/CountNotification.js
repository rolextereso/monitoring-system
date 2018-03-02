$(document).ready(function(){
		$request();
		alert_overdue_hover();
});

var rented_items;
var onprocess_request;
var unpaid_transaction;
var over_due_rented;
var $request=function(){
		$.when(this).done(function(r){
			 $.ajax({
				  type: "POST",
			      url: 'phpscript/notification/getCounts.php',
			      dataType   : 'json',
			      success: function (data)
			      {
			      		
			      		  if(data.over_due_rented>0 && data.over_due_rented!=over_due_rented && getCookie("hideAlert")==""){
			      		  	 over_due_rented=data.over_due_rented;
			      		  	  $(".unreturn-item").show();
			      		  	  $(".overdue_rented").html(data.over_due_rented);

			      		  	  alert_overdue_hover();
			      		  	  close();
			      		  }else if(data.over_due_rented==0){
			      		  	  $(".unreturn-item").hide();
			      		  }
			      		 
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

function alert_overdue_hover(){
	$(".unreturn-item").hover(function(){
		$(this).removeClass('bounce');
	},function(){
		$(this).addClass('bounce');
	});
}

function close(){
	$(".unreturn-item .close").click(function(){
		setCookie("hideAlert","hidden",1);
		$(this).parent().hide();
	})
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}