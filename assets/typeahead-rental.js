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
                  url: 'phpscript/ProductSelection/getProduct.php?query=%QUERY',
                  wildcard: '%QUERY'
                }
              });
              
              // Initializing the typeahead
              var input_ =$('.typeahead').typeahead({
                  hint: false,
                  highlight: false, /* Enable substring highlighting */
                  minLength: 1 /* Specify minimum characters required for showing result */
              },
              {
                  name: 'product_name',
                  source: product,
                  display: 'product_name',
                  limit: 6,
                  templates: {
                  notFound: empty,
                  suggestion: template
              }
              }).on('typeahead:selected', function(e,suggestion){
                  input_.typeahead('val','');

                  var current_date = moment().format('YYYY-MM-DD'),
                      date_return =  moment($(".date_return").val(),'YYYY-MM-DD'),
                      diffDays = date_return.diff(current_date, 'days');
                  
                  //console.log('Selection: ' + suggestion.value);
                  if($(".date_return").val()==""){
                      alert("Please select the date to return");
                  }else if($("[row='_"+suggestion.id+"']").length==1){
                      alert("Item already selected");
                  }else{
                       $(".table tbody").prepend(render(suggestion,diffDays,$(".date_return").val()));   
                        addQuantity($("[row='_"+suggestion.id+"']").attr('num'), diffDays);
                        totalAmount();             
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

        var price=object.price.replace(',','');
        count++;//increase the count value by 1
        return "<tr id='row"+count+"' row='_"+object.id+"' num='"+count+"'><td> "+
                  "<input type='hidden' value='"+object.id+"' name='product_id[]' /> <h5 class='close_item' onclick='remove("+count+")'>&Cross;</h5>"
                  +"</td><td>"+object.product_name
                  +"</td><td>"+object.price+"/"+object.unit_of_measurement
                  +"</td><td ><input type='hidden' id='q_"+count+"' name='quantity[]' value='1' /><div id='_"+count+"'>1</div>"
                  +"</td><td>"
              
                  +"</td><input type='hidden' id='a_"+count+"' name='amount[]' value='"+object.price+"'/><td class='amount' amount='"+price+"' a_id="+count+">"+object.price
              +"</td><td><input type='hidden' name='date_to_return[]' value='"+date_+"'/>"+moment(date_).format('MMM DD, YYYY')+"</td></tr>";
                 
  }

  function remove(row){
        $("#row"+row).remove();
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
        var amount= $(".amount");
        var currentVal = ($('#amount').val()=="")?'0.00':$('#amount').val();

        if(amount.length>0){
              $(".amount").each(function() {   
                    total += parseFloat($(this).text().replace(',',''));
                   
                    $("#total_amount").html('&#8369; '+total.format(2)).addClass("pulse animated green");//animate once amount added
                    $("#total_amount_").val(total);

                    change(currentVal);

                    setTimeout(function (){
                       $("#total_amount").removeClass("pulse animated green");//remove the animation after 1 sec
                    }, 1000);          
              });
        }else{
                 
               $("#total_amount").html('&#8369; '+total.format(2)).addClass("pulse animated red");//animate once amount added
               $("#total_amount_").val(total);

               $('#change').html('&#8369; 0.00');

               setTimeout(function (){
                       $("#total_amount").removeClass("pulse animated red");//remove the animation after 1 sec
               }, 1000);  
        }
 }
