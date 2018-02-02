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
                  wildcard: '%QUERY',
                  cache:false
                }
              });
              
              // Initializing the typeahead
              var input_ =$('.typeahead').typeahead({
                  hint: false,
                  highlight: true, /* Enable substring highlighting */
                  minLength: 2 /* Specify minimum characters required for showing result */
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
                  //console.log('Selection: ' + suggestion.value);
                  if($("[row='_"+suggestion.id+"']").length==1){
                       addQuantity($("[row='_"+suggestion.id+"']").attr('num'));
                  }else{
                       $(".table tbody").prepend(render(suggestion));                  
                  }

                  totalAmount();
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

  function addSubQuantity(num,index){
        if(Number.isInteger(parseInt(num))){     
              inputQuantity(num,index);
        }else{
            $(".quantity_"+num).val(1);
            inputQuantity(1,index);
            alert("Quantity must be a whole number");
        }
  }
           

  function render(object){     

        var price=object.price.replace(',','');
        count++;//increase the count value by 1
        return "<tr id='row"+count+"' row='_"+object.id+"' num='"+count+"'><td> "+
                  "<input type='hidden' value='"+object.id+"' name='product_id[]' /> <h5 class='close_item' onclick='remove("+count+")'>&Cross;</h5>"
                  +"</td><td>"+object.product_name
                  +"</td><td>"+object.price+"/"+object.unit_of_measurement
                  +"</td><td ><input type='hidden' id='q_"+count+"' name='quantity[]' value='1' /><div id='_"+count+"' style='width:16px;'><input onkeyup='addSubQuantity(this.value,"+count+")' class='quantity' id='quantity_"+count+"' type='text' value='1'/></div>"
                  +"</td><td><button type='button' onclick='addQuantity("+(count)+")' class='btn btn-primary'>&plus;</button> "
                  +"<button type='button' onclick=subtractQuantity("+(count)+") class='btn btn-primary'>&ndash;</button>"
                  +"</td><input type='hidden' id='a_"+count+"' name='amount[]' class='amount' value='"+object.price+"'/><td  amount='"+price+"' a_id="+count+">"+object.price
              +"</td></tr>";

  }

  function remove(row){
        $("#row"+row).remove();
        totalAmount();
  }

  function inputQuantity(quantity,index){
        var quantity=parseInt(quantity);
        var presentAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//actual amount per item
        var amount=quantity*presentAmount;//multiplied by the number of quantity
        $('#q_'+index).val(quantity); 

        $("[a_id="+index+"]").html(amount.format(2));
        $("div#_"+index+" input").val(quantity);

         $("#a_"+index).val(amount);
        totalAmount();
  }


 function addQuantity(index){  

        var quantity=parseInt($("div#_"+index+" input").val())+1;
        var presentAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//actual amount per item
        var amount=quantity*presentAmount;//multiplied by the number of quantity
        $('#q_'+index).val(quantity); 

        $("[a_id="+index+"]").html(amount.format(2));
        $("div#_"+index+" input").val(quantity);

         $("#a_"+index).val(amount);
        totalAmount();
 }

 function subtractQuantity(index){ 
  
        var quantity=parseInt($("div#_"+index+" input").val())-1;

        var actualAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//the actual amount per item
       
        var amount=quantity*actualAmount; //get the deducted amount

        if(quantity>=1){
            $('#q_'+index).val(quantity);
            $("div#_"+index+" input").val(quantity).addClass("bounce animated bold");
            $("[a_id="+index+"]").html(amount.format(2));
            $("#a_"+index).val(amount);

             totalAmount();

            setTimeout(function (){
              $("div#_"+index+" input").removeClass("bounce animated bold");
            }, 1000);
        }
    
 }
  
 function totalAmount(){
        var total = 0.00;
        var amount= $(".amount");
        var currentVal = ($('#amount').val()=="")?'0.00':$('#amount').val();

        if(amount.length>0){
              $(".amount").each(function() {   
                    total += parseFloat($(this).val().replace(',',''));
                 
                    $("#total_amount").html('&#8369; '+total.format(2)).addClass("pulse animated green");//animate once amount added
                    $("#total_amount_").val(total);

                    if($('#change').length==1){
                        change(currentVal);
                    }

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