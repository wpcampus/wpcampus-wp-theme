(function( $ ) {
	'use strict';

	// Load Google-ness
	google.load("visualization", "1", {packages:["corechart"]});

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

})( jQuery );