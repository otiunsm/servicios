
<?php $url = $_SERVER['REQUEST_URI'];?>

<?php  if(!isset($_GET['view']) && $url === '/'): ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Universidad Nacional de San Martín - Tarapoto</title>
        <meta charset="UTF-8">
        <meta name="title" content="Universidad Nacional de San Martín - Tarapoto">
        <meta name="description" content="Redireccionamiento UNSM-T">
        <link rel="icon" type="image/png" href="https://i.ibb.co/M8Zh75H/favicon.png">
        <link href="assets/css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Helvetica" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.js"></script>

    </head>
    <body>
        <div class="footer-distributed">

            <div class="footer-right">

                <a href="https://www.facebook.com/unsmperu/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/unsmperu" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/explore/locations/421115276/universidad-nacional-de-san-martin" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/school/universidad-nacional-de-san-mart%C3%ADn/" target="_blank" title="Linkedin"><i class="fab fa-linkedin"></i></a>
                <a href="https://www.youtube.com/channel/UCJY5_-Kj4K3soc0LtEC4sLA" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>

            </div>

            <div class="footer-left">

                <img class="image" src="https://i.ibb.co/6Z13tPC/logo.png" alt="Logo">

                <p class="footer-links" style="margin-top: -20px">
                    <a class="link-1" href="https://unsm.edu.pe">UNIVERSIDAD NACIONAL DE SAN MARTÍN</a>
                </p>

                <p class="slogan">Somos tu llave para triunfar</p>
                <!--<p class="copy">_</p>-->
            </div>

        </div>
        <div class="panels">
            <div class="panels__container" id="resultados">
                <a href="http://campusvirtual.unsm.edu.pe/login/index.php" class="panel">
                    <div class="panel__content" style="background-image: url(https://i.ibb.co/t2WFjBz/campus.jpg);">
<!--                        <div class="clock" style="z-index:-1; width:auto!important;"></div> <!-- HIDE IT! -->
                        <h3 class="panel__title">CAMPUS VIRTUAL PREGRADO</h3>
                    </div>
                </a>
                <a href="https://unsm.edu.pe/?view=portal" id="portal" class="panel">
                    <div class="panel__content" style="background-image: url(https://i.ibb.co/Kyb5gsJ/web.jpg)">
                        <h3 class="panel__title">PORTAL WEB</h3>
                    </div>
                </a>
            </div>
        </div>
        <!--<div class="footer-distributed">-->
			<div class="footer-left"><p class="copy" style="font-family:Verdana">Tarapoto, Perú - &copy; Copyright 2019 - Todos los derechos reservados</p></div>
		<!--</div>-->
    </body>

    <script type="text/javascript">
      var clock;

      $(document).ready(function() {
        var clock;

        clock = $('.clock').FlipClock({
              clockFace: 'HourlyCounter',
              autoStart: false,
              language:'spanish',
              callbacks: {
                stop: function() {
                  $('.message').html('The clock has stopped!')
                }
              }
          });


      var date = new Date("01 Mar 2020 13:00:00");
      var now = new Date();
      var diff = (date.getTime()/1000) - (now.getTime()/1000);

      clock.setTime(diff);
      clock.setCountdown(true);
      clock.start();

      });
    </script>

    </html>
<?php endif; ?>

<?php
    if(isset($_GET['view'])) {
        if($_GET['view'] === 'portal') {
            define('WP_USE_THEMES', true);
            require( dirname( __FILE__ ) . '/wp-blog-header.php' );
        }
    }

    if (!isset($_GET['view']) && $url !== '/') {
        define('WP_USE_THEMES', true);
        require( dirname( __FILE__ ) . '/wp-blog-header.php' );
    }
    ?>
