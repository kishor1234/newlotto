<head>
<?PHP $base="https://drrescribe.com/";?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <title>Rescribe | <?php echo $pageTitle; ?></title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <!--<base href="https://rescribe.in/"-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css">
    <!-- Google Tag Manager -->
<!--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PCK5GXP');</script>-->
<!-- End Google Tag Manager -->
    <link rel="stylesheet" href="<?=$base?>fonts/fonts.css">
    <link rel="stylesheet" href="<?=$base?>css/style.css">    
    <link rel="stylesheet" href="<?=$base?>css/main.css">
        <?php if($pageCss != ''){ echo "<link rel='stylesheet' href='{$base}css/{$pageCss}'>";} ?>
<style>
        .m-hide{
            display: block;
        }
        .d-hide{
            display: none;
        }
        
        @media only screen and (max-width: 768px) {
        .m-hide{
            display: none;
        }
        .d-hide{
            display: block;
        }
        .pdf-img{
            width: 100%;
            height: auto;
        }       
        .pdf-title{
            text-align: center;
            font-size: 1rem;
        }
        }
    </style>
</head>
