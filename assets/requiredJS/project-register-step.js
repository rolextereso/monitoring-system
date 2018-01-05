(function($) {			

					$.fn.budget = function( options ) {

						// Establish our default settings
						var settings = $.extend({
							text		 : '',
							dateFrom     : '',
							dateTo       : '',
							steps		 : 1,
							
						}, options);
						var selector=$(this).selector;

						 

						return this.each( function() {
							var parent=this;
							var dates = getDates(new Date(settings.dateFrom), new Date(settings.dateTo));
							populateTbl(dates,settings.text,settings.steps,true,this);

							$('.table-remove').click(function () {
							   $(this).parents('tr').detach();
							   totalAllcol();

							});

							$(selector+' .table-add').click(function () {
							 				
							  var $clone = $(selector).find('table tr.hide').clone(true).removeClass('hide table-line');
							
							  $(selector).find('table').append($clone);
							});

							$(selector+' [contenteditable="true"]:not(._0)').keyup(function (event) {
		                      // skip for arrow keys                     
			                      if (event.which >= 37 && event.which <= 40) {
			                          event.preventDefault();

			                      }
			                   
			                      var currentVal = ($(this).text()=="")? '0':$(this).text();    
			                    
			                      var attr= $(this).attr('class');
			                      totalAmount(attr);

		               		 });

						});


							 function populateTbl(date,title,step,enable,elementP){

									var step1=["Product 1", "Product 2", "Product 3"];
									var step2=["Marketing Expenses",
													"Other Marketing Expenses",
													"Other Related Marketing Expenses",
													"Salaries other than Labor", 
													"Other Administrative Expenses",
													"Registration, Fees, Licenses",
													"Others"];

									function tableData(date, element, editable,footer=false,step=""){
										var btn="<"+element+" data='' class='btn-remove'>";
											btn+=         " <span class='table-remove'>&Cross;</span>";
											
									       	btn+=	 "</"+element+">";

									    var showBtn=(footer)?"<td class='btn-remove'></td>":btn;
										var tag=(editable)? showBtn+"<"+element+" contenteditable='true' class='_0'>"+step+"</"+element+">": "";
																
										var no=1;
											
										date.forEach(function(date) {

											var dates=(editable)? "0":  moment(date).format("MMM YYYY");
											var formatted=(!editable)? "data='"+moment(date).format("YYYY-DD-MM")+"'": "";
											var row_number=(footer)? "t_"+no: (footer==null)?"h_"+no : "_"+no;
											var contenteditable=(editable)?" contenteditable='true' ": "";

									 		 tag+="<"+element+" "+contenteditable+" "+formatted+" class="+row_number+"> "+dates+"</"+element+">";
									 		 no++;
										});
										return tag;
									}

									function loadTableData(step, enable){
										var ret="";
										if(enable){
											if(step==1){
												ret=populateDefault(step1);
											}else if(step==2){
												ret=populateDefault(step2);
											}
											return ret;
										}			

									}

									function populateDefault(step){
										var tb_row="";
										step.forEach(function(step) {
												tb_row+="<tr>";
												tb_row+=tableData(date,"td",true,false,step);//populate data in the body
												tb_row+="</tr>";
										});
										return tb_row;
									}

									var table="<span class='table-add'><i class='fa fa-plus-square'></i> Add Item</span>";
									table+="<table class='table table-dark table-striped'> <tr>";				     
											table+=" <th colspan='2' data='"+title+"'>"+title+"</th>";
									    table+=tableData(date,"th",false,null);	//populate dates for the table
										table+="</tr>";
										table+="<tfoot><tr id='total'>";
										
										table+=tableData(date,"td",true,true); //populate total amount in the footer
										table+="</tr></tfoot>";
										table+="<tbody>";
									
										table+=loadTableData(step, enable);//populate data in the body
									
										table+="<tr class='hide'>";
										  
										table+=tableData(date,"td",true); //this will be generated once click add
										table+="</tr>"

										table+="</tbody>";
										table+="</table>";

										$(elementP).prepend(table);
								};

								// Returns an array of dates between the two dates
								function getDates(startDate, endDate) {
									  var dates = [],
									      currentDate = startDate,
									      addDays = function(days) {
									        var date = new Date(this.valueOf());
									        date.setDate(date.getDate() + days);
									        return date;
									      };
									  while (currentDate <= endDate) {
									    dates.push(currentDate);
									    currentDate = addDays.call(currentDate, 29);
									  }
									  return dates;
								};

								function totalAmount(attr){
										var total=0.00;

										$(selector+" tr:not(.hide) td."+attr).each(function() { 					 	
					                    		total += parseFloat($(this).text().replace(',',''));
					                    		
					                    		if(isNaN(total))
					                    			$(selector+" td.t"+attr).text(0);
					                    		else
					                    			$(selector+" td.t"+attr).text(total);
					                    		
					                    });
								};  

							    function totalAllcol(){
													
										for(var i=1; i<=$(selector+" .table th").length-1;i++){
												totalAmount('_'+i);                   	
										};					
								}; 	
						};

			}(jQuery));
