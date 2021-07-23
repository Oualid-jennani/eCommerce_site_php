/* JS Document */

/******************************

[Table of Contents]

1. Vars and Inits
2. Set Header
3. Init Custom Dropdown
4. Init Page Menu
5. Init Google Map


******************************/

$(document).ready(function()
{
	"use strict";

	/* 

	1. Vars and Inits

	*/

	var menuActive = false;
	var header = $('.header');
	var map;

	setHeader();

	initPageMenu();
	initGoogleMap();

	$(window).on('resize', function()
	{
		setHeader();
	});

	/* 

	2. Set Header

	*/

	function setHeader()
	{
		//To pin main nav to the top of the page when it's reached
		//uncomment the following

		// var controller = new ScrollMagic.Controller(
		// {
		// 	globalSceneOptions:
		// 	{
		// 		triggerHook: 'onLeave'
		// 	}
		// });

		// var pin = new ScrollMagic.Scene(
		// {
		// 	triggerElement: '.main_nav'
		// })
		// .setPin('.main_nav').addTo(controller);

		if(window.innerWidth > 991 && menuActive)
		{
			closeMenu();
		}
	}

	/* 

	4. Init Page Menu

	*/

	function initPageMenu()
	{
		if($('.page_menu').length && $('.page_menu_content').length)
		{
			var menu = $('.page_menu');
			var menuContent = $('.page_menu_content');
			var menuTrigger = $('.menu_trigger');

			//Open / close page menu
			menuTrigger.on('click', function()
			{
				if(!menuActive)
				{
					openMenu();
				}
				else
				{
					closeMenu();
				}
			});

			//Handle page menu
			if($('.page_menu_item').length)
			{
				var items = $('.page_menu_item');
				items.each(function()
				{
					var item = $(this);
					if(item.hasClass("has-children"))
					{
						var toogleItem = item.find('> a');
						toogleItem.on('click', function(evt)
						{
							evt.preventDefault();
							evt.stopPropagation();
							var subItem = item.find('> ul');
						    if(subItem.hasClass('active'))
						    {
						    	subItem.toggleClass('active');
								TweenMax.to(subItem, 0.3, {height:0});
						    }
						    else
						    {
						    	subItem.toggleClass('active');
						    	TweenMax.set(subItem, {height:"auto"});
								TweenMax.from(subItem, 0.3, {height:0});
						    }
						});
					}
					
				});
			}
		}
	}

	function openMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.set(menuContent, {height:"auto"});
		TweenMax.from(menuContent, 0.3, {height:0});
		menuActive = true;
	}

	function closeMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.to(menuContent, 0.3, {height:0});
		menuActive = false;
	}

	function initGoogleMap()
	{
		var myLatlng = new google.maps.LatLng(34.679571, -1.906674);
    	var mapOptions = 
    	{
    		center: myLatlng,
	       	zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			draggable: true,
			scrollwheel: false,
			zoomControl: true,
			zoomControlOptions:
			{
				position: google.maps.ControlPosition.RIGHT_CENTER
			},
			mapTypeControl: false,
			scaleControl: false,
			streetViewControl: false,
			rotateControl: false,
			fullscreenControl: true,
			styles:
			[
				{
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#f5f5f5"
				  }
				]
				},
				{
				"elementType": "labels.icon",
				"stylers": [
				  {
				    "visibility": "off"
				  }
				]
				},
				{
				"elementType": "labels.text",
				"stylers": [
				  {
				    "color": "#858585"
				  }
				]
				},
				{
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#858585"
				  }
				]
				},
				{
				"elementType": "labels.text.stroke",
				"stylers": [
				  {
				    "color": "#f5f5f5"
				  }
				]
				},
				{
				"featureType": "administrative.land_parcel",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#bdbdbd"
				  }
				]
				},
				{
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#eeeeee"
				  }
				]
				},
				{
				"featureType": "poi",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#757575"
				  }
				]
				},
				{
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#e5e5e5"
				  }
				]
				},
				{
				"featureType": "poi.park",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#9e9e9e"
				  }
				]
				},
				{
				"featureType": "road",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#ffffff"
				  }
				]
				},
				{
				"featureType": "road.arterial",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#757575"
				  }
				]
				},
				{
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#dadada"
				  }
				]
				},
				{
				"featureType": "road.highway",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#616161"
				  }
				]
				},
				{
				"featureType": "road.local",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#9e9e9e"
				  }
				]
				},
				{
				"featureType": "transit.line",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#e5e5e5"
				  }
				]
				},
				{
				"featureType": "transit.station",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#eeeeee"
				  }
				]
				},
				{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [
				  {
				    "color": "#c9c9c9"
				  }
				]
				},
				{
				"featureType": "water",
				"elementType": "geometry.fill",
				"stylers": [
				  {
				    "color": "#ededed"
				  }
				]
				},
				{
				"featureType": "water",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
				    "color": "#9e9e9e"
				  }
				]
				}
				]
    	}

    	// Initialize a map with options
    	map = new google.maps.Map(document.getElementById('map'), mapOptions);

    	// Use an image for a marker
		var image = 'images/marker.png';
		var marker = new google.maps.Marker(
		{
			position: myLatlng,
			map: map,
			icon: image
		});
   
		// Re-center map after window resize
		google.maps.event.addDomListener(window, 'resize', function()
		{
			setTimeout(function()
			{
				google.maps.event.trigger(map, "resize");
				map.setCenter(myLatlng);
			}, 1400);
		});
	}
});