jQuery.noConflict();
jQuery(window).load(function() {
	initialize_contact_map();
});

function initialize_contact_map() {
	var secheltLoc = new google.maps.LatLng(window.window.business_address_latitude, window.business_address_longitude);
	var myMapOptions = {
		 zoom: 15
		,center: secheltLoc
		,mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var theMap = new google.maps.Map(document.getElementById("map_canvas"), myMapOptions);
	var marker = new google.maps.Marker({
		map: theMap,
		draggable: true,
		position: new google.maps.LatLng(window.window.business_address_latitude, window.business_address_longitude),
		visible: true
	});
	var boxText = document.createElement("div");
	boxText.innerHTML = window.company_address;
	var myOptions = {
		 content: boxText
		,disableAutoPan: false
		,maxWidth: 0
		,pixelOffset: new google.maps.Size(-140, 0)
		,zIndex: null
		,closeBoxURL: ""
		,infoBoxClearance: new google.maps.Size(1, 1)
		,isHidden: false
		,pane: "floatPane"
		,enableEventPropagation: false
	};
	google.maps.event.addListener(marker, "click", function (e) {
		ib.open(theMap, this);
	});
	var ib = new InfoBox(myOptions);
	ib.open(theMap, marker);
}
