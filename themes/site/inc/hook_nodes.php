<?php 

/**
 * @TODO Hook node before save 'consultation' -> generate GPS from address & stock
 */

/*
				function getCoordinates($address){
					$address = urlencode($address);
					$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
					$response = file_get_contents($url);
					$json = json_decode($response,true);

					$lat = $json['results'][0]['geometry']['location']['lat'];
					$lng = $json['results'][0]['geometry']['location']['lng'];

					return array($lat, $lng);
				}


				$coords = getCoordinates("Wall Street, New York");
				print_r($coords);


				/*
				Prints:

				Array
				(
					[0] => 41.3936254
					[1] => 2.1634189
				)
				*/