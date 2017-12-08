<?php require_once('layout/header.php');?>
   
   <script  type="text/javascript" src="https://www.tutorialrepublic.com/examples/js/typeahead/0.11.1/typeahead.bundle.js"></script>
   <script type="text/javascript" src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
   <script type="text/javascript" src="assets/typeahead.js"></script>
   <link href="assets/typeahead.css" rel="stylesheet">

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
              </ol>
          </nav>

          <div class="row  ">
              <div class="col-sm-8">
                    <label>Enter Product Item or Number</label>
                    <input type="text" class="typeahead tt-query form-control" autocomplete="off" spellcheck="false" placeholder="Type here.." />
                    <img class="Typeahead-spinner" src="assets/img/spinner.gif" >
              </div>
               <div class="col-sm-3">
                  <small>Total Amount</small>
                  <h1 id="total_amount">0.00</h1>
               </div>
          </div>
        
          <div class="row">
              <div class="table-responsive col-sm-8" style="height: 408px;overflow-y:auto;">
                      <table class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Description</th>
                            <th>Unit Price</th>
                            <th colspan="2">Quantity</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
              </div>
              <div class="col-sm-3" style="border:1px solid silver;">
                  <small>Transaction ID</small>
                  <h2 id="transaction_id">1232444-12</h2>
                  <hr/>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">$</span>
                    <input type="text" class="form-control" placeholder="0.00" aria-label="Username" >
                  </div>
              </div>
          
        </div>
        </main>

          <script id="empty-template" type="text/x-handlebars-template">
                <div class="EmptyMessage">Your search turned up 0 results. Maybe because the item is out of stock </div>
          </script>

          <script id="result-template" type="text/x-handlebars-template">
                 <div style="border-bottom: 1px solid silver;">
                        <div>
                              PNO: <strong>{{value}}</strong> <br>
                              <small>{{value}}</small>
                        </div>
                        <small>Available Quantity: 2</small>            
                 </div>
          </script>
<?php require_once('layout/footer.php');?>      