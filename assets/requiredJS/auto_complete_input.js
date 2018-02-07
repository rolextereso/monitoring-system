   $('[name="customer_name"],[name="customer_address"]').typeahead({
                          hint: true,
                          highlight: true,
                          minLength: 1
                        },
                        {
                        limit: 12,
                        async: true,            
                        source: function (query, processSync, processAsync) {
                              var data=$(this.$el[0].parentElement.parentElement).children("input").first().attr("data");
                              return $.ajax({
                                      url: "phpscript/ProductSelection/getCustomer_and_address.php", 
                                      type: 'GET',
                                      data: {query: query,type:data},
                                      dataType: 'json',
                                      success: function (json) {
                                        // in this example, json is simply an array of strings
                                        return processAsync(json);
                                      }
                              });
                        }
});