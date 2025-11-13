<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Getlead</title>
	  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/fav.png')}}">
      <!--<link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.1.3/css/bootstrap.min.css">-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="preconnect"   type="text/css" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="./css/style.css">
      {{ Html::style('styles/gl_style.css') }}
   </head>
   <body>
      <section class="header">
         <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
               <a class="navbar-brand" href="https://partner.getleadcrm.com"><img src="https://partner.getleadcrm.com/frontend/image/Frame.png" alt="logo"></a>
               <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="navbar-collapse collapse" id="navbarNav" style="">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                     </li>
                  </ul>
                  <div class="ml-auto">
                     <a href="{{ route('partner.login') }}"><button type="button" class="btn btn-outline-danger">Login</button></a>
                  </div>
               </div>
            </div>
         </nav>
      </section>
      <section class="section2">
         <div class="container">
            <div class="col-lg-6 offset-2">
               <h2 class="heading">Become a <br> <span class="heading2"> Channel Partner</span></h2>
            </div>
         </div>
         <div class="container">
            <div class="col-lg-7 offset-2">
               <p class="para">We would be privileged to have you as one of our partners. Join GetLead <br>family today and drive your business forward &amp; increase your revenue. Let's grow together!</p>
            </div>
         </div>
      </section>
      <section class="section3">
         <div class="container">
            <div class="row">
               <div class="col-lg-1 rect"></div>
               <div class="col-lg-3 rect">
                  <div class="rectangle">
                     <div class="arm-image">
                        <img src="https://partner.getleadcrm.com/frontend/image/arm-wrestling 1.png" class="arm">
                     </div>
                     <p class="arm-para">Join our <br> partner program</p>
                  </div>
               </div>
               <div class="col-lg-3 rect rect_1">
                  <div class="rectangle">
                     <div class="team-image arm-image">
                        <img src="https://partner.getleadcrm.com/frontend/image/team 1.png" class="team">
                     </div>
                     <p class="team-para arm-para">Start selling <br>  behalf of Getlead</p>
                  </div>
               </div>
               <div class="col-lg-3 rect rect_2">
                  <div class="rectangle">
                     <div class="growth-image arm-image">
                        <img src="https://partner.getleadcrm.com/frontend/image/growth 1.png" class="growth">
                     </div>
                     <p class="growth-para arm-para">Increase your <br> Income </p>
                  </div>
               </div>
               <div class="col-lg-1 rect"></div>
               <div class="col-lg-1 rect"></div>
            </div>
         </div>
         <div class="container">
            <div class=" text-center">
               <h3 class="register">Register now</h3>
            </div>
            <div class="arrow text-center">
               <img src="https://partner.getleadcrm.com/frontend/image/bi_arrow-down-circle-fill.png" class="down-arrow">
            </div>
         </div>
      </section>
      <section class="section4">
         <div class="container">
            <div class="row ">
               <div class="col-lg-3"></div>
               <div class="col-lg-5 ml-5">
                  <img src="https://partner.getleadcrm.com/frontend/image/Group 1.png" class="group1">
               </div>
            </div>
         </div>
         <div class=" text-center">
            <h3 class="heading3">Channel Partner  <br> <span class="heading4"> Registration Form</span></h3>
            <p class="para2">We would be privileged to have you as one of our partners. Join GetLead family today and drive <br> your business forward &amp; increase your revenue. Let's grow together!</p>
         </div>
      </section>
      
      <section class="section-4">
         <div class="container">
            <div class="col-lg-8 offset-sm-2">
               <div class="rectangle4">
                  <form class="kt-form kt-form--fit kt-form--label-right" action="" method="" enctype="">
                     <div class="form-group">
                        <input type="hidden" name="" value="">
                        <div class="row">
                           <div class="col-lg-1"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputEmail1" id="form-name">Name*</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name" name="name" required="">
                           </div>
                           <div class="col-lg-2"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputPassword1" id="form-name">Mobile Number*</label>
                              <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Mobile Number" name="mobile" required="">
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-1"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputEmail1" id="form-name">Company Name*</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Company Name" name="company_name" required="">
                           </div>
                           <div class="col-lg-2"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputPassword1" id="form-name">Work Email*</label>
                              <input type="email" class="form-control" id="exampleInputPassword1" placeholder="workmail@example.com" name="email" required="">
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-1"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputEmail1" id="form-name">Website*</label>
                              <input type="website" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="www.example.com" name="website" required="">
                           </div>
                           <div class="col-lg-2"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputPassword1" id="form-name">Team Size</label>
                              <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Enter Team size" name="team_size">
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-1"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputEmail1" id="form-name">Country</label>
                              <select placeholder="Country" name="country" id="country">
                                 <option value="0" selected="">Select Country</option>
                              </select>
                              <input type="hidden" class="countrys" id="countrys" value="" name="countrys">
                           </div>
                           <div class="col-lg-2"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputPassword1" id="form-name">State</label>
                              <select placeholder="State" name="state" id="state">
                                 <option value="0" selected="">Select State</option>
                              </select>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-1"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputEmail1" id="form-name">City</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="City" name="city">
                           </div>
                           <div class="col-lg-2"></div>
                           <div class="col-lg-3 rowq">
                              <label for="exampleInputPassword1" id="form-name">Pin Code</label>
                              <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Pin code" name="pin_code">
                           </div>
                        </div>
                        <div class="col-lg-5 offset-sm-3">
                           <button type="submit" class="btn lbtn-danger ">Become a Partner</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </section>
      <section class="footer">
         <div class="container">
            <div class="row">
               <h6 class="right">© 2022 Getlead. All rights reserved.</h6>
               <div class="col-lg-4"></div>
               <div class="">
                  <ul class="list-footer">
                     <a href="#">
                        <li class="li-footer">
                           <p>Terms</p>
                        </li>
                     </a>
                     <a href="#">
                        <li class="li-footer">
                           <p>Partner with Us</p>
                        </li>
                     </a>
                     <a href="#">
                        <li class="li-footer">
                           <p>Privacy policy</p>
                        </li>
                     </a>
                     <a href="#">
                        <li class="li-footer">
                           <p>Login</p>
                        </li>
                     </a>
                     <a href="#">
                        <li class="li-footer">
                           <p>signup</p>
                        </li>
                     </a>
                  </ul>
               </div>
            </div>
         </div>
      </section>
      <script src="https://cdn.usebootstrap.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
      <script src="./script/script.js"></script>
   </body>
</html>