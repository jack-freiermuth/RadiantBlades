// var form = document.getElementById("exercise_form");
// var start_button = document.getElementById("start_button");
// var stop_button = document.getElementById("stop_button");
// var exercise_display = document.getElementById("exercise_display");
// var exercise_number_id = document.getElementById("exercise_number");
// var exercise_time_id = document.getElementById("exercise_time");
// var break_time_id = document.getElementById("break_time");
// var circuit_number_id = document.getElementById("circuit_number");
// var rest_time_id = document.getElementById("rest_time");
// var circuit_name_id = document.getElementById("circuit_name");

// var timeouts = [];
// var intervals = [];
// var error_message ="";



// window.onload = function () {
//   check_for_and_change_rest_display();
//   check_for_and_change_break_display();
// }

// function check_for_and_change_rest_display() {
//   console.log("checking...")
//     if ( "" === circuit_number_id.value || circuit_number_id.value < 2 ) {
//     rest_time_id.style.display="none";
//     document.getElementById("rest_row").style.display="none";
//   } else {
//     rest_time_id.style.display="block";
//     document.getElementById("rest_row").style.display="block";
//   }
// }

// function check_for_and_change_break_display() {
//     if ( "" === exercise_number_id.value || exercise_number_id.value < 2 ) {
//     break_time_id.style.display="none";
//     document.getElementById("break_row").style.display="none";
//   } else {
//     break_time_id.style.display="block";
//     document.getElementById("break_row").style.display="block";
//   }
// }

// start_button.addEventListener("click", function(event) {
//   var validation = validate_input();
//   if ( validation.success ){
//     cancelEvent(event);
//     startExercise();
//     form.style.display="none";
//     document.getElementById('exercise_display').style.display = 'block';
//     stop_button.style.display = 'block';
//     exercise_display.className = "animated bounceInDown center-text"; 
//     document.body.className = "exercise-background";
//     // If there is less than 2 circuits, don't show what circuit we are on.
//     if ( circuit_number_id.value == 1 ) {
//       circuit_name_id.style.display="none";
//     } else {
//       circuit_name_id.style.display="block";
//       rest_time_id
//     }
//   } else {
//     error_alert_and_wobble( validation.invalid_inputs );
//   }

// });


// //Hide the break time option on click if there is only one exercise
// exercise_number_id.addEventListener("click", function(event) {
//   if ( exercise_number_id.value < 2 ) {
//     break_time_id.style.display="none";
//     document.getElementById("break_row").style.display="none";
//   } else {
//     break_time_id.style.display="block";
//     document.getElementById("break_row").style.display="block";
//   }
// });

// //Hide the rest time option on click if there is only one circuit
// circuit_number_id.addEventListener("click", function(event) {
//   if ( circuit_number_id.value < 2 ) {
//     rest_time_id.style.display="none";
//     document.getElementById("rest_row").style.display="none";
//   } else {
//     rest_time_id.style.display="block";
//     document.getElementById("rest_row").style.display="block";
//   }
// });


// // Event listener for the stop button
// stop_button.addEventListener("click", function(event) {
//   cancelEvent(event);
//   form.style.display = "block";
//   stop_button.style.display = 'none';
//   document.body.className = "start-background";
//   document.getElementById('exercise_display').style.display = 'none';
//   haltWorkout();
//   exercise_display.className ="";
// });

// //When we want to stop the exercise, we need to clear the timeouts and intervals
// function haltWorkout() {
//   timeouts.forEach( function( item ) {
//     clearTimeout( item );
//   });
//   intervals.forEach( function( item ) {
//     clearInterval( item );
//   }); 
// }

