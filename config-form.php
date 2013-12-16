<?php $view = get_view(); ?>
<div id="image-atlas-settings">
<h2><?php echo __('Image Atlas Settings'); ?></h2>
	<div class="field">
        <div class="two columns alpha">
            <label>Geolocation Plugin Installed?</label>
        </div>
        <div class="inputs five columns omega">
			<?php
				if (class_exists('GeolocationPlugin')){
					echo "Geolocation Plugin is installed. We're good to go.";
				} else {
					echo "Geolocation Plugin is NOT installed. <a href=\"http://omeka.org/add-ons/plugins/geolocation/\">Please install it</a>.";
				}
			?>
		</div>
	</div>
	
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('image_atlas_settings_gmaps_api_key', __('Google Maps API v3 Key')); ?>
        </div>
        <div class="inputs five columns omega">
            <?php echo $view->formText('image_atlas_settings_gmaps_api_key', get_option('image_atlas_settings_gmaps_api_key')); ?>			
	        <p class="explanation"><?php echo __(
	            'Your Google Maps API v3 Key'
	        ); ?></p>
        </div>
    </div>
    
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('image_atlas_settings_display_nav_item', __('Display Atlas Link in Main Nav Bar')); ?>
        </div>
        <div class="inputs five columns omega">
		        <?php echo get_view()->formCheckbox('image_atlas_settings_display_nav_item', true, 
		         array('checked'=>(boolean)get_option('image_atlas_settings_display_nav_item'))); ?>
		        <p class="explanation"><?php echo __(
		            'Check to display a link to the atlas in the main navigation bar.'
		        ); ?></p>
        </div>
    </div>
	
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('image_atlas_settings_slug', __('Slug')); ?>
        </div>
        <div class="inputs five columns omega">
            <?php echo $view->formText('image_atlas_settings_slug', get_option('image_atlas_settings_slug')); ?>			
	        <p class="explanation"><?php echo __(
	            'Slug for URL to Image Atlas page (default is \'image-atlas\').' .
				'Must be lower-case, no spaces or special characters.'
	        ); ?></p>
        </div>
    </div>
	
	<div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('image_atlas_settings_default_points', __('Default points')); ?>
        </div>
	    <div class="inputs five columns omega">
            <?php echo $view->formTextarea('image_atlas_settings_default_points', get_option('image_atlas_settings_default_points'), array('rows' => 10, 'cols' => 50)); ?>

		    <p class="explanation">
		    <?php
		        echo __('A set of default points to always display in comma separated text form (title,long,lat,elev).'); ?>
		    </p>
	    </div>
	</div>
</div>