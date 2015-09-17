(function( $ ) {
	'use strict';
	
	// Make a reusable method to determine whether this is a narrow display or not
	var WPCampusMobileWidth = 600;
	function wpcampus_is_mobile() {
		return jQuery( window ).innerWidth() <= WPCampusMobileWidth;
	}

	// Load Google-ness
	google.load("visualization", "1", {packages:['corechart','geochart','bar']});

	// Load "Vote On New Name" chart
	google.setOnLoadCallback(wpcampus_draw_vote_on_name_chart);
	function wpcampus_draw_vote_on_name_chart() {

		// Get the affiliation data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/vote-on-new-name', function( $wpcampus_data ) {

			// Create array for data table
			var $data_table = [];

			// Keep up with total
			var $total = 0;

			// Sort data
			$.each( $wpcampus_data, function( $index, $value ) {

				// Convert the count to an integer
				var $count = parseInt($value.count);
				$total += $count;

				// Push to sets
				$data_table.push( [ $value.text + ' (' + $count + ')', $count ] );

			});

			// Add title to data
			$data_table.unshift( [ 'Task', 'Vote On Our New Name (' + $total + ' votes)' ] );

			// Set the data
			var $data = google.visualization.arrayToDataTable( $data_table );

			// Set the options
			var $options = {
				title: 'Vote On Our New Name (' + $total + ' votes)',
				pieHole: 0.4,
			};

			if ( wpcampus_is_mobile() ) {
				$options.legend = { 'position' : 'bottom' };
			}

			// Draw the chart
			var $chart = new google.visualization.PieChart(document.getElementById('wpcampus-chart-vote-on-new-name'));
			$chart.draw( $data, $options );

		});

	}

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
	
	$(document).on( 'ready', function() {
		// Get the sessions data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/sessions', function( $wpcampus_data ) {
	
			// Get labels, data, and highest value
			var $high = 0;
			var $labels = [];
			var $data = [];
	
			// Sort data
			$.each( $wpcampus_data, function( $index, $value ) {
	
				// Not using
				if ( 'Total' == $index ) {
					return;
				}
	
				// Convert the value to an integer
				$value = parseInt($value);
	
				// Push to sets
				$labels.push( $index );
				$data.push( $value );
	
				// Find highest value
				if ( $value > $high ) {
					$high = $value;
				}
	
			});
	
			// Load best time of year chart
			new Chartist.Bar('#wpcampus-chart-sessions', {
				labels: $labels,
				series: [ $data ]
			}, {
				seriesBarDistance: 25,
				reverseData: true,
				horizontalBars: true,
				low: 0,
				high: $high,
				axisY: {
					offset: 70
				}
			});
	
		});
	});
	
	$(document).on( 'ready', function() {
		// Get the best time of year data
		$.get( 'http://wpcampus.org/wp-json/wordcampus/data/set/best-time-of-year', function( $wpcampus_data ) {
	
			// Get labels, data, and highest value
			var $high = 0;
			var $labels = [];
			var $data = [];
	
			// Sort data
			$.each( $wpcampus_data, function( $index, $value ) {
	
				// Not using
				if ( 'Total' == $index ) {
					return;
				}
	
				// Convert the value to an integer
				$value = parseInt($value);
	
				// Push to sets
				$labels.push( $index );
				$data.push( $value );
	
				// Find highest value
				if ( $value > $high ) {
					$high = $value;
				}
	
			});
	
			// Load best time of year chart
			new Chartist.Bar('#wpcampus-chart-best-time-of-year', {
				labels: $labels,
				series: [ $data ]
			}, {
				seriesBarDistance: 25,
				reverseData: true,
				horizontalBars: true,
				low: 0,
				high: $high,
				axisY: {
					offset: 70
				}
			});
	
		});
	});

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
		wpcampus_draw_attend_pref_chart();
		wpcampus_draw_affiliation_chart();
	} );
})( jQuery );