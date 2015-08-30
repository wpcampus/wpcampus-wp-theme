(function( $ ) {
	'use strict';

	// Load Google-ness
	google.load("visualization", "1", {packages:['corechart','geochart']});

	// Load affiliation chart
	google.setOnLoadCallback(wpcampus_draw_affiliation_chart);
	function wpcampus_draw_affiliation_chart() {

		// Get the affiliation data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/affiliation', function( $wpcampus_data ) {

			// Set the data
			var $data = google.visualization.arrayToDataTable([
				[ 'Task', 'Affiliation' ],
				[ 'I work at a higher ed institution', parseInt( $wpcampus_data.work_in_higher_ed) ],
				[ 'I freelance or work for a company that supports higher ed', parseInt( $wpcampus_data.work_for_company ) ],
				[ 'I work outside higher ed but am interested', parseInt( $wpcampus_data.work_outside_higher_ed ) ],
			]);

			// Set the options
			var $options = {
				title: 'Affiliation',
				pieHole: 0.4,
			};

			// Draw the chart
			var $chart = new google.visualization.PieChart(document.getElementById('wpcampus-chart-affiliation'));
			$chart.draw( $data, $options );

		});

	}

	// Load attend preference chart
	google.setOnLoadCallback(wpcampus_draw_attend_pref_chart);
	function wpcampus_draw_attend_pref_chart() {

		// Get the attend preference data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/attend-preference', function( $wpcampus_data ) {

			// Set the data
			var $data = google.visualization.arrayToDataTable([
				[ 'Task', 'Attendance Preference' ],
				[ 'Attend in person', parseInt( $wpcampus_data.attend_in_person) ],
				[ 'Attend via live stream', parseInt( $wpcampus_data.attend_live_stream ) ],
			]);

			// Set the options
			var $options = {
				title: 'Attendance Preference',
				pieHole: 0.4,
			};

			// Draw the chart
			var $chart = new google.visualization.PieChart(document.getElementById('wpcampus-chart-attend-pref'));
			$chart.draw( $data, $options );

		});

	}

	// Load regions map
	google.setOnLoadCallback(wpcampus_draw_regions_map);
	function wpcampus_draw_regions_map() {

		// Get the attend preference data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/attend-country', function( $wpcampus_data ) {

			// Create array
			var $countries = [ ['Country', 'Interest'] ];
			$.each( $wpcampus_data, function( $index, $value ) {
				console.log($value);
				$countries.push( [ $value.country, parseInt( $value.count ) ] );
			});

			console.log($countries);

			// Set data
			var $data = google.visualization.arrayToDataTable($countries);

			// Set options
			var $options = {
				colorAxis: {minValue: 0,  colors: ['#ff9900', '#3366cc']}
			};

			// Draw the chart
			var $chart = new google.visualization.GeoChart(document.getElementById('wpcampus-map-regions'));
			$chart.draw($data, $options);

		});

	}

})( jQuery );