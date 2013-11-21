<style>
      #footer {
        height: 40px;
      }
      #footer {
        background-color: rgba(0,0,0,0.9);
	padding:10px;
	color:white;
      }

</style> 

<div id="footer">
      <div class="container">
      	AuctionBase &copy; 2013 <sub>(Ha! Not really!)</sub>
	<div style="float:right">Current Time: <?php $time = get_time();
	echo format_date($time); ?></div>
      </div>
</div>
