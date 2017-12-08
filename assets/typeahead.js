  $(document).ready(function(){
              var city, template, empty; 

              /* below code is for typeahead once user type text on the textbox*/

              template = Handlebars.compile($("#result-template").html());
              empty = Handlebars.compile($("#empty-template").html());
              
              // Constructing the suggestion engine
              var city = new Bloodhound({
                  datumTokenizer: Bloodhound.tokenizers.whitespace,
                  queryTokenizer: Bloodhound.tokenizers.whitespace,
                  remote: {
                  url: 'city.php?query=%QUERY',
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
                  name: 'city',
                  source: city,
                  display: 'value',
                  limit: 4,
                  templates: {
                  notFound: empty,
                  suggestion: template
              }
              }).on('typeahead:selected', function(e,suggestion){
                input_.typeahead('val','');
                  //console.log('Selection: ' + suggestion.value);
                   $(".table tbody").append(render(suggestion));
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

  function render(object){
        count++;//increase the count value by 1
        return "<tr id='row"+count+"'><td> <h5 class='close_item' onclick='remove("+count+")'>&Cross;</h5>"
                  +"</td><td>"+1
                  +"</td><td>"+1
                  +"</td><td ><div id='_"+count+"'>1</div>"
                  +"</td><td><button type='button' onclick='addQuantity("+(count)+")' class='btn btn-primary'>&plus;</button> "
                  +"<button type='button' onclick=subtractQuantity("+(count)+") class='btn btn-primary'>&ndash;</button>"
                  +"</td><td class='amount' amount='205.50' a_id="+count+">"+205.50
              +"</td></tr>";
                 
  }

  function remove(row){
        $("#row"+row).remove();
        totalAmount();
  }

 function addQuantity(index){  

        var quantity=parseInt($("div#_"+index).text())+1;
        var presentAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//actual amount per item
        var amount=quantity*presentAmount;//multiplied by the number of quantity


        $("[a_id="+index+"]").html(amount.format(2));
        $("div#_"+index).html(quantity);
        totalAmount();
 }

 function subtractQuantity(index){ 
  
        var quantity=parseInt($("div#_"+index).text())-1;

        var actualAmount=parseFloat($("[a_id="+index+"]").attr("amount"));//the actual amount per item
       
        var amount=quantity*actualAmount; //get the deducted amount

        if(quantity>=1){
            $("div#_"+index).html(quantity).addClass("bounce animated bold");
            $("[a_id="+index+"]").html(amount.format(2));
             totalAmount();

            setTimeout(function (){
              $("div#_"+index).removeClass("bounce animated bold");
            }, 1000);
        }
    
 }
  
 function totalAmount(){
        var total = 0.00;
        var amount= $(".amount");
        if(amount.length>0){
              $(".amount").each(function() {   
                    total += parseFloat($(this).text().replace(',',''));         
                    $("#total_amount").text(total.format(2)).addClass("pulse animated green");//animate once amount added

                     setTimeout(function (){
                       $("#total_amount").removeClass("pulse animated green");//remove the animation after 1 sec
                     }, 1000);          
              });
        }else{
               $("#total_amount").text(total.format(2)).addClass("pulse animated red");//animate once amount added

                setTimeout(function (){
                       $("#total_amount").removeClass("pulse animated red");//remove the animation after 1 sec
                }, 1000);  
        }
 }
