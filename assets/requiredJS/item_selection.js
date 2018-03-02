$(function() {
                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {
                          bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){ 
                                                   if((result && $("#total_amount_").val()!=0) || $("[name='cancel'").length==1){
                                                          var url = "phpscript/savePayment/saveSelection.php";
                                                          
                                                              // POST values in the background the the script URL
                                                              $.ajax({
                                                                  type: "POST",
                                                                  url: url,
                                                                  dataType   : 'json',
                                                                  data: $("#form").serialize(),
                                                                  success: function (data)
                                                                  {
                                                                      $('.alert').removeClass('alert-success, alert-danger')
                                                                                 .addClass(data.type)
                                                                                 .html(data.message)
                                                                                 .fadeIn(100,function(){
                                                                                     $(this).fadeOut(5000);
                                                                                 });

                                                                      var transaction_id=$("[name='transaction_id']").val();
                                                              
                                                                      if(data.type=='alert-success' && $("[name='cancel'").length==0){
                                                                         gen_transaction_id();
                                                                         totalAmount();

                                                                       

                                                                             if(!$("[name='terms']").is(":checked")){
                                                                                 dialog_(transaction_id)
                                                                              }

                                                                            $('#form')[0].reset();
                                                                            $('tr[row]').remove();
                                                                      }else if($("[name='cancel'").length==1){
                                                                        if($("#total_amount_").val()!=0){
                                                                           dialog_(transaction_id);
                                                                        }
                                                                       
                                                                        $("#cancelation button").attr("disabled","disabled");
                                                                        $("#cancelation span").hide();
                                                                      }
                                                                      
                                                                  }
                                                              });
                                                          }else{
                                                              alert("Please select an item ");
                                                           }
                                                   }
                                      
                                    });
                                    return false;
                        }
                  });

   $("[name='terms']").change(function(){
      if(this.checked){
          $("[name='transaction_id']").val("").removeAttr("readonly");
          $("[name='transaction_id']").focus();        
      }else{
          gen_transaction_id();
          $("[name='transaction_id']").attr("readonly","readonly");

         
      }

   });

    $("[name='transaction_id']").click(function(){
        if(!$("[name='terms']").is(":checked")){
          $(".tt-menu").hide();
        }
    })
});

function gen_transaction_id(){
  var d=new Date(),
      day=d.getHours(),
      minute=d.getMinutes(),
      seconds=d.getSeconds(),
      month=d.getMonth(),
      year=d.getFullYear();

      $("[name='transaction_id']").val("OP"+seconds+year+month+day+"-"+minute+seconds);
}

function dialog_(transaction_id){
  bootbox.confirm({
                      size: "small",                                         
                      message: "Would you like to print the certification?", 
                      callback: function(result){ 
                               if(result){
                                  WindowPopUp('phpscript/savePayment/printCertification.php?id='+transaction_id+'&for=sales','print','480','450');
                               }
                      }
   });
}


         