<html>
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="animate.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800|Lato:100' rel='stylesheet' type='text/css'>
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/js.js"></script>
	<script src="js/jscolor-2.0.4/jscolor.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no">
	<title>Radiant Blades</title>
</head>

<div id="exercise_display" class="center-text intitially-hidden">
	<div id="circuit_name" class="session-text small-shadow"></div>
	<div id="session_name" class="session-text small-shadow"></div>
	<div id="timer" class="timer-text small-shadow"></div>
</div>

<body>
	<form id="exercise_form">
		<h1 class="center-text">Radiant Blades</h1>
		<!-- <p>(Under Construction)</p> -->
		<!-- This table contains all of the inputs -->
		<table id="form_table" class="full-width">
			<tr>
				<img id="logo_img" src="guild_logo.png" alt="Radiant Blades">
			</tr>
			<tr>
				<td><label for="name_text_input">Names</label></td>
				<td><input type="text" name="name" placeholder="Name" value="" class="animated animated.infinite" id="name_text_input" min="1"></td>
			</tr>
			<tr>
				<td><label for="text_color">Text Color</label></td>
				<td><input id="text_color" class="jscolor" value="ABABAB"></td>
			</tr>
			<tr>
				<td><label for="stroke_color">Stroke Color</label></td>
				<td><input id="stroke_color" class="jscolor" value="000000"></td>
			</tr>
			<tr>
				<td>
					<label for="stroke_size">Stroke Size</label>
					<p><input type="text" id="stroke_amount" value="5" style="display: none; border: 0; color: #f6931f; font-weight: bold;" /></p>
				</td>
				<td><div id="stroke_slider-range-min" style="width: 150px"></div></td>
			</tr>
			<tr>
				<td>
					<label for="x_axis_size">X-Axis</label>
					<p><input type="text" id="x_axis_amount" value="60" style="display: none; border: 0; color: #f6931f; font-weight: bold;" /></p>
				</td>
				<td><div id="x_axis_slider-range-min" style="width: 150px"></div></td>
			</tr>
			<tr>
				<td>
					<label for="font_size">Font Size</label>
					<p><input type="text" id="font_amount" value="100" style="display: none; border: 0; color: #f6931f; font-weight: bold;" /></p>
				</td>
				<td><div id="font_slider-range-min" style="width: 150px"></div></td>
			</tr>
		</table>
	</form>
	<button  id="default_button"  class="stop-button full-width">Default</button>
	
	<br>
	<br>
	Tap picture and hold to download.
</body>
</html>

