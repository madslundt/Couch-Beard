<?php $ajax_nonce = wp_create_nonce("keyy"); ?>
<?php get_header(); ?>
<?php
if (isset($_GET['id'])) {
	$url = "http://imdbapi.org/?id=".$_GET['id']."&episode=0&limit=1&plot=full";

	$json = file_get_contents($url);

	$data = json_decode($json);
?>
	<legend class="inverse"><?php echo $data->title; ?></legend>
	<div class="row">
		<div class="span3">
			<img src="<?php echo $data->poster; ?>" class="img-rounded"/>
			<?php if ($data->rating != null && $data->rating != "") { ?>
				<div class="rating" data-average="<?php echo $data->rating; ?>" data-id="1" data-toggle="tooltip" data-placement="bottom" title="<?php echo $data->rating . ' / ' . number_format($data->rating_count, 0, '.', ' '); ?>"></div>

				<div class="ratingtext"><center><p class="lead"><?php echo $data->rating; ?></p></center></div>
			<?php } ?>			
		</div>
		<div class="span9">
			<div class="row">
				<div class="span8 pull-left">
					<p class="lead pline"><?php echo implode(', ', $data->genres); ?></p>
				</div>
				<div class="span1">
					<p class="lead"><?php echo $data->year; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="span8 pull-left">
					<p class="lead pline"><?php echo implode(', ', $data->country); ?></p>
				</div>
				<div class="span1">
					<?php 
						$time = explode('min', $data->runtime[0])[0]; 
						$h = intval($time / 60);
						$m = ($h > 0) ? intval($h % 60) : intval($time);
					?>
					<p class="lead"><?php echo $h . ':' . $m; ?></p>
				</div>				
			</div>
			<div class="row">
				<div class="span8 pull-left">
					<p class="lead pline"><?php echo implode(', ', $data->actors); ?></p>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="span9 pull-left">
					<p><?php echo $data->plot; ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span2 pull-right">
			<?php
			if($data->type == 'M') {
				if (xbmc_movieOwned($data->imdb_id))
				{ ?>
					<button class="btn btn-inverse pull-right disabled" disabled="disabled"><?php _e('Movie owned', 'wpbootstrap'); ?></button>
				<?php }
				else if (cp_movieWanted($data->imdb_id))
				{ ?>
					<button class="btn btn-inverse pull-right disabled" disabled="disabled"><?php _e('Movie added', 'wpbootstrap'); ?></button>
				<?php }
				else
				{
				?>
					<button class="btn btn-inverse pull-right" id="addMovie"><?php _e('Add movie', 'wpbootstrap'); ?></button>
				<?php
				}
			} else { ?>
				<button class="btn btn-inverse pull-right" id="addTV"><?php _e('Add TV show', 'wpbootstrap'); ?></button>
			<?php } ?>
		</div>
		<div class="span1 pull-left">
			<a href="<?php echo $data->imdb_url; ?>"><img id="imdblogo" alt="IMDB" src="<?php print IMAGES; ?>/imdb-logo.png" /></a>
		</div>	
	</div>
<!--
	<div class="row">
		<div class="row">
			<div class="span3">
				<div class="coverSearch">
	    			<img src="<?php echo $data->poster; ?>" class="img-rounded"/>
	    			<?php if ($data->rating != null && $data->rating != "") { ?>
	    				<div class="rating" data-average="<?php echo $data->rating; ?>" data-id="1" data-toggle="tooltip" data-placement="bottom" title="<?php echo $data->rating . ' / ' . number_format($data->rating_count, 0, '.', ' '); ?>"></div>

	    				<div class="ratingtext"><center><p class="lead"><?php echo $data->rating; ?></p></center></div>
	    			<?php } ?>
	    		</div>
			</div>
			<div class="span9">
				<div class="row">
					<div class="span6">
	  					<p class="lead"><?php echo implode(', ', $data->genres); ?></p>
					</div>
					<div class="span1 pull-right">
						<p class="lead"><?php echo $data->country[0]; ?></p>
	  				</div>
	  				<div class="span1 pull-right">
						<p class="lead"><?php echo $data->year; ?></p>
	  				</div>
				</div>
				<div class="row">
					<div class="span3">
						<p class="lead"><?php echo implode(', ', $data->language); ?></p>
					</div>
					<div class="span3">
						<p class="lead"><?php date('g:i', strtotime('today ' . (string) $data->runtime[0])); ?></p>
					</div>
				</div>
				<p><?php echo $data->plot; ?></p>
			</div>
		</div>
		<div class="span2 pull-right">
			<?php if($data->type == 'M') {
				if (cp_movieWanted($data->imdb_id))
				{ ?>
					<button class="btn btn-inverse pull-right disabled" disabled="disabled"><?php _e('Movie added', 'wpbootstrap'); ?></button>
				<?php }
				else
				{
				?>
					<button class="btn btn-inverse pull-right" id="addMovie"><?php _e('Add movie', 'wpbootstrap'); ?></button>
				<?php
				}
			} else { ?>
				<button class="btn btn-inverse pull-right" id="addTV"><?php _e('Add TV show', 'wpbootstrap'); ?></button>
			<?php } ?>
		</div>
		<div class="span1 pull-right">
			<a href="<?php echo $data->imdb_url; ?>">IMDb</a>
		</div>
	</div>-->
	
	


<?php
}
function imdb_to_tvdb($imdb)
{
	$xml = simplexml_load_string(file_get_contents("http://thetvdb.com/api/GetSeriesByRemoteID.php?imdbid=".$imdb));
	return (string) $xml->Series->children()->seriesid;
}

