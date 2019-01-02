$(function () {

    $( '#user_table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'default'
    });
    
});


function toggle(id){

	var index = id.options.selectedIndex;

	var email = id.name;
	var value = id.options[index].value;
	var type =  id.id;

	// console.log("Email: " + email);
	// console.log("Value: " + value);
	// console.log("Type: " + type);

	var variables = "email="+email+"&value="+value;

	if(type == 'level_options'){
		jQuery.ajax({
			type: "get",
			url : "../php/edit_lvl.php",
			data: variables,
			dataType: "json",
			success: function(json){
			 //    alert(json.first);
				// alert(json.second);
			},
		 error: function(xhr, status, error) {
		      console.log(xhr);
		      console.log(status);
		      console.log(error);
		   }
		});
	}else{
		jQuery.ajax({
			type: "get",
			url : "../php/edit_status.php",
			data: variables,
			dataType: "json",
			success: function(json){
			 //    alert(json.first);
				// alert(json.second);
			},
		 error: function(xhr, status, error) {
		      console.log(xhr);
		      console.log(status);
		      console.log(error);
		   }
		});
	}
};

function editUser(user){

	document.getElementById('user_hidden').value= user;

	$('#edit_user').modal();
}

function checkOut(user,user_email,admin,admin_email){

	document.getElementById('user_info').innerHTML= user + " ("+user_email+")";
	document.getElementById('admin_info').innerHTML= admin + " ("+admin_email+")";

	document.getElementById('user_hidden').value= user_email;
	document.getElementById('admin_hidden').value= admin_email;

	$('#check_out').modal();
}

function checkIn(user,user_email,admin,admin_email, rentalid){

	document.getElementById('user_info_in').innerHTML= user + " ("+user_email+")";
	document.getElementById('admin_info_in').innerHTML= admin + " ("+admin_email+")";

	document.getElementById('user_hidden_in').value= user_email;
	document.getElementById('admin_hidden_in').value= admin_email;
	document.getElementById('rentalid_hidden').value= rentalid;

	var variables = "id="+rentalid+"&email="+user_email;


	jQuery.ajax({
		type: "get",
		url : "../php/rental_info.php",
		data: variables,
		dataType: "json",
		success: function(json){
			document.getElementById('bike_in').innerHTML= json['bikeid'];
			document.getElementById('admin_out').innerHTML= json['checkout_admin'];
			document.getElementById('station_out').innerHTML= json['rented_from'];
			document.getElementById('date_out').innerHTML= json['time_rented'];
		},
	 error: function(xhr, status, error) {
	      console.log(xhr);
	      console.log(status);
	      console.log(error);
	   }
	});

	$('#check_in').modal();

}

//Get all of the bikes currently at a station
function getBikes(){
    var station = document.getElementById('station');
    var selected = station.options[station.selectedIndex].value;
    var variables = "station="+selected;
    jQuery.ajax({
        type: "get",
        url: "../php/bike_get.php",
        data: variables,
        dataType: "json",
        success: function (json) {
            var s = '';
            if (json.length == 0) {
                s = 'No bikes available.';
            }
            else {
                s = '<select name="bike" id="bike">';
                for (var i = 0; i < json.length; i++) {
                    s += '<option value="' + json[i] + '" class="bike_option" id="' + selected + '">' + json[i] + '</option> \n';
                }
                s += '</select>';
            }
            document.getElementById('bike_list').innerHTML = s;
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}


$(document).ready(function(){

	$(".options").focus(function() {
		$(this).find("#initial").hide();
		});

	$('.filter_user').change(function(){

		var active_check = $('#active')[0];
		var pending_check = $('#pending')[0];
		var disabled_check = $('#disabled')[0];
		var checkout_check = $('#checkout')[0];
		var manager_check = $('#manager')[0];

		var active = "";
		var pending = "";
		var disabled = "";
		var checkout = "";
		var manager = "";


		if (active_check.checked){
			active = active_check.value;
		}

		if (pending_check.checked){
			pending = pending_check.value;
		}

		if (disabled_check.checked){
			disabled = disabled_check.value;
		}

		if (checkout_check.checked){
			checkout = checkout_check.value;
		}

		if (manager_check.checked){
			manager = manager_check.value;
		}

		$('.user_row').each(function(){
			var level = $('#level_options',this)[0].value;
			var status = $('#status_options',this)[0].value;

			if ((active == "" || status == active) &&
				(pending == "" || status == pending) &&
				(disabled == "" || status == disabled) &&
				(checkout == "" || level == checkout) &&
				(manager == "" || level == manager)){
			$(this).show();
		}else{
			$(this).hide();
		}

		});
	});

	$('.filter_rentals').change(function(){

		var all = $('#all')[0];
		var active = $('#active')[0];
		var returned = $('#returned')[0];

		var all = all.checked;
		var active = active.checked;
		var returned =returned.checked;

		$('.rental_row').each(function(){
		var status = $('#status',this)[0].textContent;

		if (all || (active && status == "Active") || (returned && status == "Returned")){
			$(this).show();
		}else{
			$(this).hide();
		}

		});
	});

	$('#stations').change(function(){
		var sel = $(this);
		var station = sel[0].value;

		//console.log(sel);
		//console.log("station: " + station)

		$('.bike_option').each(function(){
			var bike = $(this);
			var bike_station = bike[0].id;

			if (bike_station == station){
				//console.log("Showing: " + bike_station);
				$(this).show();
			}else{
				//console.log("Hiding: " + bike_station);
				$(this).hide();
			}

			// console.log(bike);
			//console.log(bike[0].id);

		});

	});


})
