function setOperation(id){
    var index = id.options.selectedIndex;
    var value = id.options[index].value;

    jQuery.ajax({
        type: "post",
      url : "../php/stations_edit.php",
    data: variables,
    dataType: "json",
    success: function(json){
    },
      error: function(xhr, status, error) {
          console.log(xhr);
          console.log(status);
          console.log(error);
      }
  });
    
}

//Add a station
function addStation(){
    $('#add_station').modal();

}

//Show the flagged text for this bike
function flag(name, msg){
    //set title
    document.getElementById('stationTitle').innerHTML = "Flagged Message for "+name;
    //set body
    document.getElementById('stationBody').innerHTML = msg;
    //set buttons
    document.getElementById('closeButton').innerHTML = 'OK';
    document.getElementById('okButton').style.display = 'none';  
}

//Get information on a station
function info(name, address, bs, hs, ls, hrs) {
  $('#edit_station').modal();

    //set title
    document.getElementById('stationTitle').innerHTML = name;

    document.getElementsByName('addr2')[0].value = address;
    document.getElementsByName('hours_link2')[0].value = hrs;
    document.getElementsByName('bikes')[0].value = bs;
    document.getElementsByName('helmets')[0].value = hs;
    document.getElementsByName('locks')[0].value = ls;

    document.getElementById('name_hidden').value = name;

}



//Display notes for a station
function getNotes(name){
   $('#edit_note').modal();
    //set title
    document.getElementById('noteTitle').innerHTML = "Notes for " +name;

    document.getElementById('name_hidden2').value = name;
    
}


//Delete a station popup
function deleteStation(name){
        //set title
    document.getElementById('stationTitle').innerHTML = "Delete " +name +"?";
    //set body
    document.getElementById('stationBody').innerHTML = "Are you sure you want to delete the station "+name+"? "
                                                       +"This station will be deleted permanently.";
    //set buttons
    document.getElementById('closeButton').innerHTML = 'Cancel';
    document.getElementById('okButton').innerHTML = 'Delete';

    document.getElementById('okButton').onclick = function () {

        var variables = "station=" + name;

        jQuery.ajax({
            type: "get",
            url: "../php/delete_station.php",
            data: variables,
            dataType: "json",
            success: function (json) {
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }   
}


function toggle_status(name, text){

    var index = name.options.selectedIndex;

    var station = name.name;
    var value = name.options[index].value;

    // console.log("Station: " + station);
    // console.log("Value: " + value);

    var variables = "station="+station+"&value="+value+"&text="+text;

    jQuery.ajax({
        type: "get",
        url: "../php/toggle_status.php",
        data: variables,
        dataType: "json",
        success: function (json) {
            // alert(json.first);
            // alert(json.second);
            location.reload();
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });

};

function set_status(id){
    var index = id.options.selectedIndex;
    var station = id.name;
    var value = id.options[index].value;
    if(value=="closed"){
        //Create flag text popup
        document.getElementById('stationTitle').innerHTML = "Reason for flagging " +station +"?";
        //set body
        document.getElementById('stationBody').innerHTML = "<input type='text' id='reason' />";
        //set buttons
        document.getElementById('closeButton').innerHTML = 'Cancel';
        document.getElementById('okButton').style.display = 'inline-block';
        document.getElementById('okButton').innerHTML = 'Submit';
        document.getElementById('okButton').onclick = function () {
            var reason = document.getElementById('reason').value;
            toggle_status(id, reason);
            $('#stationModal').modal('hide');
        }
        $('#stationModal').modal();
    }
    else{
        toggle_status(id, "null");
    }
}

function toggle_main(name){

    var index = name.options.selectedIndex;

    var value = name.options[index].value;

    // console.log("Station: " + station);
    //console.log("Value: " + value);

    var variables = "value="+value;

    jQuery.ajax({
        type: "get",
        url : "../php/toggle_main.php",
        data: variables,
        dataType: "json",
        success: function(json){
            //alert(json.first);
            // alert(json.second);
        },
     error: function(xhr, status, error) {
          console.log(xhr);
          console.log(status);
          console.log(error);
       }
    });

};