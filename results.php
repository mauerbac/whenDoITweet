<?php


session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];



<<<<<<< HEAD
$link= mysql_connect(HOST,DB_NAME,DB_PASS); //your DB info
=======
$link= mysql_connect("HOST","USER NAME","USER PASS"); //your DB info
>>>>>>> 00a58e4bc2892ec5f567c9429140a8b482a7125a
  if(!$link){

   die('cannot connect: ' . mysql_error()); 
}


<<<<<<< HEAD
 $db= mysql_select_db(DB_NAME); //your db name
=======
 $db= mysql_select_db("DB NAME"); //your db name
>>>>>>> 00a58e4bc2892ec5f567c9429140a8b482a7125a

  if(!$db){
    die('cannot select DB' . mysql_error());
  }

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);


$content = $connection->get('account/verify_credentials');
$name=$content->name;
$handle=$content->screen_name;
$fullName=$content->name;
$name=explode(" ", $name);
$first_name=$name[0];
$user_id=$content->id;
$numTweets=$content->statuses_count;
if($numTweets>3200){
  $numTweets=3200;
}
$pages=(int)($numTweets/200);
$pages++;


//week days
$mon; $tue; $wed; $thu; $fri; $sat; $sun;
//time bins
$morning; $afternoon; $evening; $night;
//months
$jan; $feb; $mar; $apr; $may; $jun; $jul; $aug; $sep; $oct;$nov;$dec;


for($i=1;$i<=$pages;$i++){
  $mentions= $connection->get('statuses/user_timeline',array('user_id' =>"$id", 'count'=>200,'page'=>"$i",'include_rts'=>"true",'exclude_replies'=>"false"));
  $count= count($mentions);
  $total=$total+ $count;
  for($j=0;$j<$count;$j++){
    $time=$mentions[$j]->created_at;
    $time=explode(" ", $time);
    $day=$time[0];
    $month=$time[1];
    $hour=$time[3];
    $hour=explode(":", $hour);
    $hour=$hour[0];
    
    if($day=="Mon"){
      $mon++;
    }else if($day=="Tue"){
      $tue++;
    }else if($day=="Wed"){
      $wed++;
    }else if($day=="Thu"){
      $thu++;
    }else if($day=="Fri"){
      $fri++;
    }else if($day=="Sat"){
      $sat++;
    }else if($day=="Sun"){
      $sun++;
    }


    //month
    if($month=="Jan"){
      $jan++;
    }else if($month=="Feb"){
      $feb++;
    }else if($month=="Mar"){
      $mar++;
    }else if($month=="May"){
      $may++;
    }else if($month=="Jun"){
      $jun++;
    }else if($month=="Jul"){
      $jul++;
    }else if($month=="Aug"){
      $aug++;
    }else if($month=="Sep"){
      $sep++;
    }else if($month=="Oct"){
      $oct++;
    }else if($month=="Nov"){
      $nov++;
    }else if($month=="Dec"){
      $dec++;
    }else if($month=="Apr"){
      $apr++;
    }

    //time  
    if($hour>=04 && $hour <12){
      $morning++;
    }else if($hour>=12 && $hour<17){
      $afternoon++;
    }else if($hour>=17 && $hour<21){
      $evening++;
    }else if($hour>=21 || $hour<04){
      $night++;
    }



  }
}

//calculate day
$arr = array('Monday' => $mon, 'Tuesday' => $tue, 'Wednesday' => $wed, 'Thursday' => $thu,'Friday' => $fri,'Saturday' => $sat,'Sunday' => $sun);
arsort($arr);
$mostPopDay = key($arr);
$valuePopDay=$arr[$mostPopDay];

//calculate month

$arr = array('January' => $jan, 'February' => $feb, 'March' => $mar, 'April' => $apr,'May' => $may,'June' => $jun,'July' => $jul,'August' => $aug,'September' => $sep,'October' => $oct,'November' => $nov,'December' => $dec);
arsort($arr);
$mostPopMonth = key($arr);
$valuePopMonth=$arr[$mostPopMonth];

//calculate time period
$arr = array('in the morning' => $morning, 'in the afternoon' => $afternoon, 'in the evening' => $evening, 'at night' => $night,);
arsort($arr);
$mostPopTime = key($arr);
$valuePopTime=$arr[$mostPopTime];
                                                                       
$sql="INSERT INTO `twitter` (`handle`,`name`,`day`,`time`,`month`) VALUES ('".$handle."','".$fullName."', '".$mostPopDay."', '".$mostPopTime."','".$mostPopMonth."')";
mysql_query($sql);
mysql_close();

?>        
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>When Do I Tweet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Matt Auerbach @mauerbac">

    <!-- CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: auto;
        max-width: 680px;
      }
      .container .credit {
        margin: 20px 0;
      }

      blu{
        color: #049cdb;
        font-size: 30px;
      }
      blu1{
        color: #049cdb;
        font-size: 15px;
      }

      .spacer {
        display:block;
        content: "";
      }

    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37323560-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Hey <span style="color: #049cdb"><?php print $first_name; ?>!</span> Your results</h1>
        </div>
        <p class="lead">Using <blu><?php print $total; ?> </blu> tweets we found you are most active on <blu> <?php print $mostPopDay.'\'s'; ?> </blu> with <blu> <?php print $valuePopDay?> </blu> tweets. During the month of <blu> <?php print $mostPopMonth ?> </blu> you were most active with <blu> <?php print $valuePopMonth?> </blu> tweets. Lastly, you are most active <blu> <?php print $mostPopTime?> </blu> with <blu> <?php print $valuePopTime?> </blu> tweets. </p> <br />
       <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://whendoitweet.info" data-text="I just found out when I tweet the most on" data-via="mauerbac" data-size="large" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <br />
        <br />
              <div class="accordion" id="accordion2">
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                     <h4> More Results (totals):</h4>
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse">
                    <div class="accordion-inner">
                    <br />
                     
              <?php 
                  function printArr($arr){
                      foreach ($arr as $key => $value) {
                          print "$key: <blu1>$value </blu1><br />";
                      } 
                  }
                    print "<h5><b>Day of Week</b></h5> ";
                    $arr = array('Monday' => $mon, 'Tuesday' => $tue, 'Wednesday' => $wed, 'Thursday' => $thu,'Friday' => $fri,'Saturday' => $sat,'Sunday' => $sun);
                    printArr($arr);
                    print "<h5><b>Month</b></h5>";
                    $arr = array('January' => $jan, 'February' => $feb, 'March' => $mar, 'April' => $apr,'May' => $may,'June' => $jun,'July' => $jul,'August' => $aug,'September' => $sep,'October' => $oct,'November' => $nov,'December' => $dec);
                    printArr($arr);
                    print "<h5><b>Time Period</b></h5>";
                    $arr = array('Morning (4am-Noon)' => $morning, 'Afternoon (Noon-5pm)' => $afternoon, 'Evening (5pm-9pm)' => $evening, 'Night (9pm-4am)' => $night,);  
                    printArr($arr);
                    ?>
                
                </div>
                
                  </div>
                </div>
                
          
            </div>

          </div>


      </div>
      <br /> <br /><br />
    <div id="footer">
      <div class="container">
        <p class="muted credit"> <p>&copy; <a href="http://mattsauerbach.com">Matt Auerbach</a>      <a href="http://twitter.com/mauerbac">@mauerbac</a> </p> 
      </div>
    </div>
 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
 <script src="js/jquery.js"></script>

  <script src="js/bootstrap-collapse.js"></script>


  </body>
</html>
