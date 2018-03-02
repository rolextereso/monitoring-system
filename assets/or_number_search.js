 $(document).ready(function(){
              var product, template, empty; 

              /* below code is for typeahead once user type text on the textbox*/

              template = Handlebars.compile($("#result-template").html());
              empty = Handlebars.compile($("#empty-template").html());
              
              // Constructing the suggestion engine
              var or = new Bloodhound({
                  datumTokenizer: Bloodhound.tokenizers.whitespace,
                  queryTokenizer: Bloodhound.tokenizers.whitespace,
                  remote: {
                  url: 'phpscript/ProductSelection/getOr.php?query=%QUERY',
                  wildcard: '%QUERY',
                  cache:false
                }
              });
              
              // Initializing the typeahead
              var input_ =$('.typeahead').typeahead({
                  hint: false,
                  highlight: true, /* Enable substring highlighting */
                  minLength: 1 /* Specify minimum characters required for showing result */
              },
              {
                  name: 'ORNo',
                  source: or,
                  display: 'ORNo',
                  limit: 6,
                  templates: {
                  notFound: empty,
                  suggestion: template
              }
              }).on('typeahead:selected', function(e,suggestion){
                  $(".row_get").remove();
                  input_.typeahead('val','');
                  render(suggestion);                  
                  

              }).on('typeahead:asyncrequest', function() {
                 $('[name="or"]').val("");
                 $('.Typeahead-spinner').show();
              }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
                 $('.Typeahead-spinner').hide();
              });

});  



  Number.prototype.format = function(n, x) {
        var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
  };
     

  function render(object){     

         var $temp="";
         var $totalAmount=0;

         $('[name="or"]').val(object.ORNo);
         var url = "phpscript/ProductSelection/getOr.php";                                                      
                                                          
          // POST values in the background the the script URL
          $.ajax({
              type: "POST",
              url: url,
              dataType   : 'json',
              data: {exact_id:object.ORNo},
              success: function (data)
              {    
                       $.each(data, function(key,value){

                         $totalAmount +=parseFloat(value.amount);
                          $temp+="<tr class='row_get'>"+
                                    " <td>"+value.ORNo+"</td>"+                        
                                    " <td>"+value.item_name+"</td>"+
                                    " <td>"+value.amount+"</td>"+
                                    " <td>"+value.date_paid+"</td>"+
                            "</tr>"; 
                      });
                      // console.log($temp);
                  $(".table tbody").prepend($temp);
                  $("#total_amount span").html($totalAmount);
              }
          });
          

  }

  
 