<script type="text/javascript">
	$(document).ready(function(){
		google.friendconnect.container.setParentUrl("/");
		google.friendconnect.container.initOpenSocialApi({site: <?=$this->config->item('google_site_id')?>, onload: function(securityToken) {
			if ( !window.timesloaded ) { 
				window.timesloaded = 1; 
			} else {
				window.timesloaded++; 
			} 
			
			if (window.timesloaded > 1) { 
				window.location.reload(); 
			}
		}});
	});
</script>