<?php
session_start();
include('functions/userfunctions.php');
include('includes/header.php');
if(isset($_SESSION['auth']))



?>

<div class="py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if(isset($_SESSION['message'])) 
                { 
                    ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hey!</strong><?= $_SESSION['message']; ?> .
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            unset($_SESSION['message']);
              }
              ?>

            <div class="card">
                <div class="card-header">
                    <h4>login Form</h4>
                </div>
                <div class="card-body">
                      <form action="functions/authcode.php" method="POST">
                        
                          <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email address</label>
                          <input type="email" name="email"class="form-control"placeholder="Enter your Email" id="exampleInputEmail1" aria-describedby="emailHelp">
                               </div>
                           
                           <div class="mb-3">
                           <label for="exampleInputPassword1" class="form-label">Password</label>
                          <input type="password"name="password" class="form-control"placeholder="Enter your password" id="exampleInputPassword1">
                          </div>
                          
                           <div class="mb-3 form-check">
                           <input type="checkbox" class="form-check-input" id="exampleCheck1">
                           <label class="form-check-label" for="exampleCheck1">Check me out</label>
                           </div>
                          <button type="submit"name="login_btn" class="btn btn-primary">Login</button>
                     </form>
                </div>
            </div>      
           </div>
    </div>
</div>
</div>


   <?php include('includes/footer.php'); ?>