?>

<div id="notification">
	<div id="default">
		<h1>#{title}</h1>
		<p>#{text}</p>
	</div>

	<div id="withIcon">
		<a class="ui-notify-close ui-notify-cross" href="#">x</a>
		<div style="float:left;margin:0 10px 0 0"><img src="#{icon}" alt="warning" /></div>
		<h1>#{title}</h1>
		<p>#{text}</p>
	</div>
</div>

<script>
function create( template, vars, opts ){
	return $notifyContainer.notify("create", template, vars, opts);
}

$(function() {
	$("#notification").notify({
	  speed: 500,
	  expires: 5000
	});

	$(".rating").jRating({
	  step:true,
	  type: '18',
	  length: 10,
	  rateMax: 10, 
	  isDisabled: true,
	  decimalLength:0
	});

	$(".rating").hover(
		function () {
			$('.rating').tooltip('show');
		}		
	);


	$notifyContainer = $("#notification").notify();   

    $("#addMovie").on("click", function() {
        jQuery.ajax({  
            type: 'POST',
            cache: false,  
            url: "<?php echo home_url() . '/wp-admin/admin-ajax.php'; ?>",  
            data: {  
                action: 'addMovie',
                security: '<?php echo $ajax_nonce; ?>',
                id: '<?php echo $data->imdb_id; ?>'
            },
            success: function(data, textStatus, XMLHttpRequest) {
            	if (data == 1) {
					create("default", { title:'<?php _e("Movie added", "wpbootstrap"); ?>', text:'<?php printf(__("%s was added", "wpbootstrap"), $data->title); ?>'});
					$('#addMovie').attr("disabled", true);
					$('#addMovie').html('<i>Movie added</i>');
	        	} else {
	        		create("withIcon", { title:'Error!', text:'<?php printf(__("%s was not added", "wpbootstrap"), $data->title); ?>', icon:'<?php print IMAGES; ?>/alert.png' },{ 
						expires:false});
	        	}
            },  
            error: function(MLHttpRequest, textStatus, errorThrown) {
                alert("<?php _e('There was an error adding the movie. The movie was not added.', 'wpbootstrap'); ?>");  
            }  
        });         
    });

    $("#addTV").on("click", function() {
        jQuery.ajax({  
            type: 'POST',
            cache: false,  
            url: "<?php echo home_url() . '/wp-admin/admin-ajax.php'; ?>",  
            data: {  
                action: 'addTV',
                security: '<?php echo $ajax_nonce; ?>',
                id: '<?php if ($data->type != "M") echo imdb_to_tvdb($data->imdb_id); ?>'
            },
            success: function(data, textStatus, XMLHttpRequest) {
				if (data == 1) {
					create("default", { title:'<?php _e("TV show added", "wpbootstrap"); ?>', text:'<?php printf(__("%s was added", "wpbootstrap"), $data->title); ?>'});
					$('#addTV').attr("disabled", true);
					$('#addTV').html('<i>TV show added</i>');
	        	} else {
	        		create("withIcon", { title:'Error!', text:'<?php printf(__("%s was not added", "wpbootstrap"), $data->title); ?>', icon:'<?php print IMAGES; ?>/alert.png' },{ 
						expires:false});
	        	}            	
            },  
            error: function(MLHttpRequest, textStatus, errorThrown) {
                alert("<?php _e('There was an error adding the movie. The movie was not added.', 'wpbootstrap'); ?>");  
            }  
        });         
    });
});

