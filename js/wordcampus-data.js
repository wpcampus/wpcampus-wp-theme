(function( $ ) {
	'use strict';
	
	// Make a reusable method to determine whether this is a narrow display or not
	var WPCampusMobileWidth = 600;
	function wpcampus_is_mobile() {
		return jQuery( window ).innerWidth() <= WPCampusMobileWidth;
	}

	// Load Google-ness
	google.load("visualization", "1", {packages:['corechart','geochart','bar']});

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
			
			if ( wpcampus_is_mobile() ) {
				$options.legend = { 'position' : 'bottom' };
			}

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
			
			if ( wpcampus_is_mobile() ) {
				$options.legend = { 'position' : 'bottom' };
			}

			// Draw the chart
			var $chart = new google.visualization.PieChart(document.getElementById('wpcampus-chart-attend-pref'));
			$chart.draw( $data, $options );

		});

	}

	// Load sessions chart
	google.setOnLoadCallback(wpcampus_draw_sessions_chart);
	function wpcampus_draw_sessions_chart() {

		// Get the sessions data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/sessions', function( $wpcampus_data ) {

			// Create time array
			var $total = 0;
			var $time_data = [ ['Sessions', 'Votes'] ];
			$.each( $wpcampus_data, function( $index, $value ) {
				if ( 'Total' == $index ) {
					$total = parseInt($value);
					return;
				}
				$time_data.push( [ $index, parseInt($value) ] );
			});

			// Set data
			var $data = new google.visualization.arrayToDataTable($time_data);

			// Set options
			var $options = {
				legend: { position: 'none' },
				bars: 'horizontal', // Required for Material Bar Charts.
				axes: {
					x: {
						0: { // Top x-axis
							side: 'top',
							label: 'Number of Votes (Out of ' + $total + ')'
						}
					}
				}
			};
			
			// Draw the chart
			var $chart = new google.charts.Bar(document.getElementById('wpcampus-chart-sessions'));
			$chart.draw($data, $options);

		});

	}

	// Load best time of year chart
	google.setOnLoadCallback(wpcampus_draw_best_time_of_year_chart);
	function wpcampus_draw_best_time_of_year_chart() {

		// Get the best time of year data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/best-time-of-year', function( $wpcampus_data ) {

			// Create time array
			var $total = 0;
			var $time_data = [ ['Best Time of Year', 'Percentage'] ];
			$.each( $wpcampus_data, function( $index, $value ) {
				if ( 'Total' == $index ) {
					$total = parseInt($value);
					return;
				}
				$time_data.push( [ $index, parseInt($value) ] ); //Math.round( ( parseInt($value) / $total ) * 100 ) ] );
			});

			// Set data
			var $data = new google.visualization.arrayToDataTable($time_data);

			// Set options
			var $options = {
				legend: { position: 'none' },
				bars: 'horizontal', // Required for Material Bar Charts.
				axes: {
					x: {
						0: { // Top x-axis
							side: 'top',
							label: 'Number of Votes (Out of ' + $total + ')'
						}
					}
				}
			};

			// Draw the chart
			var $chart = new google.charts.Bar(document.getElementById('wpcampus-chart-best-time-of-year'));
			$chart.draw($data, $options);

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
				$countries.push( [ $value.country, parseInt( $value.count ) ] );
			});

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
	
	jQuery( window ).on( 'resize', function() {
		wpcampus_draw_regions_map();
		wpcampus_draw_best_time_of_year_chart();
		wpcampus_draw_sessions_chart();
		wpcampus_draw_attend_pref_chart();
		wpcampus_draw_affiliation_chart();
	} );
})( jQuery );