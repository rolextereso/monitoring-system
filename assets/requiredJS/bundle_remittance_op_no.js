$('[name="transaction_id"]').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                          },
                          {
                          limit: 12,
                          async: true,            
                          source: function (query, processSync, processAsync) {
                                
                                return $.ajax({
                                        url: "phpscript/bundle-remittance/get_op.php", 
                                        type: 'GET',
                                        data: {query: query},
                                        dataType: 'json',
                                        success: function (json) {
                                          // in this example, json is simply an array of strings
                                          return processAsync(json);
                                        }
                                });
                          }
  });