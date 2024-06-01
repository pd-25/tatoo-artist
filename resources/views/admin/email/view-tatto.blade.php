<!doctype html>
        <html class='no-js' lang='en'>
           <head>
              <meta charset='utf-8'>
              <meta http-equiv='x-ua-compatible' content='ie=edge'>
              <title>SubmitFormLink</title>
              <meta name='description' content=''>
              <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap' rel='stylesheet'>
              <style>
                 body{
                    font-family: 'Roboto', sans-serif;
                 }
                 h1, h2, h3, h4, h5, h6, p, a{
                    font-family: 'Roboto', sans-serif;
                 }
              </style>
           </head>
           <body>
              <table align='center' border='0' cellpadding='0' cellspacing='0' style='background:#F6F6F6;padding: 20px;color:#232f3e; font-family:helvetica,arial,sans-serif; font-size:15px; line-height:24px; margin:20px auto 0; width:600px'>
                 <tbody>
                    <tr>
                       <td>
                          <table border='0' cellpadding='0' cellspacing='0' style='width:100%; padding: 10px;'>
                             <tbody>
                                <tr>
                                   <td>
                                      <table border='0' cellpadding='0' cellspacing='0' style='width:100%; text-align: center;'>
                                         <tbody>
                                            <tr>
                                               <td>
                                                  <img src=".url("admin-asset/images/logo.png")." alt=''>
                                               </td>
                                            </tr>
                                            <tr style='height: 40px;'>
                                               <td></td>
                                            </tr>
                                            <tr>
                                               <td>
                                                  <h2 style='font-size: 32px;'>TATTOO INFORMED CONSENT</h2>
                                               </td>
                                            </tr>
                                         </tbody>
                                      </table>
                                   </td>
                                </tr>
                                <tr style='height: 30px;'>
                                   <td></td>
                                </tr>
                                <tr>
                                   <td style='text-align: center;background: #FFF;padding:20px 30px;border-radius: 10px;'>
                                      <!-- <h5 style='color: #6D717A;font-size: 20px;line-height: 23px;'>If you've lost your password or wish to reset it, use the link below to get started.</h5> -->
                                      <h4>
                                        <a href="{{ $fullpath }}" style='color: #FFF;text-align: center;background: #EE5719;padding: 15px 50px;border-radius: 50px;margin: 10px auto;text-decoration: none;display: inline-block;'>
                                        View Pdf
                                        </a>
                                      </h4>
                                      <!-- <p>If you did not request a password reset, you can safely ignore this email. Only a person with access to your email can reset your account password.</p> -->
                                   </td>
                                </tr>
                                <tr style='height: 70px;'>
                                   <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <p>Copyright &copy; {{ date('Y') }} test. All Rights Reserved.</p>
                                        <a href="#" style="font-size: 14px; margin-right: 5px; text-decoration: none; color: #ee5719;"><img src="{{ asset("frontend/img/emailtemplateimage/phone.svg") }}" alt=""> +91 XXXXXXXXXX </a>
                                        <a href="#" style="font-size: 14px; margin-right: 5px; text-decoration: none; color: #ee5719;"><img src="{{ asset("frontend/img/emailtemplateimage/mail.svg") }}" alt=""> tatto@tatto.com </a>
                                    </td>
                                </tr>
                             </tbody>
                          </table>
                       </td>
                    </tr>
                 </tbody>
              </table>
           </body>
        </html>
