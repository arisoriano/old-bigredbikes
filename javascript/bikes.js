//Add a bike
function addBike(){
    $('#add_bike').modal();

}

//Show the flagged text for this bike
function flag(id, msg){
    //set title
    document.getElementById('bikeTitle').innerHTML = "Flagged Message for Bike "+id;
    //set body
    document.getElementById('bikeBody').innerHTML = msg;
    //set buttons
    document.getElementById('closeButton').innerHTML = 'OK';
    document.getElementById('okButton').style.display = 'none';  
}

//Get information on a station
function info(id, station) {
    $('#edit_bike').modal();

    //set title
    document.getElementById('bikeTitle').innerHTML ="Edit Information for Bike " +id;
    //set body

    document.getElementById('bike_hidden_id2').value = id;

    //set buttons
    document.getElementById('initial').innerHTML = station;
    document.getElementById('initial').value = station;  
}

function getNotes(id){
    $('#edit_note').modal();
    //set title
    document.getElementById('noteTitle').innerHTML = "Notes for Bike " +id;

    document.getElementById('bike_hidden_id3').value = id;
}


//Delete a bike popup
function deleteBike(id){
    //set title
    document.getElementById('bikeTitle').innerHTML = "Delete Bike " +id +"?";
    //set body
    document.getElementById('bikeBody').innerHTML = "Are you sure you want to delete Bike "+id+"? "
                                                       +"This Bike will be deleted permanently.";
    //set buttons
    document.getElementById('closeButton').innerHTML = 'Cancel';
    document.getElementById('okButton').style.display = 'inline-block';
    document.getElementById('okButton').innerHTML = 'Delete';  

    document.getElementById('okButton').onclick = function(){

        var variables = "bike_id="+id;

        jQuery.ajax({
            type: "get",
            url : "../php/delete_bike.php",
            data: variables,
            dataType: "json",
            success: function(json){
                location.reload();
            },
         error: function(xhr, status, error) {
              console.log(xhr);
              console.log(status);
              console.log(error);
           }
        });
    }

}

function toggle_flag(id){

    var index = id.options.selectedIndex;

    var bike = id.name;
    var value = id.options[index].value;

    console.log("Bike: " + bike);
    console.log("Value: " + value);

    var variables = "bike="+bike+"&value="+value;

    jQuery.ajax({
        type: "get",
        url : "../php/toggle_flag.php",
        data: variables,
        dataType: "json",
        success: function(json){
            // alert(json.first);
            // alert(json.second);
        },
     error: function(xhr, status, error) {
          console.log(xhr);
          console.log(status);
          console.log(error);
       }
    });

};