(function($) {
	$.fn.jRating = function(op) {
		var defaults = {
			/** String vars **/
			bigStarsPath : '<?php print IMAGES; ?>/stars.png', // path of the icon stars.png
			smallStarsPath : '<?php print IMAGES; ?>/small.png', // path of the icon small.png
			star18Path : '<?php print IMAGES; ?>/stars18.png',
			star15Path : '<?php print IMAGES; ?>/stars15.png',
			phpPath : '', // path of the php file jRating.php
			type : 'big', // can be set to 'small' or 'big'

			/** Boolean vars **/
			step:false, // if true,  mouseover binded star by star,
			isDisabled:false,
			showRateInfo: true,
			canRateAgain : false,

			/** Integer vars **/
			length:5, // number of star to display
			decimalLength : 0, // number of decimals.. Max 3, but you can complete the function 'getNote'
			rateMax : 20, // maximal rate - integer from 0 to 9999 (or more)
			rateInfosX : -45, // relative position in X axis of the info box when mouseover
			rateInfosY : 5, // relative position in Y axis of the info box when mouseover
			nbRates : 1,

			/** Functions **/
			onSuccess : null,
			onError : null
		}; 

		if(this.length>0)
		return this.each(function() {
			/*vars*/
			var opts = $.extend(defaults, op),    
			newWidth = 0,
			starWidth = 0,
			starHeight = 0,
			bgPath = '',
			hasRated = false,
			globalWidth = 0,
			nbOfRates = opts.nbRates;

			if($(this).hasClass('jDisabled') || opts.isDisabled)
				var jDisabled = true;
			else
				var jDisabled = false;

			getStarWidth();
			$(this).height(starHeight);

			var average = parseFloat($(this).attr('data-average')), // get the average of all rates
			idBox = parseInt($(this).attr('data-id')), // get the id of the box
			widthRatingContainer = starWidth*opts.length, // Width of the Container
			widthColor = average/opts.rateMax*widthRatingContainer, // Width of the color Container

			quotient = 
			$('<div>', 
			{
				'class' : 'jRatingColor',
				css:{
					width:widthColor
				}
			}).appendTo($(this)),

			average = 
			$('<div>', 
			{
				'class' : 'jRatingAverage',
				css:{
					width:0,
					top:- starHeight
				}
			}).appendTo($(this)),

			 jstar =
			$('<div>', 
			{
				'class' : 'jStar',
				css:{
					width:widthRatingContainer,
					height:starHeight,
					top:- (starHeight*2),
					background: 'url('+bgPath+') repeat-x'
				}
			}).appendTo($(this));
			

			$(this).css({width: widthRatingContainer,overflow:'hidden',zIndex:1,position:'relative'});

			if(!jDisabled)
			$(this).unbind().bind({
				mouseenter : function(e){
					var realOffsetLeft = findRealLeft(this);
					var relativeX = e.pageX - realOffsetLeft;
					if (opts.showRateInfo)
					var tooltip = 
					$('<p>',{
						'class' : 'jRatingInfos',
						html : getNote(relativeX)+' <span class="maxRate">/ '+opts.rateMax+'</span>',
						css : {
							top: (e.pageY + opts.rateInfosY),
							left: (e.pageX + opts.rateInfosX)
						}
					}).appendTo('body').show();
				},
				mouseover : function(e){
					$(this).css('cursor','pointer');	
				},
				mouseout : function(){
					$(this).css('cursor','default');
					if(hasRated) average.width(globalWidth);
					else average.width(0);
				},
				mousemove : function(e){
					var realOffsetLeft = findRealLeft(this);
					var relativeX = e.pageX - realOffsetLeft;
					if(opts.step) newWidth = Math.floor(relativeX/starWidth)*starWidth + starWidth;
					else newWidth = relativeX;
					average.width(newWidth);					
					if (opts.showRateInfo)
					$("p.jRatingInfos")
					.css({
						left: (e.pageX + opts.rateInfosX)
					})
					.html(getNote(newWidth) +' <span class="maxRate">/ '+opts.rateMax+'</span>');
				},
				mouseleave : function(){
					$("p.jRatingInfos").remove();
				},
				click : function(e){
                    var element = this;
					
					/*set vars*/
					hasRated = true;
					globalWidth = newWidth;
					nbOfRates--;
					
					if(!opts.canRateAgain || parseInt(nbOfRates) <= 0) $(this).unbind().css('cursor','default').addClass('jDisabled');
					
					if (opts.showRateInfo) $("p.jRatingInfos").fadeOut('fast',function(){$(this).remove();});
					e.preventDefault();
					var rate = getNote(newWidth);
					average.width(newWidth);
					

					/** ONLY FOR THE DEMO, YOU CAN REMOVE THIS CODE **/
						$('.datasSent p').html('<strong>idBox : </strong>'+idBox+'<br /><strong>rate : </strong>'+rate+'<br /><strong>action :</strong> rating');
						$('.serverResponse p').html('<strong>Loading...</strong>');
					/** END ONLY FOR THE DEMO **/

					$.post(opts.phpPath,{
							idBox : idBox,
							rate : rate,
							action : 'rating'
						},
						function(data) {
							if(!data.error)
							{
								/** ONLY FOR THE DEMO, YOU CAN REMOVE THIS CODE **/
									$('.serverResponse p').html(data.server);
								/** END ONLY FOR THE DEMO **/


								/** Here you can display an alert box, 
									or use the jNotify Plugin :) http://www.myqjqueryplugins.com/jNotify
									exemple :	*/
								if(opts.onSuccess) opts.onSuccess( element, rate );
							}
							else
							{

								/** ONLY FOR THE DEMO, YOU CAN REMOVE THIS CODE **/
									$('.serverResponse p').html(data.server);
								/** END ONLY FOR THE DEMO **/

								/** Here you can display an alert box, 
									or use the jNotify Plugin :) http://www.myqjqueryplugins.com/jNotify
									exemple :	*/
								if(opts.onError) opts.onError( element, rate );
							}
						},
						'json'
					);
				}
			});

			function getNote(relativeX) {
				var noteBrut = parseFloat((relativeX*100/widthRatingContainer)*opts.rateMax/100);
				switch(opts.decimalLength) {
					case 1 :
						var note = Math.round(noteBrut*10)/10;
						break;
					case 2 :
						var note = Math.round(noteBrut*100)/100;
						break;
					case 3 :
						var note = Math.round(noteBrut*1000)/1000;
						break;
					default :
						var note = Math.round(noteBrut*1)/1;
				}
				return note;
			};

			function getStarWidth(){
				switch(opts.type) {
					case 'small' :
						starWidth = 12; // width of the picture small.png
						starHeight = 10; // height of the picture small.png
						bgPath = opts.smallStarsPath;
					break;
					case '18' :
						starWidth = 18;
						starHeight = 16;
						bgPath = opts.star18Path;
					break;
					case '15' :
						starWidth = 15;
						starHeight = 13;
						bgPath = opts.star15Path;
					break;					
					default :
						starWidth = 23; // width of the picture stars.png
						starHeight = 20; // height of the picture stars.png
						bgPath = opts.bigStarsPath;
				}
			};

			function findRealLeft(obj) {
			  if( !obj ) return 0;
			  return obj.offsetLeft + findRealLeft( obj.offsetParent );
			};
		});

	}
})(jQuery);
</script>

<?php get_footer(); ?>