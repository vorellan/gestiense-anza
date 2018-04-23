<style type="text/css">
	#socialize-share-modal {
		display: none;
		background: #FFF;
		-moz-border-radius: 5px;
		-moz-border-shadow: 0 1px 0 #AAAAAA;
		padding: 10px;
		position:fixed;
		top: 0;
		margin: 0 auto;
		width: 300px;

		border-color: #DDDDDD;
		border-style: solid;
		border-width: 5px 4px 4px;
		
		font-size: 13px;
	}
	
	#socialize-share-modal img.share-image {
			width: 80px;
			float: left;
			margin-right: 10px;
	}
	
	#socialize-share-modal div.share-title a {
		font-weight: bold;
		color: #336699;
		text-decoration: none;
	}
	
	#socialize-share-modal div.share-networks {
		clear: both;
		margin-top: 10px;
		border-top: 1px dotted #CCC;
		padding-top: 10px;
	}
	
	.socialize-clear {
		clear: both;
	}
	
	.share-cancel
	{
		clear: both;
		margin-top: 10px;
		border-top: 1px dotted #CCC;
		padding-top: 10px;
		color: #FF3333;
	}
	
	.share-cancel:focus {
		outline: 0;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	
	function socializeInitialize(selector)
	{
		socializeBindShareLinks();
	}
	
	function socializeBindShareLinks()
	{
		$('a.share').live('click', function(){
			selector = $(this).attr('rel');
			
			share = {
				title: $(selector+' .share-title').html(),
				body: $(selector+' .share-body').html(),
				img: $(selector+' .share-image').attr('src'),
				url: $(selector+' .share-url').attr('href')
			};
			
			$('#socialize-share-modal .share-url').html(share.title);
			$('#socialize-share-modal .share-url').attr('href', share.url);
			
			$('#socialize-share-modal .share-image').attr('src', share.img);
			$('#socialize-share-modal .share-image').attr('alt', share.title);
			
			var winH = $(window).height();  
			var winW = $(window).width();  

			//Set the popup window to center  
			$('#socialize-share-modal').css('top',  winH/2-$('#socialize-share-modal').height()/2);  
			$('#socialize-share-modal').css('left', winW/2-$('#socialize-share-modal').width()/2);
			
			<?php foreach ( $this->socializenetworks->networks() as $network):?>
				<?php socialize_view('share_button_show_js', $network);?>
			<?php endforeach;?>
			
			$('#socialize-share-modal').show('fast');
			
			return false;
		});

		$('a.share-cancel').live('click', function(){
			$('#socialize-share-modal').hide('fast');
			return false;
		});
	}
	
	socializeInitialize();
});
</script>

<div id="socialize-share-modal" style="display:none">
	<div class="share-container">
		<img class="share-image" src="" alt="" />
		<div class="share-title"><a href="#" class="share-url"></a></div>
		<div class="socialize-clear"></div>
	</div>
	<div class="share-networks">
		<?php foreach ( $this->socializenetworks->networks() as $network):?>
			<?php socialize_view('share_button', $network);?>
		<?php endforeach;?>
	</div>
	<a class="share-cancel" href="#">Cancel</a>
</div>