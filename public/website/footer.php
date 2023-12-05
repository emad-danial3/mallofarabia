<div class="col-md-10"></div>

<div class="col-md-2" style="text-align:right;color:#484848;">GET STARTED</div>
<div class="col-md-10"></div>

<div class="col-md-2" style="text-align:center;border:solid 1px  #3487a8;margin-bottom:10px;color:#3487a8;font-size: 22px;"><a href="join.php">JOIN OUR FAMILY</a></div>

  <div class="col-md-12 hidden-sm hidden-xs" style="background-image: linear-gradient(to right, rgba(179,179,179,1), rgba(223,223,223,1),rgba(179, 179, 179, 1));padding:10px;">
      
      <a style="color:black;" href="index.php"><span style="margin-left:100px;margin-right:200px;">HOME</span></a>
      
       <a style="color:black;" href="terms.php"><span style="margin-right:200px;">TERMS OF USE</span></a>
  
   <a style="color:black;" href="privacy.php"><span style="margin-right:200px;">PRIVACY POLICY </span></a>
  
   <a style="color:black;" href="contactus.php"><span style="margin-right:200px;">Contact US</span></a>
  </div>

 <div class="col-sm-12 col-xs-12   hidden-md hidden-lg" style="background-image: linear-gradient(to right, rgba(179,179,179,1), rgba(223,223,223,1),rgba(179, 179, 179, 1));padding:10px;font-size:11px;text-align:center;">
      
      <a style="color:black;" href="index.php"><span style="margin-right:10px;">HOME</span></a>
      
      <a style="color:black;" href="terms.php"><span style="margin-right:10px;">TERMS OF USE</span></a>
  
 <a style="color:black;" href="privacy.php"><span style="margin-right:10px;">PRIVACY POLICY </span></a>
  
  <a style="color:black;" href="contactus.php"><span style="margin-right:10px;">Contact US</span></a>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$('#mySlider').on('slide.bs.carousel', function (e) {
    
  var $e = $(e.relatedTarget);
  $e.removeClass('active-next');
  
  var $next = $e.next();
  if ($next.length===0){
      $next = $('.item').eq(0);
  }
  
  var $nextnext = $e.next().next();
  if ($nextnext.length===0){
      $nextnext = $('.item').eq(1);
  }
  
  console.log($('.item').length);
  console.log($next.index());
  
  if ($next.index() == 1) {
      $('.item').removeClass('col-md-push-4 col-md-push-8 col-md-pull-4 col-md-pull-8');
  }
  
  if ($next.index() == 0) {
      console.log("last");
      $('.item').eq(0).toggleClass('col-md-push-8 col-md-push-4');
      $('.item').eq(1).toggleClass('active-next col-md-push-4');
      $('.item').eq($('.item').length-1).toggleClass('col-md-pull-4 col-md-pull-8');
  }
  else if ($next.index() < ($('.item').length-1)) {
      $next.addClass('active-next');
      $nextnext.addClass('active-next');
  }
  else {
      console.log("2nd last");
      $('.item').eq($next.index()-1).addClass('col-md-pull-4');
      $next.addClass('active-next col-md-pull-4');
      $('.item').eq(0).addClass('active-next col-md-push-8');
  }
  
  $('.active,.active-next').addClass('transitioning');    
  setTimeout(function(){
      $('.transitioning').removeClass('transitioning');
  },300)
  
});
</script>
<style>
@media (min-width: 992px) {
    .item.active-next {
        display: block;
    }
}

.carousel-inner > .item.active,
.carousel-inner > .item.active-next {
  opacity: 1;
  transition: all 0.3s ease;
}

.carousel-inner > .item:not(.active):not(.active-next) {
  opacity: 0.5;
  
}

.carousel-inner > .item.transitioning {
   opacity: 0.2;
   transition: all 0.4s ease;
}

.carousel-control.left,
.carousel-control.right {
    background-image: initial;
}

.carousel-inner > .item.active {
  transform: translate3d(0,0,0);
}
.carousel-inner > .item.active.col-md-pull-4,
.carousel-inner > .item.active.col-md-pull-8 {
  left:initial;
}

</style>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </div>
  </div>
  </body>
</html>