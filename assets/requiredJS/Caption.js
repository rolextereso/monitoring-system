// Principal Author: Rolex Tereso
// Email: rolexjun098@gmail.com

(function($) {	
	$.fn.Caption = function(options) {

			var addLocBtnID="add-location",
			    targetID="#location",
			    positionClass=".position",
			    locationContainerID="label-container",
				addLocationBtn='<button class="btn btn-primary" id="'+addLocBtnID+'">+</button>',
				locationContainer='<div id="'+locationContainerID+'"></div>';
			

			// Establish our default settings
			var settings = $.extend({
				register_temp: '#register-template',
				closeBtn: '#close-btn',
				registerBtn: '#register-btn'
			}, options);
							 
			$(".location-position").hide();
			return this.each( function() {
				var parent=this;
				
				$(addLocationBtn).insertBefore(parent);
				$(locationContainer).insertAfter(parent);

				$("#"+addLocBtnID).click(function(){
					
					removeLocationID();

					$(this).attr("disabled","disabled");//disabled the add button
					var register_temp=$(settings.register_temp).html();//get the content of register_temp: '#register-template'
				   
					var div= "<div class='position' id='location' style='display:none;'>"+register_temp+"</div>";
					$("#"+locationContainerID).prepend(div);

					var top=this;
					
					$(targetID+" #closebtn").click(function(){
						 $(targetID).remove();
						 $(top).removeAttr("disabled");

					});

					$(targetID+" #uploadForm").on('submit',(function(e) {
							e.preventDefault();
							// alert("hello");
							$.ajax({
					        	url: "phpscript/location-map/upload.php",
								type: "POST",
								data:  new FormData(this),								
								contentType: false,
					    	    processData:false,
								success: function(data)
							    {
									$("#targetLayer").html(data);
									$("#targetLayer").css('opacity','1');
									setInterval(function() {$("#body-overlay").hide(); },500);

									 var establisment=$(targetID+" #establisment").val();
									 $(targetID+" span").html(establisment);
									 appendRegisteredLocation(targetID);
									 //$(targetID+" .row").remove();
									 
									 $(top).removeAttr("disabled");
									 removeLocationID();
								},
							  	error: function() 
						    	{

						    	} 	        
						   });
					}));
						

			

					$(".position span").hover(function(){
						$(this).prev().show();
					},function(){
						$(this).prev().hide();
					});
				
				});	

				$(parent).click( function(event) {				
				     $(targetID).show().css( {position:"absolute", top:event.offsetY-3, left: event.offsetX+7});
				});
				

			});

			function removeLocationID(){
				if($(targetID).length==1){
						 $(positionClass).removeAttr("id");
				}
			}

			function appendRegisteredLocation(targetID){

				var registered=$("#registered-location").html();
				$(targetID).prepend(registered);
			}

			
	};

}(jQuery));

function showPreview(objFileInput) {
		    if (objFileInput.files[0]) {
		        var fileReader = new FileReader();
		        fileReader.onload = function (e) {
		            $("#targetLayer").html('<img src="'+e.target.result+'" width="150px" height="150px" class="upload-preview" />');
					$("#targetLayer").css('opacity','0.7');
					$(".icon-choose-image").css('opacity','0.5');
		        }
				fileReader.readAsDataURL(objFileInput.files[0]);
		    }
}
