<div class="span12">
	<?php
	try {
		$xbmc = new xbmc();
	} catch (Exception $e) {
		_e('xbmc is not online.', 'couchbeard');
		echo '</div>';
		return;
	}

	try {
		$sb = new sickbeard();
		$sb_shows = $sb->getShows();
	} catch (Exception $e) {}

	$page = isset($_GET['page']) ? absint($_GET['page']) : 1;
	$limit = 14;
	$offset = ($page - 1) * $limit;

	$shows = $xbmc->getShows($offset, $limit);
	if (empty($shows)) {
		_e('No TV shows owned', 'couchbeard');
	} else {
	foreach ($shows as $show) { ?>
			<div id="wantedSearchCover">
				<a class="nolink" href="<?php echo get_permalink(getSearchpageID()) . '&id=' . $show->label; ?>">
					<div id="wantedCoverOverlay">
						<p class="nolink"><?php echo $show->label . ' (' . $show->year . ')'; ?></p>
					</div>
					<img class="lazysporty" id="wantedSearchpageCover" src="<?php print IMAGES; ?>/no_cover.png" data-original="<?php echo urldecode(substr($show->thumbnail, 8, -1)); ?>"/>
					<?php
					if (!empty($sb_shows) && in_array($show->imdbnumber, array_keys((array) $sb_shows)))
					{
						echo '<img class="sb" src="' . IMAGES . '/SB_Logo.png">';
					}
					?>
				</a>
			</div>	
		<?php } ?>

		</div>
	</div>
<div class="row">
	<div class="span12">
		<ul class="pager">
			<li class="previous <?php echo ($page > 1) ? '' : 'disabled'; ?>">
		    	<a onClick="<?php echo ($page > 1) ? '' : 'return false'; ?>" href="<?php echo get_permalink() . '&page=' . (($page > 1) ? $page - 1 : 1); ?>">Previous</a>
	  		</li>
		  	<li class="next">
		    	<a href="<?php echo get_permalink() . '&page=' . ($page + 1); ?>">Next</a>
		  	</li>
		</ul>
<?php } ?>
</div>