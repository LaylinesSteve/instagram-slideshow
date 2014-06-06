<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Instagram - Slider</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="js/slides.min.jquery.js"></script>
  <script>
    $(function(){
      $('#slides').slides({
        preload: true,
        preloadImage: 'img/loading.gif',
        play: 5000,
        pause: 2500,
        hoverPause: true,
        animationStart: function(current){
          $('.caption').animate({
            bottom:-35
          },100);
        },
        animationComplete: function(current){
          $('.caption').animate({
            bottom:0
          },200);
        },
        slidesLoaded: function() {
          $('.caption').animate({
            bottom:0
          },200);
        }
      });
    });
  </script>
  <?php
    function fetch_data($url){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 20);
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }
    $count = 5; // Set the number of pictures to display 
    $client_id = "INSERT_CLIENT_ID"; // Client ID from registered client
    $userid = "INSERT_ID"; // Instagram User ID 
    $display_size = "low_resolution";
    
    $user_data = fetch_data("https://api.instagram.com/v1/users/{$userid}/media/recent/?count={$count}&access_token={$access_token}");
    $parse_data = json_decode($user_data);
  ?>
</head>
<body>
  <div id="logo">
    <img src="img/Instagram_Full_Logo_Small.png" width="134" height="36" alt="Instagram logo" id="ribbon">
  </div>
  <div id="container">
    <div id="example">
      <div id="slides">
        <div class="slides_container">
          <?php
            if(!empty($parse_data)):
              foreach ($parse_data->data as $photo):
                $img = $photo->images->{$display_size};
                $cap = $photo->caption->{"text"}; ?>
                <div class='slide'>
                  <a href='<?php echo $photo->link ?>'><img src='<?php echo $img->url ?>' /></a>
                  <?php if (!empty($cap)): ?>
                    <div class='caption' style='bottom:0'>
                      <p><?php echo $cap ?></p>
                    </div>
                  <?php endif; ?>
                </div>
            <?php endforeach; 
            else: ?>
              <h1>Not Feed Available</h1>
            <?php endif; ?>
        </div>
        <a href="#" class="prev"><img src="img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
      </div>
      <img src="img/example-frame.png" width="739" height="341" alt="Example Frame" id="frame">
    </div>
  </div>
</body>
</html>
