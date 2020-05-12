
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>[[PAGE_NAME]]</title>
        <meta name="generator" content="BBEdit 10.5" />
        <meta name="viewport" content="width device-width" />

        <style>
            body#message {
                font: 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif !important;
                color: #333 !important;
                background-color: #ffffff !important;
                margin:0 !important;
                padding:0 !important;
                width:100% /* !important */;
                /* was 685px */;
            }

            /*
            same width=as body, because Rover adds this div
            */
            body/*, .main*/ {
            }

            .main {
                width: 685px;
                /* was 665px */;
            }

            #apple-logo-left-margin {
                width: 538px !important;
            }

            #logo-row-box {
                width:100%;
                text-align:right;
                padding-bottom:20px !important;
            }

            h1, em, b {
                font-weight: bold;
            }

            h1, td.h1-header {
                font-family: 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;
                font-size: 14px;
                line-height: 18px;
                margin-bottom: 0;
                border-bottom: none;
            }

            p {
                font-weight: 300;
                margin-top: 0 !important;
                margin-bottom: 18px !important;
                word-wrap: break-word;
            }

            td.paragraph {
                padding:0 0 18px !important;
            }

            td.h1-header {
                padding:0 !important;
            }

            #signature {
                padding-top:18px !important; /* was 41px */
                padding-bottom:50px !important;
            }

            em {
                font-family: 'Lucida Grande Bold', 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;
                font-style: normal;
            }

            em a {
                color: #333;
            }

            a {
                color: #08c;
                text-decoration: none;
            }

            span.unlink a,
            em a,
            b a {
                color: #333;
                cursor: text;
                pointer-events: none;
            }

            #main {
                margin-top: 40px;
                padding-right: 60px;
                padding-left: 60px;
            }

            img#footer-gradient {
                position:relative;
                /* left:-70px;  does not work in Outlook.com */
                /* width: 825px !important; */

                width:100% !important;
                height:16px !important;
            }

            .footer-hr,
            footer hr {
                height: 1px;
                background-color: #FEFEFE;
                background-image: linear-gradient(left, #FEFEFE 0%, #EAEAEA 6%, #EAEAEA 94%, #FEFEFE 100%);
                background-image: -moz-linear-gradient(left, #FEFEFE 0%, #EAEAEA 6%, #EAEAEA 94%, #FEFEFE 100%);
                background-image: -ms-linear-gradient(left, #FEFEFE 0%, #EAEAEA 6%, #EAEAEA 94%, #FEFEFE 100%);
                background-image: -o-linear-gradient(left, #FEFEFE 0%, #EAEAEA 6%, #EAEAEA 94%, #FEFEFE 100%);
                background-image: -webkit-gradient(linear, left top, right top, color-stop(0.0, #FEFEFE), color-stop(0.5, #FAFAFA), color-stop(1.0, #FEFEFE));
                background-image: -webkit-linear-gradient(left, #FEFEFE 0%, #EAEAEA 6%, #EAEAEA 94%, #FEFEFE 100%);
            }

            .footer-radial-gradient {
                height: 18px;
                border-width: 0;
                background: radial-gradient(342px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                background: -moz-radial-gradient(342px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                background: -ms-radial-gradient(342px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                background: -o-radial-gradient(342px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                background: -webkit-gradient(radial, 342px 0px, color-stop(0.0, #F8F8F8), color-stop(1.0, #FEFEFE));
                background: -webkit-radial-gradient(342px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
            }

            footer,
            footer p,
            footer span.unlink a,
            footer td.paragraph {
                font: 11px/15px Geneva, Verdana, Arial, Helvetica, sans-serif;
                color: #888;
            }

            .center-text,
            footer nav,
            footer p {
                text-align: center;
            }

            footer a:hover {
                text-decoration: underline;
            }

            .no-margin-bottom {
                margin-bottom: 0 !important;
            }

            html[dir=rtl] #apple-logo {
                left:0;
                right:538px;
            }

            p#copyright {
                margin-bottom: 0;
            }

            .display-block {
                display:block !important;
            }

            .nowrap {
                white-space: nowrap;
            }

            #apple-logo-margin-bottom {
                height: 44px !important;
            }

            #left-align-on-reply {
                /* moved from body */
                margin: 0px auto 50px;
                padding:0;
                width: 685px;
            }

            #apple-logo-cell {
                width:100%;
                padding-top:40px;
                padding-bottom:44px;
            }

            #apple-logo-in-cell {
                height: 28px !important;
                width: 24px !important;
            }

            #apple-logo-in-row-box-mobile {
                display: none;
                height: 20px !important;
                width: 17px !important;
            }

            /* If the email client is reading the style element: */

            /* - then we don't need spacer divs */
            div.paragraph-spacer {
                display:none;
                height:0px !important;
                margin-bottom:0px !important;
            }

            /* - and margin-top already is in effect on #main */
            #apple-logo-margin-top {
                height:0px !important;
            }

            #logo-row-box {
                padding-top:0 !important;
            }


            /* normally max-width: 320px */
            @media (max-width:320px) {

                /* body[yahoo] prevents Yahoo! Mail from reading these rules, because it cannot read attribute selectors */
                body[yahoo]#message {
                    -webkit-text-size-adjust:none;
                }

                body[yahoo] #apple-logo-left-margin {
                    width:275px !important;
                }

                body[yahoo] #main {
                    margin-top:18px;
                    padding-right:0;
                    padding-left:0;
                }

                body[yahoo] #apple-logo-in-row-box {
                    /* Not using hide and show approach between small and large imgs because Outlook Express 6 shows both imgs on reply */

                    /*
                    display:none !important;
                    height:0px !important;
                    width:0px !important;
                    */

                    height:20px !important;
                    width:17px !important;
                }

                body[yahoo] #apple-logo-in-row-box-mobile {
                    /* display:inline-block !important; Not using hide and show approach between small and large imgs because Outlook Express 6 shows both imgs on reply */
                }

                body[yahoo] #apple-logo-margin-bottom {
                    height:6px !important;
                }

                body[yahoo] #logo-row-box {
                    padding-bottom:9px !important;
                }

                body[yahoo] p {
                    margin-bottom:20px;
                }

                td.paragraph {
                    padding:0 0 20px !important;
                }

                body[yahoo] p#signature {
                    margin-top:36px !important;
                    margin-bottom:28px !important;
                }

                body[yahoo] td#signature {
                    padding-top:18px !important; /* was 36px */
                    padding-bottom:28px !important;
                }

                body[yahoo] .footer-radial-gradient {
                    height:0px;
                    border-width:0;
                    background: radial-gradient(150px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                    background: -moz-radial-gradient(150px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                    background: -ms-radial-gradient(150px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                    background: -o-radial-gradient(150px 0px, farthest-side, #F8F8F8 0%, #FEFEFE 100%);
                    background: -webkit-gradient(radial, 150px 0px, color-stop(0.0, #F8F8F8), color-stop(1.0, #FEFEFE));
                    background: -webkit-radial-gradient(150px 0px, farthest side, #F8F8F8 0%, #FEFEFE 100%);
                }

                body[yahoo] img#footer-gradient {
                    display:block !important;
                    left:0;
                    width:288px !important;
                }

                body[yahoo] img#footer-gradient + p {
                    margin-bottom:12px !important;
                }

                body[yahoo] td#footer-links {
                    padding-bottom:12px !important;
                }

                body[yahoo] #copyright #apple-address,
                body[yahoo]  #copyright #all-rights-reserved {
                    display:block;
                }

                body[yahoo] #left-align-on-reply {
                    /* moved from body  */
                    padding-right:16px;
                    padding-left:16px;
                    width:300px;
                }

                body[yahoo] footer {
                    font:11px/15px 'Helvetica Neue', Helvetica, Geneva, Verdana, Arial, sans-serif;
                }
            }
        </style>

        <!--[if lt IE 10]>
        <style>
            em {
                font-weight:bold;
            }
        </style>
        <![endif]-->

        <!--[if IE 9]>
        <style>
    
            .footer-hr,
            .footer-radial-gradient {
                display:block;
            }
    
            .footer-radial-gradient {
                width:825px;
                background:url('https://cdn.dancewithmadhuri.com/common/images/line-gradient.png') no-repeat;
                background-size:825px 18px;
                left:-70px;
            }
    
            img#footer-gradient {
                display:none;
            }
        </style>
        <![endif]-->

        <!--[if IE 8]>
        <style>
            .footer-hr,
            .footer-radial-gradient {
                display:none;
            }
    
            img#footer-gradient {
                display:block !important;
                margin-right:auto;
                margin-left:auto;
            }
        </style>
        <![endif]-->

    </head>

    <!-- body[yahoo] is being used to prevent Yahoo! Mail from reading these rules, because it cannot read attribute selectors -->
    <body id="message" style="background-color:#fff;" yahoo="fix">
        <div id="left-align-on-reply" dir="ltr">
            <div id="main">
                <!--<div id="apple-logo-margin-top" style="height:40px;"></div>-->
                <div id="logo-row-box" style="width:95%;text-align: right;padding-top:6%;padding-bottom:6%;">
                    <img id="apple-logo-in-row-box" src="http://poolcampus.co.in/asets/images/logo.png" style="display:inline-block;height:71px;width:153px;right:0px;"><!--<img id="apple-logo-in-row-box-mobile" src="https://cdn.dancewithmadhuri.com/common/images/logo-small.png" style="display:none;height:0;width:0;right:0px;" height="0" width="0">--><!--Two logos are appearing on reply in Windows XP Outlook Express-->
                </div>

                <table id="message-body-wrapper" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td id="message-body-left-margin" width="0"></td><td id="message-body">
                            <table id="paragraphs" border="0" cellpadding="0" cellspacing="0">
                                <tr><td class="paragraph" style="padding:0 5% 18px;font:300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;color:#333;">Dear <?=$name?>,</td></tr>
                                <tr><td class="paragraph" style="padding:0 5% 18px;font:300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;color:#333;">Congratulations you successfully create account, one more step left to active your account <em style="font-family: 'Lucida Grande Bold', 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;font-style:normal;"><?=$email?></em>. To verify this email address belongs to you and to find  your dream jobs, click the link below.</td></tr>
                                <tr><td class="paragraph" style="padding:0 5% 18px;font:300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;color:#333;"><a href="<?=$shortLink?>" style="line-height:18px;color:#08c;text-decoration:none;" role="link">Verify </a></td></tr>
                                <tr><td id="signature" class="paragraph" style="padding:18px 5% 51px;font:300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif;color:#333;"><?=company?> Support</td></tr>
                            </table><!--end table#paragraphs-->
                        </td><!--end td#message-body-->
                    </tr>
                </table><!--end table#message-body-wrapper-->
            </div><!--end #main -->

            <footer style="width:100%;">
                <div class="footer-radial-gradient" style="display:none;"></div>
                <!--fallback image below for IE 8, 9-->

                <table id="footer-paragraphs" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                    <tr><td id="footer-hr-cell"><div class="footer-hr" style="height:1px;" height="1"></div></td></tr>
                    <tr><td id="footer-gradient-img-cell" style="width:100%"><img id="footer-gradient" src="https://cdn.dancewithmadhuri.com/common/images/line-gradient.png" style="display:block;width:100%;" height="16"><!--width was 593,  width="100%"--></td></tr>
                    <tr><td id="copyright-cell" style="padding:0;margin-bottom:0;text-align:center;font:11px/15px Geneva, Verdana, Arial, Helvetica, sans-serif;color:#888;">Copyright &copy; 2014 <span id="apple-address" class="unlink " ><a href="http://aasksoft.co.in">@askSoft Pvt. Ltd.</a>&#x200E;</span> <span id="all-rights-reserved">All Rights Reserved.</span></td></tr>
                </table>
            </footer>
        </div><!--end #left-align-on-reply-->
    </body>
</html>