// /**
//  * If they have an invalid number, or the wrong type of input, return an object with an error message.
//  * @return {object}
//  */
// function validate_input() {
//   var validation_results = { success: true, invalid_inputs: [] }
//   error_message ="";
//   if ( exercise_number_id.value < 1 ) {
//     error_message += "\nThere must be at least 1 exercise!";
//     validation_results.success = false;
//     validation_results.invalid_inputs.push( exercise_number_id );
//   } 
//   if ( exercise_time_id.value < 1 ) {
//     error_message += "\nExercise time must be at least 1 second!";
//     validation_results.success = false;
//     validation_results.invalid_inputs.push( exercise_time_id );
//   } 
//   if ( break_time_id.style.display !== 'none' && ( "" === break_time_id.value || break_time_id.value < 0 ) ) {
//     error_message += "\nBreak time length cannot be below 0!";
//     validation_results.success = false;
//     validation_results.invalid_inputs.push( break_time_id );
//   }
//   if ( rest_time_id.style.display !== 'none' && ("" === rest_time_id.value || rest_time_id.value < 0 ) ) {
//     error_message += "\nRest time length cannot be below 0!";
//     validation_results.success = false;
//     validation_results.invalid_inputs.push( rest_time_id );
//   }
//   if ( circuit_number_id.value < 1 ) {
//     error_message += "\nThere must be at least 1 circuit!";
//     validation_results.success = false;
//     validation_results.invalid_inputs.push( circuit_number_id );
//   }
//   console.log(validation_results);
//   return validation_results;
// }

// /**
//  * This is supposed to remove the "animated" and "wobble" classes so we can re-apply them for more wobbles
//  */
// function error_alert_and_wobble( invalid_inputs ) {
//   // Add the wobble class
//   invalid_inputs.forEach( function( key ) {
//     key.classList.add( 'wobble' );
//   });

//   // Show the error message.
//   alert( error_message );

//   //Remove the wobble class so it can keep doing it.
//   invalid_inputs.forEach( function( key ) {
//     key.classList.remove( 'wobble' );
//   });
// }

// function startExercise() {
//   var exercise_number = parseInt(document.getElementById("exercise_number").value);
//   var exercise_time = parseInt(document.getElementById("exercise_time").value);
//   var break_time = parseInt(document.getElementById("break_time").value);
//   var circuit_number = parseInt(document.getElementById("circuit_number").value);
//   var rest_time = parseInt(document.getElementById("rest_time").value);
//   var circuit_time = (exercise_number * (exercise_time + break_time));
//   var circuit_counter = 0;

//   runCircuit();

//   function runCircuit() {
//     var exercise_counter = 0;
//     function runExercise() {
//       document.body.className = "exercise-background";
//       console.log("starting exercise" + exercise_counter);
//       set_circuit_name( "Circuit " + ( circuit_counter + 1 ) );
//       set_session_name( "Exercise " + ( exercise_counter + 1 ) );
//       startCountdown(exercise_time, function() {
//         document.body.className = "rest-background";
//         console.log("starting breaktime " + exercise_counter);
//         set_session_name( "Break " + ( exercise_counter + 1 ) );

//         var current_break_time = (exercise_counter == exercise_number - 1) ? 0 : break_time;

//         startCountdown(current_break_time, function() {
//           exercise_counter++;

//           if (exercise_counter != exercise_number) {
//             runExercise();
//           }
//         });
//       });
//     }

//     runExercise();

//     var rest_timer = setTimeout(function() {
//       var current_rest_time = (circuit_counter == circuit_number - 1 ) ? 0 : rest_time;

//       console.log("starting rest" + circuit_counter);
//       set_session_name( "Rest " + ( circuit_counter + 1 ) );

//       startCountdown(current_rest_time, function() {
//         circuit_counter++;

//         if (circuit_counter != circuit_number) {
//           runCircuit();
//         }
//       });
//     }, circuit_time * 1000 );
//     timeouts.push( rest_timer );
//   };
// }

// function startCountdown( time, callback ) {
//   var current = time;
//   console.log( current );
//   set_displayed_timer( current );

//   var timer = setInterval(function() {
//     current--;
//     console.log(current);
//     set_displayed_timer( current );
//   }, 1000);

//   intervals.push( timer );

//   var countdown = setTimeout(function() {
//     clearInterval(timer);
//     if (callback !== undefined) callback();
//   }, (time) * 1000);

//   timeouts.push( countdown );
// }

// function cancelEvent( event ) {
// 	if ( event.preventDefault ) {
// 		event.preventDefault();
// 	} else {
// 		event.returnValue = false;
// 	}
// }

// function set_circuit_name( currentCircuit ) {
//     document.getElementById('circuit_name').innerHTML=currentCircuit;
// }

// function set_session_name( currentSession ) {
//     document.getElementById('session_name').innerHTML=currentSession;
// }

// function set_displayed_timer( currentTime ) {
//     document.getElementById('timer').innerHTML=currentTime;
// }
// 


// jQuery('#gen_button').click(function() {
//   alert($('#name_text_input').val());
// });