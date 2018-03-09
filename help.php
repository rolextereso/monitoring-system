<?php require_once('layout/header.php');?>   
 
 
<?php require_once('layout/nav.php');?>

<style>
    li,ol,a {
                font: Cambria;
                
           }
    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: red;
        color: white;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        font-size: 15px;
            
           }
    #myBtna:hover{
        background-color: #555;
    }

    .show {
        background: #e9e8e8;
        padding: 20px;
        border: 1px solid #007bff;
        margin-top: 7px;
    }
    a[aria-expanded=true] {
        padding: 10px;
        background: #007bff;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        color: white;
    }
</style>
 <button onclick="topFunction()" id="myBtn" title="Back to Top"><b>&uarr;</b> Top</button>
                
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">

               
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-question-circle"></i> Help </li>
              </ol>
              
              <div class="">
              <ol>Topics
              </ol>
                <ol>
                     <a href="#h1" data-toggle="collapse">Create Order of Payment - Product Selection | </a>
                        <div class="collapse" id="h1"><br />
                             <h6>Step 1. Navigate to Order of Payment Page and Select Product Selection Tab  <img src="assets/img/op1.png" /> </h6>
                             <h6>Step 2. Fill out customer's information </h6>
                             <h6>Step 3. Select Product Item/s </h6>
                             <h6>Step 4. Verify product price, quantity, and total amount </h6>
                             <img style="height: 350px;width: 800px;"src="assets/img/op2.png" />
                             <h6>Step 3. Click Save Selection button </h6>
                        </div>
                  <a href="#h2" data-toggle="collapse">Rental Selection | </a>
                        <div class="collapse" id="h2"><br />
                             <h6>Step 1. Navigate to Order of Payment Page and Select Product Rental Selection Tab  <img src="assets/img/op1.png" /> </h6>
                             <h6>Step 2. Fill out customer's information </h6>
                             <h6>Step 3. Select the Return Date first</h6>
                             <h6>Step 4. Select Product Item/s
                             <h6>Step 5. Verify product price, quantity, and total amount </h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/oprent.png" />
                             <h6>Step 6. Click Save Selection button </h6>
                        </div>
                 <a href="#h3" data-toggle="collapse">Bundle Remittance | </a>
                        <div class="collapse" id="h3"><br />
                             <h6>Step 1. Navigate to Order of Payment Page <img src="assets/img/op1.png" /> </h6>
                             <h6>Step 2. Make sure to check the checkbox on the right side of the page and enter ID </h6>
                             <h6>Step 3. Fill out customer's information </h6>
                             <h6>Step 4. Select Product Item/s
                             <h6>Step 5. Verify product price, quantity, and total amount </h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/op3.png" />
                             <h6>Step 6. Click Save Selection button </h6>
                        </div>
                 <a href="#h4" data-toggle="collapse">Salary Deduction</a>
                        <div class="collapse" id="h4"><br />
                             <h6>Step 1. Navigate to Order of Payment Page <img src="assets/img/op1.png" /> </h6>
                             <h6>Step 2. Make sure to check the checkbox on the right side of the page and enter ID </h6>
                             <h6>Step 3. Fill out customer's information </h6>
                             <h6>Step 4. Select Product Item/s
                             <h6>Step 5. Verify product price, quantity, and total amount </h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/op3.png" />
                             <h6>Step 6. Click Save Selection button </h6>
                        </div>
                 </ol>    
                 <ol>
                 <a href="#t" data-toggle="collapse">Save Payment (Official Receipt Number)</a>
                        <div class="collapse" id="t"><br />
                             <h6>Step 1. Navigate to Transactions Page <img src="assets/img/t.png" /> </h6>
                             <h6>Step 2. You can Search Order of Payment number or customer's name (based on the oder of payment slip)  <img src="assets/img/t1.png" /> </h6>
                             <h6>Step 3. Click  <img src="assets/img/t2.png" /> to open transaction </h6>
                             <h6>Step 4. Enter Official Receipt Number</h6>
                             <h6>Step 5. Verify product price, quantity, and total amount </h6>
                             <h6>Step 6. Click <img src="assets/img/t3.png" /> </h6>
                        </div>
                 </ol>    
                 
                 <ol>
                     <a href="#h5" data-toggle="collapse">Create Purchase Request  |  </a>
                        <div class="collapse" id="h5"><br />
                             <h6>Step 1. Navigate to Purchase Request Page  <img src="assets/img/pr1.png" /> </h6>
                             <h6>Step 2. Click <img src="assets/img/pr2.png" /> </h6>
                             <h6>Step 3. Select Project Name, Enter PR Purpose </h6>
                             <h6>Step 4. Click <img src="assets/img/pr4.png" />   </h6>
                             <h6>Step 5. Input item description and quantity<img src="assets/img/pr6.png" />
                             <h6>Step 6. Click <img src="assets/img/pr5.png" /> </h6>
                        </div>
               
                    
                 </ol>   
                 <ol>
                     <a href="#h7" data-toggle="collapse">Assign Project Heads | </a>
                        <div class="collapse" id="h7"><br />
                             <h6>Step 1. Navigate to Projects Page  <img src="assets/img/p.png" /> </h6>
                             <h6>Step 2. Select <img src="assets/img/p2.png" /> </h6>
                             <h6>Step 3. Click <img src="assets/img/p3.png" />   </h6>
                             <h6>Step 4. Fill out the information needed and dont forget to check checkbox   
                             <img style="height: 250px;width: 800px;"src="assets/img/p4.png" />
                             <h6>Step 5. Click Save Project </h6>
                        
                        </div>
                    <a href="#h8" data-toggle="collapse">Register Projects | </a>
                        <div class="collapse" id="h8"><br />
                             <h6>Step 1. Navigate to Setting Page  <img src="assets/img/s.png" /> </h6>
                             <h6>Step 2. Select <img src="assets/img/s1.png" /> </h6>
                             <h6>Step 3. Fill out the need information for your Project then click Next 
                             <br /><h6 style="color: red;font-size: 11px">Note* You can review your work by clicking Previous</h6></h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/step1.png" />
                             <h6>Step 4. Fill out the need information for Production Cost then click Next</h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/step2.png" />
                             <h6>Step 5. Fill out the need information for your Budget then click Next
                             <br /><h6 style="color: red;font-size: 11px">Note* These are the target expenses for purchase requests</h6></h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/step3.png" />
                             <h6>Step 6. Fill out the need information for your Product Price then click Submit
                             <br /><h6 style="color: red;font-size: 11px">Note* All registered projects and products can be viewed at the Products Page </h6></h6>
                             <img style="height: 250px;width: 800px;"src="assets/img/step4.png" />
                          </div>
                          
                        <a href="#h9" data-toggle="collapse">View Project Budget (Planned vs. Actual) | </a>
                        <div class="collapse" id="h9"><br />
                             <h6>Step 1. Navigate to Projects Page  <img src="assets/img/p.png" /> </h6>
                             <h6>Step 2. Click <img src="assets/img/dots.png" /> under commands column </h6>
                             <h6>Step 3. To view project budget click <img src="assets/img/open.png" /> under commands column  </h6>
                              <img style="height: 200px;width: 800px;"src="assets/img/b1.png" />
                             <br />
                             <img style="height: 250px;width: 800px;"src="assets/img/b2.png" />
                             <h6>Step 4. Click <img src="assets/img/print.png" /> to print the page </h6>
                        </div>
                      
                      <a href="#h10" data-toggle="collapse">Add new Project Budget </a>
                        <div class="collapse" id="h10"><br />
                             <h6>Step 1. Navigate to Projects Page  <img src="assets/img/p.png" /> </h6>
                              <h6>Step 2. Click <img src="assets/img/dots.png" /> under commands column </h6>
                             <h6>Step 3. To add new project budget click <img src="assets/img/b3.png" />  </h6>
                            <h6 style="color: red;">Note* The newly created budget will become the <img src="assets/img/current.png" /> budget and others will become <img src="assets/img/archive.png" /> <br />
                            You will follow the same procedure or steps in creating new project budget just like                          
                            <a href="#h8" data-toggle="collapse">registering a new project</a>
                            </h6>                    
                        </div>
                        </ol>
                        <ol>
                      <a href="#h11" data-toggle="collapse">Return Rented Item/s </a>
                        <div class="collapse" id="h11"><br />
                             <h6>Step 1. Navigate to Rented Items Page  <img src="assets/img/r.png" /> </h6><br />
                             <img src="assets/img/r2.png" />
                             <br /><h6 style="color: red;">Note*  <img src="assets/img/red.png" /> means overdue rental </h6>
                             <h6>Step 2. You can search items or customer name here <img src="assets/img/search.png" /></h6>
                             <h6>Step 3. To return an item click <img src="assets/img/arrow.png" /> under commands column  </h6>
                             
                             <br />
                             <img style="height: 250px;width: 800px;"src="assets/img/r3.png" />
                             <br /><h6 style="color: red;">Note* You can't return an item if the customer did not paid the rental fee yet</h6>
                             <h6>Step 4. Check the box and Click Save</h6>
                        </div>
                     </ol> 
                      
                        </div>
               
                
              
               
              
              
           </nav>
           <br/>
           
              
        </div>
      <script>
            
                window.onscroll= function()
                {scrollFunction()};
                
                function scrollFunction(){
                    if (document.body.scrollTop >20 || document.documentElement.scrollTop >20 ){
                        document.getElementById("myBtn").style.display="block";
                    }
                    else{
                    
                        document.getElementById("myBtn").style.display="none";
                        }         }      
                function topFunction(){
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop - 0;
                }
            </script>  

      </main>
     
<?php require_once('layout/footer.php');?>      