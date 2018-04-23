<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="share-twitter">
	
</div>
<script type="text/javascript">
	
	function socialize_show_share_twitter() {
		$('.share-twitter').html('');
		$('.share-twitter').append('<iframe class="tweet-button" allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?via=elliothaughin&text='+$('#socialize-share-modal .share-url').html()+'&url='+$('#socialize-share-modal .share-url').attr('href')+'" style="float: left; width:100px; height:20px;"></iframe>');
	};
	
</script>