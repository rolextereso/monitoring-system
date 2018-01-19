// Principal Author: Rolex Tereso
// Email: rolexjun098@gmail.com

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
							//this will remove the row of once x is click
							$('.table-remove').click(function () {
							   $(this).parents('tr').detach();
							   totalAllcol();//update the total amount

							});
							//this will add row or item once + add item is clicked
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
							//this function population the rows of the table
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
									    var contenteditable=(editable && !footer)?" contenteditable='true' ": "";
									    var showBtn=(footer)?"<td class='btn-remove'></td>":btn;
										var tag=(editable)? showBtn+"<"+element+" "+contenteditable+" class='_0'>"+step+"</"+element+">": "";
																
										var no=1;
											
										date.forEach(function(date) {

											var dates=(editable)?"0":  moment(date).format("MMM YYYY");
											var formatted=(!editable)? "data='"+moment(date).format("YYYY-MM-DD")+"'": "";
											var row_number=(footer)? "t_"+no: (footer==null)?"h_"+no : "_"+no;
											

									 		tag+="<"+element+" "+contenteditable+" "+formatted+" class="+row_number+">"+dates+"</"+element+">";
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
									table+="<table class='table table-sm table-dark table-striped'> <tr>";				     
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

										Date.isLeapYear = function (year) { 
										    return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)); 
										};

										Date.getDaysInMonth = function (year, month) {
										    return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
										};

										Date.prototype.isLeapYear = function () { 
										    return Date.isLeapYear(this.getFullYear()); 
										};

										Date.prototype.getDaysInMonth = function () { 
										    return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
										};

										Date.prototype.addMonths = function (value) {
										    var n = this.getDate();
										    this.setDate(1);
										    this.setMonth(this.getMonth() + value);
										    this.setDate(Math.min(n, this.getDaysInMonth()));
										    return this;
										};

										  var dates = [],
										      currentDate = startDate,
										      _addMonths = function(days) {
										        var date = new Date(this.valueOf());
										        //date.setDate(date.getDate() + days);
										        return date.addMonths(1);
										      };
										  while (currentDate <= endDate) {
										    dates.push(currentDate);
										    currentDate = _addMonths.call(currentDate);
										  }
										  return dates;
								};
								//This function get and set the total amount of each column in the table
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
								//this function get the total of all columns
							    function totalAllcol(){
													
										for(var i=1; i<=$(selector+" .table th").length-1;i++){
												totalAmount('_'+i);                   	
										};					
								}; 	
						};

			}(jQuery));
