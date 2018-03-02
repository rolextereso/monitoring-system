  $(document).ready(function(){

            var product, template, empty; 

              /* below code is for typeahead once user type text on the textbox*/

              template = Handlebars.compile($("#result-template").html());
              empty = Handlebars.compile($("#empty-template").html());
              
              // Constructing the suggestion engine
              var product = new Bloodhound({
                 datumTokenizer: Bloodhound.tokenizers.whitespace,
                  queryTokenizer: Bloodhound.tokenizers.whitespace,

                  remote: {
                  url: 'phpscript/rental/getRental.php?query=%QUERY',
                  wildcard: '%QUERY',
                  cache:false
                }
              });
              
              // Initializing the typeahead
              var input_ =$('.typeahead').typeahead({
                  hint: false,
                  highlight: false, /* Enable substring highlighting */
                  minLength: 1, /* Specify minimum characters required for showing result */
              },
              {
                  name: 'item_name',
                  source:  product,
                  display: 'item_name',
                  limit: 9,
                  templates: {
                  notFound: empty,
                  suggestion: template
              }
              }).on('typeahead:selected', function(e,suggestion){
                  input_.typeahead('val','');

                  var current_date = moment().format('YYYY-MM-DD'),
                      date_return =  moment($(".date_return").val(),'YYYY-MM-DD'),
                      diffDays = date_return.diff(current_date, 'days');
                  
                  if(suggestion.availability=='Unavailable'){
                      alert("The Item is still unavailable");
                  }else if($(".date_return").val()==""){
                      alert("Please select the date to return");
                  }else if($("[row='_"+suggestion.id+"']").length==1){
                      alert("Item already selected");
                  }else{

                      if(suggestion.per_day=='Y'){
                            $(".table tbody").prepend(render(suggestion,diffDays,$(".date_return").val()));   
                            addQuantity($("[row='_"+suggestion.id+"']").attr('num'), diffDays);
                            totalAmount();  
                      }else{
                           $(".table tbody").prepend(render(suggestion,diffDays,$(".date_return").val()));
                            addQuantityNotPerDay($("[row='_"+suggestion.id+"']").attr('num'), diffDays);
                            totalAmount();  
                      }
                                  
                  }

                  
              }).on('typeahead:asyncrequest', function() {
                 $('.Typeahead-spinner').show();
              }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
                 $('.Typeahead-spinner').hide();
              });

              


}); 

  

  var  count=1;

  Number.prototype.format = function(n, x) {
        var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
  };

  function render(object, no_day_to_return, date_){

        var rental_fee=object.rental_fee.replace(',','');
        var per_day=(object.per_day=='Y')?"day":"rent";
        count++;//increase the count value by 1
        return "<tr id='row"+count+"' row='_"+object.id+"' num='"+count+"'><td> "+
                  "<input type='hidden' value='"+object.id+"' name='rental_id[]' /> <h5 class='close_item' onclick='remove("+count+")'>&Cross;</h5>"
                  +"</td><td>"+object.item_name+" ("+object.item_description+")"
                  +"</td><td>"+object.rental_fee+"/"+per_day
                  +"</td><td ><input type='hidden' id='q_"+count+"' name='no_of_days[]' value='1' /><div id='_"+count+"'>1</div>"
                  +"</td><td>"
              
                  +"</td><input type='hidden' id='a_"+count+"' name='amount[]' value='"+object.rental_fee+"'/><td class='amount' amount='"+rental_fee+"' a_id="+count+">"+object.rental_fee

              +"</td><td><input type='hidden' name='date_to_return[]' value='"+date_+"'/>"+moment(date_).format('MMM DD, YYYY')+"</td></tr>";

                 
  }

  function remove(row){
        $("#row"+row).remove();
        totalAmount();
  }

  function remove_selected(row,$id){
    var canceled="<input type='hidden' value='"+$id+"' name='canceled_specific_id[]' />";
    var data_canceled=$("#row"+row)[0].outerHTML;    

    $("#data_canceled").prepend(data_canceled);
    $("#product_canceled_id").prepend(canceled);

    
    check_canceled_selection();
    remove(row);
  }

  function check_canceled_selection(){
    if($("#product_canceled_id").html()==""){
        $('#rollback').fadeOut();
    }else{
        $('#rollback').fadeIn();
    }
  }

  function rollback(){
    var data_reverted=$("#data_canceled tbody tr:first").clone(); 
   $(".table tbody").prepend(data_reverted); 
  
    $("#data_canceled tbody tr").first().remove();
    $("#product_canceled_id input").first().remove();
    check_canceled_selection();
    totalAmount();
  }

   function addQuantityNotPerDay(index, diffDays){  

        var quantity=parseInt($("div#_"+index).text())+diffDays;
        var presentAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//actual amount per item
        var amount=quantity*presentAmount;//multiplied by the number of quantity
        $('#q_'+index).val(quantity); 

        $("[a_id="+index+"]").html(presentAmount.format(2));
        $("div#_"+index).html(quantity);

         $("#a_"+index).val(presentAmount);
        totalAmount();
 }

 function addQuantity(index, diffDays){  

        var quantity=parseInt($("div#_"+index).text())+diffDays;
        var presentAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//actual amount per item
        var amount=quantity*presentAmount;//multiplied by the number of quantity
        $('#q_'+index).val(quantity); 

        $("[a_id="+index+"]").html(amount.format(2));
        $("div#_"+index).html(quantity);

         $("#a_"+index).val(amount);
        totalAmount();
 }

 function subtractQuantity(index){ 
  
        var quantity=parseInt($("div#_"+index).text())-1;

        var actualAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//the actual amount per item
       
        var amount=quantity*actualAmount; //get the deducted amount

        if(quantity>=1){
            $('#q_'+index).val(quantity);
            $("div#_"+index).html(quantity).addClass("bounce animated bold");
            $("[a_id="+index+"]").html(amount.format(2));
            $("#a_"+index).val(amount);

             totalAmount();

            setTimeout(function (){
              $("div#_"+index).removeClass("bounce animated bold");
            }, 1000);
        }
    
 }
  
 function totalAmount(){
        var total = 0.00;
        var amount= $(".table .amount");
        var currentVal = ($('.table #amount').val()=="")?'0.00':$('#amount').val();

        if(amount.length>0){
              $(".table .amount").each(function() {   
                    total += parseFloat($(this).text().replace(',',''));
                   
                    $("#total_amount").html('&#8369; '+total.format(2)).addClass("pulse animated green");//animate once amount added
                    $("#total_amount_").val(total);

                   

                    setTimeout(function (){
                       $("#total_amount").removeClass("pulse animated green");//remove the animation after 1 sec
                    }, 1000);          
              });
        }else{
                 
               $("#total_amount").html('&#8369; '+total.format(2)).addClass("pulse animated red");//animate once amount added
               $("#total_amount_").val(total);

               

               setTimeout(function (){
                       $("#total_amount").removeClass("pulse animated red");//remove the animation after 1 sec
               }, 1000);  
        }
 }


