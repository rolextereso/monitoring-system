// Principal Author: Rolex Tereso
// Email: rolexjun098@gmail.com

(function($) {	
	$.fn.Caption = function(options) {

			var addLocBtnID="add-location",
			    targetID="#location",
			    positionClass=".position",
			    locationContainerID="label-container",
			    msgId="msg",
				addLocationBtn='<div id="control-container">'+
							   '<button class="btn btn-primary" id="'+addLocBtnID+'">+</button>'+
							   '<span id="'+msgId+'"></span>'+
							   '</div>',
				locationContainer='<div id="'+locationContainerID+'"></div>'
				message=[" Click the map to mark the location"," Click the button again to mark another location"];
			

			// Establish our default settings
			var settings = $.extend({
				register_temp: '#register-template',
				closeBtn: '#close-btn',
				registerBtn: '#register-btn',
				editMark:true,
				deleteMark:true,
				addMark:true
			}, options);
							 
			$(".location-position").hide();
			var delete_=(settings.deleteMark)?"<label class='yellow delete_' id='' >&#x2715;</label>":"";		

			return this.each( function() {
				var parent=this;
				loadSaveMarks();//load location marks

				if(settings.addMark){
					$(addLocationBtn).insertBefore(parent);
				}
				$(locationContainer).insertAfter(parent);			

				//if add location is click this method will function
				$("#"+addLocBtnID).click(function(){
					
					removeLocationID();//invoke the function to remove the id attribute	

					// $(parent).css("cursor","crosshair");//cursor pointer to crosshair


					$(this).attr("disabled","disabled");//disabled the add location button 
					$(this).next().html(message[0]).addClass("yellow"); 
					var register_temp=$(settings.register_temp).html();//get the content of register_temp: '#register-template'
				   
					var div= "<div class='position' id='location' style='display:none;'>"+register_temp+"</div>";
					$("#"+locationContainerID).prepend(div);

					var btn_mark=this;
					
					$(targetID+" #closebtn").click(function(){
						 $(targetID).remove();
						 $(btn_mark).removeAttr("disabled");//enable add location btn
						 $("#"+msgId).html(message[1]);

						 //$(parent).css("cursor","pointer");//cursor pointer to pointer

					});

					$(targetID+" #uploadForm").on('submit',(function(e) {
							e.preventDefault();
							
							
							$.ajax({
					        	url: "phpscript/location-map/register.php",
								type: "POST",
								data:  new FormData(this),								
								contentType: false,
					    	    processData:false,
					    	    dataType   : 'json',
								success: function(data)
							    {		
							    							
									$('.alert').removeClass('alert-success, alert-danger')
                                         .addClass(data.type)
                                         .html(data.message)
                                         .fadeIn(100,function(){
                                             $(this).fadeOut(5000);
                                         });


							    	if(data.type=="alert-success"){
										 $("#targetLayer").css('opacity','1');
										
										 var establisment=$(targetID+" #establisment").val()+" "+delete_;
										 $(targetID+" span").html(establisment).attr("id",data.data.id);

										 $(targetID+" .row").remove();
										 appendRegisteredLocation(targetID,data.data.image,data.data.establisment);
										
										 
										 $(btn_mark).removeAttr("disabled");
										 removeLocationID();

										  $("#"+msgId).html(message[1]);
								 	}

								 	delete_loc();
								},
							  	error: function() 
						    	{
						    		alert("Error: Please contact the developer");
						    	} 	        
						   });
					}));
					popup();
				});	

				$(parent).click( function(event) {				
				     $(targetID).show().css( {position:"absolute", top:event.offsetY-17, left: event.offsetX-5}); 				     
					 $(targetID+" #uploadForm #location-mark").val(" top:"+(event.offsetY-17)+"px;left:"+(event.offsetX-5)+"px");

				});			

			});

			function sub_string(str){
				return (str.length>24)?str.substring(0,24)+"...":str;
			}

			function delete_loc(){
				$(".delete_").click(function(){
						var parent=$(this).parent();
						deleteMark(parent.attr('id'));
				});	
			}
			
			function removeLocationID(){
				if($(targetID).length==1){
						 $(positionClass).removeAttr("id");
				}
			}

			function appendRegisteredLocation(targetID,image,establisment){

				var $temp= "<div class='location-position'> "+
									"		<label class=bldgImage style=background-image:url("+image+")></label>"+
									"		<span class='bldgName'>"+sub_string(establisment)+"</span>"+
									"</div> ";
				$(targetID).append($temp);
			}

			function deleteMark(_id){
				$.ajax({
					        	url: "phpscript/location-map/register.php",
								type: "POST",
								data:  {id:_id,indicator:"delete"},
					    	    dataType   : 'json',
								success: function(data)
							    {								    							
									$('.alert').removeClass('alert-success, alert-danger')
                                         .addClass(data.type)
                                         .html(data.message)
                                         .fadeIn(100,function(){
                                             $(this).fadeOut(5000);
                                         });

                                    if(data.type=="alert-success"){
                                    	 var parent=$("#"+_id).parent();
										 parent.remove();
                                    }                                        
								},
							  	error: function() 
						    	{
						    		alert("Error: Please contact the developer");
						    	} 	        
						   });
			}			

			function loadSaveMarks(){

				var $temp="";
				$.getJSON("phpscript/location-map/loadMarks.php", function(data) {
					$.each(data, function(key,value){
                         $temp="<div class='position' style='position: absolute;"+value.position_marks+"'>"+
								     "<span id="+value.id_marks+">"+value.establisment+" "+delete_+"</span>"+
								    "<div class='location-position'> "+
									"		<label class=bldgImage style=background-image:url("+value.image+")></label>"+
									"		<span class='bldgName'>"+sub_string(value.establisment)+" </span>"+
									"</div> ";
								   
							    "</div";
					     $("#"+locationContainerID).prepend($temp);
					});		

					delete_loc();
					popup();
				});
				
			}
			
			function popup(){
				$(".position span").hover(function(){
						$(this).next().stop(true, false).fadeIn();
				},function(){
						$(this).next().stop(true, false).fadeOut();
				});
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
