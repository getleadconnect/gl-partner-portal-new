{{-- <p>Hi,</p>
<p>{{ $invite->sender }} has invited you to signup with Gl-Partner.</p>
<a href="{{ route('accept-invitation', $invite->token) }}">Click here</a> to signup with Gl-Partner! --}}
<!doctype html>
<html lang="en-US">
<head>
   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
   <title>Invite Mail</title>
   <meta name="description" content="New Account Email Template.">
   <style type="text/css">
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
      body{
         font-family: 'Montserrat', sans-serif;
      }
      a:hover {text-decoration: underline !important;}
   </style>
</head>
<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #fff;" leftmargin="0">
   <!-- 100% body table -->
   <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#fff">
      <tr>
         <td>
            <table max-width:670px; margin:0 auto; width="100%" border="0"
            align="center" cellpadding="0" cellspacing="0">
            <tr>
               <td>
                  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                  style="max-width:670px; background-color: rgba(228, 57, 88, 0.1); ">
                  <tr>
                     <td style="height:80px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td style="text-align:left; padding:0 100px;">
                        {{-- <a href="#" title="logo" target="_blank">
                           <img width="40" src="{{ asset('images/logo.svg') }}" title="logo" alt="logo">
                        </a> --}}
                     </td>
                  </tr>
                  <tr>
                     <td style="height:25px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td style="padding:0 100px;">
                        <h1 style="color:#2F3941; font-weight:700; margin:0;font-size: 24px;font-family: 'Montserrat', sans-serif;">
                           Welcome To Partner Portal !!<br><br>
                        </h1>
                        <h3 style="color:#4D5459; font-weight:600; margin:0;font-size: 15px;font-family: 'Montserrat', sans-serif;line-height: 24px;">Hey, <br><br></h3>
                        <p style="color:#4D5459; font-weight:400; margin:0;font-size: 13px;font-family: 'Montserrat', sans-serif;line-height: 21px;">
                            We are excited to announce the launch of our new partner program, and we would like to invite you to join us as a partner.<br><br> 
                            {{ $invite->sender }} has invited you to signup with Gl-Partner.<br><br> 
                            <a href="{{ route('accept-invitation', $invite->token) }}">Click here</a> to signup with Gl-Partner!
                        </p>
                     </td>
                  </tr>
                  <tr>
                     <td style="height:150px;">&nbsp;</td>
                  </tr>

               </table>
            </td>
         </tr>
         <tr>
            <td style="height:50px;">&nbsp;</td>
         </tr>
        
         </table>
      </td>
   </tr>
</table>
<!--/100% body table-->
</body>
</html>
