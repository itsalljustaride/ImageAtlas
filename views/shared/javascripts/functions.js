  google.load("earth", "1");

	var ge = null;
	var themeStr	= [];		//Array of premade filter strings for themes.
	var timePeriodStr	= [];		//Array of premade filter strings for time periods.
	var networkLink	= null; 	// The holder for the network link.
	var All_src = "https://lrc-tesuto.lrc.lsa.umich.edu/omeka/hjcs277/image-atlas/network-links?";
	var SM_src = "https://lrc-tesuto.lrc.lsa.umich.edu/omeka/hjcs277/image-atlas/kml?";
	var KML_URL = SM_src;
	var balloonFlag = true;
	var searchHeader = "<h3>Current Search Set</h3>";
	var searchType = getQueryParams(document.location.search).atlasSearchType;
	var placemarkId = getQueryParams(document.location.search).item
	
	function getQueryParams(qs) {
	    qs = qs.split("+").join(" ");
	    var params = {}, tokens,
	        re = /[?&]?([^=]+)=([^&]*)/g;

	    while (tokens = re.exec(qs)) {
	        params[decodeURIComponent(tokens[1])]
	            = decodeURIComponent(tokens[2]);
	    }

	    return params;
	}
		
    //-------------------------------------------------------------------------------------------
	//Here we parse the strings above to create the correct search filter for the ge_kml2 sitemaker section
	//We also update the filterTitle below the GE plugin to display what the user is searching for.
	
	function setKML(type,modURL, modPage) {
		if(type == "theme"){
			var SM_filter = "&collection=";
			KML_URL = SM_src + SM_filter + modURL;
			loadKML(KML_URL);
			document.getElementById('atlas-filter-info').innerHTML = searchHeader + "<p>Theme: " + modPage + "</p>";
		}
		else if(type == "time"){
			var SM_filter = "&search=&advanced%5B0%5D%5Belement_id%5D=58&advanced%5B0%5D%5Btype%5D=contains&advanced%5B0%5D%5Bterms%5D=";
			KML_URL = SM_src + SM_filter + modURL;
			loadKML(KML_URL);
			document.getElementById('atlas-filter-info').innerHTML = searchHeader + "<p>Time period: " + modPage + "</p>";
		}
		else if(type == "tag"){
			var SM_filter = "&search=&advanced%5B0%5D%5Belement_id%5D=&advanced%5B0%5D%5Btype%5D=&advanced%5B0%5D%5Bterms%5D=&range=&collection=&type=&tags=";
			KML_URL = SM_src + SM_filter + modURL;
			loadKML(KML_URL);
			document.getElementById('atlas-filter-info').innerHTML = searchHeader + "<p>Tag: " + modPage + "</p>";
		}
		else if(type == "single"){
			var SM_filter = "&collection=";
			modURL = getQueryParams(document.location.search).collection;
			KML_URL = SM_src + SM_filter + modURL;
			loadKML(KML_URL);
			document.getElementById('atlas-filter-info').innerHTML = "<p>Viewing single placemark</p>";
		}
		else {
			loadKML(All_src);
			KML_URL = All_src;
			document.getElementById('atlas-filter-info').innerHTML = "<p>Viewing all placemarks</p>";
		}
	}
    //-------------------------------------------------------------------------------------------
	//If the user uses the search bar, then we create the appropriate search string to retrive the appropriate records from ge_kml2
function search(STR){
	var searchStr = SM_src + "&searchAll=" + STR;
	KML_URL = searchStr;
	loadKML(searchStr);
	document.getElementById('atlas-filter-info').innerHTML = "<p>Searching for all placemarks containing: " + STR + "</p>";
}
    //-------------------------------------------------------------------------------------------
    function init() {
      google.earth.createInstance("map3d", initCB, failureCB);
    }

    //-------------------------------------------------------------------------------------------
    function initCB(instance) {
      ge = instance;
      ge.getWindow().setVisibility(true);
      ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);

			// If we want only a the single record
			singleRecord = getQueryParams(document.location.search).singleRecord;

			if (singleRecord) {
				setKML('single',getQueryParams(document.location.search).item,"");
			} else {
				loadKML(All_src);
			}

	
	//-------------------------------------------------------------------------------------------

}
	function loadKML(href) {
      
	  // First drop any existing KML layer...
      if (networkLink != null) {
		  ge.getFeatures().removeChild(networkLink);
		}

      // Now add the new KML layer...networkLink
      var link = ge.createLink(''); 
      link.setHref(href+"&groupSize=1000"); 
      networkLink = ge.createNetworkLink(''); 
      networkLink.set(link, false, true); // Sets the link, refreshVisibility, and flyToView 
      ge.getFeatures().appendChild(networkLink);
		
		// Set the FlyTo speed.
		ge.getOptions().setFlyToSpeed(2);

		// Get the current view.
		var lookAt = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);

		// Update the view in Google Earth.
		ge.getView().setAbstractView(lookAt);  
      
		google.earth.addEventListener(networkLink, 'click', function(event) {
		  event.preventDefault(); 
		  var placemark = event.getTarget();
		  var content = placemark.getBalloonHtmlUnsafe();
		  document.getElementById('atlas-item-info').innerHTML = content;
			$('.tooltip').tooltipster({
				animation: 'fade',
				delay: 200,
				interactive: true,
				theme: '.tooltipster-default',
				touchDevices: true,
				trigger: 'hover'
			});
			$('#atlas-item-info div.hTagcloud ul li').each(function() {
				$(this).contents().wrap('<a href="javascript:void(0)"></a>');
				$(this).children(":first").click(function(){ 
					setKML('tag', $(this).text());
				});
			});
		});
		
		if (getQueryParams(document.location.search).singleRecord && balloonFlag) {
			setTimeout(function (){
				kmlNodeId = "item_"+placemarkId;
				var placemarks = ge.getElementsByType('KmlPlacemark');
				for (var i = 0; i < placemarks.getLength(); ++i) {
					var placemark = placemarks.item(i);
					if (placemark.getId() == kmlNodeId) {
						var content = placemark.getBalloonHtmlUnsafe();
						document.getElementById('atlas-item-info').innerHTML = content;
						balloonFlag = false;
						
						ge.getOptions().setFlyToSpeed(1);
						var lookAt = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);
						lookAt.setLatitude(placemark.getGeometry().getLatitude());
						lookAt.setLongitude(placemark.getGeometry().getLongitude());
						lookAt.setRange(10000);
						ge.getView().setAbstractView(lookAt);
						
						$('.tooltip').tooltipster({
							animation: 'fade',
							delay: 200,
							interactive: true,
							theme: '.tooltipster-default',
							touchDevices: true,
							trigger: 'hover'
						});
					}
				}
			}, 6000);
		} else if (!balloonFlag) {
			document.getElementById('atlas-item-info').innerHTML = "<p>Click on a placemark to view details.</p>";
		}
			
}

//-------------------------------------------------------------------------------------------
    function failureCB(errorCode) {}

//-------------------------------------------------------------------------------------------
  
    google.setOnLoadCallback(init);
			
