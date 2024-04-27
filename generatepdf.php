<?php 

    require(__DIR__."/vendor/autoload.php");

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $html='

    <!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 


    </head>
      
    <body>
      <div>
        <img src="img/BagongPinas.jpeg" style="width: 100px; height: 100px;"><img>
        <img src="img/CaloocanCityLogo.png" style="width: 100px; height: 100px;"><img>
      </div>
      <div>
          <img src="img/Brgy177Logo.jpg" style="width: 500px; height: 100px; align-items: center"></img>
      </div>
      <img src="img/Brgy177.png" style="width: 100px; height: 100px;"><img>


    </body>

    </html>
    
    
    
    
    
    
    
    ';
    

    $options = new Options;
    $options ->setChroot(__DIR__);

    $dompdf = new Dompdf([
      "chroot"=>__DIR__
    ]);

    $dompdf -> loadHtml($html);

    $dompdf->render();

    $dompdf->stream("good-moral.pdf", ["Attachment" =>0]);




?>