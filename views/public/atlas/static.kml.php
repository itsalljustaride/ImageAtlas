<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
    <name>Omeka Default Items KML</name>
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
		<?php foreach($default_locations as $defloc) : ?>
		
		<Placemark>
		  <name><?php echo $defloc['title'] ; ?></name>
		  <styleUrl>#static_cities_style</styleUrl>
		  <Point>
		    <coordinates><?php echo $defloc['longitude'] ; ?>,<?php echo $defloc['latitude'] ; ?>,<?php echo $defloc['altitude'] ; ?></coordinates>
		  </Point>
		</Placemark>
		<?php endforeach; ?>
		</Folder>
	</Document>
</kml>