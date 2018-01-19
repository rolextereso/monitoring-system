<?php 
    require_once('layout/header.php');
    require_once('layout/nav.php');
?>  

<style>
  	.position{
	    background: url('img/setting_assets/location-logo.png') no-repeat;
	    background-size: 16px 23px;
	    height: 23px;
		width: 16px;
		z-index: 4;
	}

	.position span{
		margin-left: 16px;
	    width: 300px;
	    position: absolute;
	    font-family: Roboto, Arial, sans-serif;
	   /* -webkit-text-stroke: 0.5px black;*/
	    color:white;
	    font-size: 12px;
	}

	#map:hover{
		cursor: crosshair;
	}

	#add-location{
		   position: absolute;
		   width:auto;
		   margin-top:3px;
		   margin-left:3px;
	}

	.detail{
			height: auto;
		    width: 266px;
		    background: #f6f6f2;
		    margin-top: 0px;
		    opacity: 0.8;
		    margin-left: 18px;
		    border-top: 3px solid #e94b36;

	}

	.inputFile {
		    padding: 5px 0px;
			margin-top:8px;	
		    background-color: #FFFFFF;
		    width: 48px;	
		    overflow: hidden;
			opacity: 0;	
			cursor:pointer;
	}
	#targetOuter{	
			position:relative;
		    text-align: center;
		    background-color: #F0E8E0;
		    margin: 20px auto;
		    width: 150px;
		    height: 150px;
			border-radius: 4px;
	}

	.icon-choose-image {
		    position: absolute;
		    opacity: 0.1;
		    top: 50%;
		    left: 50%;
		    margin-top: -24px;
		    margin-left: -24px;
		    width: 48px;
		    height: 48px;
	}
	.hide-temp{
		display: none;
	}

	.location-position{
		 
	    background:  yellow;
	    height: 66px;
	    width: 278px;
	    position:  absolute;
	    margin-top: -67px;
	    margin-left: 17px;
	    z-index: 3;

	}


</style>

  <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">	 
              
			
			<img src="img/setting_assets/slsu-map.jpg" id="map" />

			<div id="registered-location"  class="hide-temp">
				<div class="location-position">
						<div class="col-sm-3" style="background:blue;height: 100%;">

						</div>

						<div class="col-sm-9">

						</div>
					</div>
			</div>

			
			<div id="register-template" class="hide-temp">
				
					<span></span>
					
					<div class="row detail">
								<div class="col-sm-12">
									<br/>
									<form id="uploadForm" action="post">
			                        <div class="form-group">
			                        	                              
			                              <input class="form-control form-control-sm" id="establisment"  type="text" 
			                              placeholder="Establisment Name"/>
			                        </div>
			                         <div id="targetOuter">
									    
										<div id="targetLayer"></div>
									  	<img src="img/setting_assets/photo.png"  class="icon-choose-image" />
										
										<div class="icon-choose-image" >
										<input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);" />
										</div>
									</div>
			                         <div class="form-row">
	                                              <div class="col-md-6">
	                                                  <button  type="submit" id="registerbtn"  class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Register</button>
	                                              </div>
	                                              <br/><br/>
	                                        
	                                              <div class="col-md-6">
	                                                  <button type="button" id="closebtn" class=" btn btn-danger btn-block"><i class="fa fa-ban" aria-hidden="true"></i> Close</button>
	                                                  <br/> 
	                                              </div>

	                                  </div>
	                                  </form>
			                     </div>

		                    </div> 
	            	                   
			</div>

</main>
	
	<script>
		$(document).ready(function(){
				// $("#label-container .position").hide();
				$("#map").Caption();

				// $("#add-location").click(function(){
				// 	if($("#location").length==1){
				// 		 $(".position").attr("id","");
				// 	}

				// 	$(this).attr("disabled","disabled");
				// 	var register_temp=$("#register-template").html();
				// 	var div= "<div class='position' id='location' style='display:none;'>"+register_temp+"</div>";
				// 	$("#label-container").prepend(div);
				// });


				// $("#map").click( function(event) {				
				//      $("#location").show().css( {position:"absolute", top:event.offsetY-3, left: event.offsetX+7});
				// });
				
		});

		
		
	</script> 
	
<script type="text/javascript" src="assets/requiredJS/Caption.js"></script>

<?php require_once('layout/footer.php');?>    