<script type="text/javascript">

	var input_delay_generate_time = 500;
	$('#name_text_input').keyup(function() {
		delay(function(){
			update(false, false, false, false, false);
		}, input_delay_generate_time );
	});

	$('#text_color').change(function() {
		delay(function(){
			update($('#text_color').val(), false, false, false, false);
		}, input_delay_generate_time );
	});

	$('#stroke_color').change(function() {
		delay(function(){
			update(false, $('#stroke_color').val(), false, false, false);
		}, input_delay_generate_time );
	});

	jQuery('#default_button').click( "keyup", function() {
		set_values_default();
	});

	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	function set_values_default() {
		$('#text_color').val('ABABAB');
		$('#text_color').css( 'background-color', '#ABABAB' );
		$('#text_color').css( 'color', 'black' );

		$('#stroke_color').val('000000');
		$('#stroke_color').css( 'background-color', 'black' );
		$('#stroke_color').css( 'color', 'whie' );

		$("#stroke_amount").val('5');
		$("#x_axis_amount").val('160');
		$("#font_amount").val('100');

		update(false, false, false, false, false);
	}

	function update(textColor, strokeColor, strokeSize, xAxis, fontSize) {
		    var name_text = $('#name_text_input').val();

		    var text_color = '#' + $('#text_color').val();
			if ( false != textColor ) {
			    var text_color = '#' + textColor;
			}

		    var stroke_color = '#' + $('#stroke_color').val();
			if ( false != strokeColor ) {
			    var stroke_color = '#' + strokeColor;
			}

		    var stroke_size = $('#stroke_amount').val();
			if ( false != strokeSize ) {
			    var stroke_size = strokeSize;
			}

		    var x_axis_size = $('#x_axis_amount').val();
			if ( false != xAxis ) {
			    var x_axis_size = xAxis;
			}

		    var font_amount = $('#font_amount').val();
			if ( false != fontSize ) {
			    var font_amount = fontSize;
			}

			console.log( "name_text: ", name_text);
			console.log( "stroke_color: ", stroke_color);
			console.log( "text_color: ", text_color);
			console.log( "stroke_size: ", stroke_size);
			console.log( "x_axis_size: ", x_axis_size);
			console.log( "font_amount: ", font_amount);



			$.ajax({
				type: "POST",
				url: 'generate_image.php',   
				data: {
					'name_text': name_text,
					'stroke_color': stroke_color,
					'text_color': text_color,
					'stroke_size': stroke_size,
					'x_axis_size': x_axis_size,
					'font_amount': font_amount
					},
				success: function (result) {
					console.log( "result: ", result);
					d = new Date();
					jQuery('#logo_img').attr("src","generated_images/final_image_new.png?"+d.getTime());
				},
		        error: function(jqXHR, textStatus, errorThrown) {
		        	console.log('jqXHR: ',jqXHR);
		            console.log('textStatus: ',textStatus);
		            console.log('errorThrown: ',errorThrown);
		        }
			});
	}

    // Stroke size slider
	$("#stroke_slider-range-min").slider({
        range: "min",
        value: 5,
        min: 0,
        step: 1,
        max: 10,
        slide: function (event, ui) {

            $("#stroke_amount").val(ui.value);
            console.log('Slider: ',  $("#stroke_amount").val());
            delay(function(){
	        	update(false, false, ui.value, false, false);
            }, input_delay_generate_time );

            if (ui.value == 0) {
                $("#stroke_slider-range-min").slider('value', 1);
                $("#stroke_amount").val('1');
            }
        },
        stop: function (event, ui) {
            if (ui.value == 0) {
	            $("#stroke_amount").val('1');
            }
        }
    });
    $("#stroke_amount").val($("#stroke_slider-range-min").slider("value"));

    // X axis slider
	$("#x_axis_slider-range-min").slider({
        range: "min",
        value: 60,
        min: 0,
        step: 10,
        max: 450,
        slide: function (event, ui) {

            $("#x_axis_amount").val(ui.value);

            console.log('Slider: ',  $("#x_axis_amount").val());
            delay(function(){
	        	update(false, false, false, ui.value, false);
            }, input_delay_generate_time );

            if (ui.value == 0) {
                $("#x_axis_slider-range-min").slider('value', 1);
                $("#x_axis_amount").val('1');
            }
        },
        stop: function (event, ui) {
            if (ui.value == 0) {
                $("#x_axis_amount").val('1');
            }
        }
    });
    $("#x_axis_amount").val($("#x_axis_slider-range-min").slider("value"));

    // Font size slider
	$("#font_slider-range-min").slider({
        range: "min",
        value: 100,
        min: 20,
        step: 10,
        max: 250,
        slide: function (event, ui) {

            $("#font_amount").val(ui.value);

            console.log('Slider: ',  $("#font_amount").val());
            delay(function(){
	        	update(false, false, false, false, ui.value);
            }, input_delay_generate_time );

            if (ui.value == 0) {
                $("#font_slider-range-min").slider('value', 1);
                $("#font_amount").val('1');
            }
        },
        stop: function (event, ui) {
            if (ui.value == 0) {
                $("#font_amount").val('1');
            }
        }
    });
    $("#font_amount").val($("#font_slider-range-min").slider("value"));

</script>