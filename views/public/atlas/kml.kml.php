<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
    <name>Omeka Items KML (<?php echo $totalItems ?> Items)</name>
		<Style id="sn_style">
			<IconStyle>
				<Icon>
					<href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle.png</href>
				</Icon>
			</IconStyle>
			<LabelStyle>
			    <scale>1</scale>
			</LabelStyle>
		</Style>
		<Style id="sh_style">
			<IconStyle>
				<Icon>
					<href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle_highlight.png</href>
				</Icon>
			</IconStyle>
			<LabelStyle>
			    <scale>1</scale>
			</LabelStyle>
		</Style>
		<StyleMap id="sm_style">
			<Pair>
			    <key>normal</key>
			    <styleUrl>#sn_style</styleUrl>
			</Pair>
			<Pair>
			    <key>highlight</key>
			    <styleUrl>#sh_style</styleUrl>
			</Pair>
		</StyleMap>
		<Style id="static_sites_reg_style">
			<IconStyle>
				<scale>0</scale>
				<Icon>
					<href>http://maps.google.com/mapfiles/kml/paddle/ylw-stars-lv.png</href>
				</Icon>
			</IconStyle>
			<LabelStyle>
				<color>88FFFFFF</color>
			  <scale>1.25</scale>
			</LabelStyle>
		</Style> 
		<Style id="static_sites_hilt_style">
			<IconStyle>
				<scale>0</scale>
				<Icon>
					<href>http://maps.google.com/mapfiles/kml/paddle/ylw-stars-lv.png</href>
				</Icon>
			</IconStyle>
			<LabelStyle>
				<color>88FFFFFF</color>
	    	<scale>1.25</scale>
			</LabelStyle> 
		</Style> 
		<StyleMap id="static_sites_style"> 
			<Pair> 
			    <key>normal</key> 
			    <styleUrl>#static_sites_reg_style</styleUrl> 
			</Pair> 
			<Pair> 
			    <key>highlight</key> 
			    <styleUrl>#static_sites_hilt_style</styleUrl> 
			</Pair> 
		</StyleMap>
		<Style id="static_cities_reg_style">
			<IconStyle>
				<scale>0.5</scale>
				<Icon>
					<href>http://maps.google.com/mapfiles/kml/paddle/ylw-stars-lv.png</href>
				</Icon>
			</IconStyle>
			<LabelStyle> 
			    <scale>1.1</scale>
			</LabelStyle>
		</Style> 
		<Style id="static_cities_hilt_style">
			<IconStyle>
				<scale>1.25</scale>
				<Icon>
					<href>http://maps.google.com/mapfiles/kml/paddle/ylw-stars-lv.png</href>
				</Icon>
			</IconStyle>
			<LabelStyle> 
	    	<scale>1.25</scale>
			</LabelStyle> 
		</Style> 
		<StyleMap id="static_cities_style"> 
			<Pair> 
			    <key>normal</key> 
			    <styleUrl>#static_cities_reg_style</styleUrl> 
			</Pair> 
			<Pair> 
			    <key>highlight</key> 
			    <styleUrl>#static_cities_hilt_style</styleUrl> 
			</Pair> 
		</StyleMap>
		<Folder>
		<name>HJCS Placemarks</name>
      <NetworkLink>
        <name>Static Sites</name>
        <visibility>1</visibility>
        <open>1</open>
        <description>Static Sites</description>
        <refreshVisibility>1</refreshVisibility>
        <flyToView>0</flyToView>
        <Link>
          <href>https://lrc-tesuto.lrc.lsa.umich.edu/omeka/hjcs277/image-atlas/static</href>
        </Link>
      </NetworkLink>
    <?php
	    foreach(loop('item') as $item):        
	    $location = $locations[$item->id];
    ?>
		
		<Placemark id="item_<?php echo $item->id ?>">
			<name><?php echo metadata('item',array('Item Type Metadata', 'Google Earth Title')) ; ?></name>
			<namewithlink><![CDATA[<?php echo link_to_item(metadata('item' , array('Item Type Metadata', 'Google Earth Title')), array('class' => 'view-item')); ?>]]></namewithlink>
			<styleUrl>#sm_style</styleUrl>
			<description><![CDATA[<?php echo link_to_item(item_image('thumbnail',array('alt'=>'thumbnail','title'=>metadata($item,array('Item Type Metadata', 'Google Earth Title'))))); ?><br/><p><?php echo metadata($item,array('Dublin Core', 'Description')) ; ?></p><h3>Tags</h3><?php echo tag_cloud($item); ?>]]>
			</description>
      <Point>
          <coordinates><?php echo $location['longitude']; ?>,<?php echo $location['latitude']; ?></coordinates>
      </Point>
  		<Snippet maxLines="2"><![CDATA[<?php
      echo metadata('item', array('Dublin Core', 'Description'), array('snippet' => 150));
      ?>]]></Snippet>
		</Placemark>
		<?php endforeach; ?>
		</Folder>
	</Document>
</kml>