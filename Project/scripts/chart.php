<script type="text/javascript">	
	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);

	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawChart()
	{
		var options;
		// Create the data table.
		
		<?php 
			foreach($questions as $question)
			{?>
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Choice');
				data.addColumn('number', 'numAnswers');
				<?php
				$choices = getChoices($question['id']);
				foreach($choices as $choice)
				{
					?>	
					data.addRows([['<?php echo $choice['title'] ?>',<?php echo $choice['timesAnswered'] ?>]]);
					<?php
				}
				?>
				// Set chart options
				options = {'title':'<?php echo $question['title'] ?>', 'width':300, 'height':200};
				var chart = new google.visualization.PieChart(document.getElementById('chart<?php echo $question['id'];?>'));
				chart.draw(data, options);
				<?php
			}
		?>
	}
</script>