<script type="text/javascript">
$("#searchButton").on("click", search);
// After the API loads, call a function to enable the search box.
function handleAPILoaded() {
  $('#search-button').attr('disabled', false);
}
// Search for a specified string.
function search(){
	$(".searchResult").empty();
	var inputKeyword = $("#inputKeyword").val();
	var inputCity = $("#inputCity").val();
	var title = "";
	var searchURL;
	var array;
	
	if((inputKeyword.length > 0) || (inputCity.length > 0)) {
		$("#loading").fadeIn(200);
		$(".searchResult").append("<i>Your search yielded following result:</i></p></br>");
		searchURL = "http://api.eventful.com/json/events/search?q=" + inputKeyword + "&location=" + inputCity + "&page_size=15&app_key=vhhdJmn8k9W6CwRf";
		$.ajax({
		type:"GET", 
		url: searchURL, 
		success: function(data) {
			if(data["events"] != null) {
				array = data["events"].event;
				$(".searchResult").append("Number of hits: " + data["total_items"] + "</p>");
			
				for(i = 0; i < array.length; i++) {
					$(".searchResult").append("<div class=eventDiv><center><font size=5>" + array[i]["title"] + "</font></center><br><b>Description: </b>" + array[i]["description"] + "</p><button class=saveButton width=100% data-title='" + array[i]["title"] + "'>Spara event</button></div></p>");
				}
				$(".saveButton").on("click", saveEvent(array[i]));
				$("#loading").fadeOut(200);
			} else {
				$("#loading").fadeOut(200);
				alert("No event matched your search.");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        },
		dataType: "jsonp"
		
		});
	} else {
		alert("You have to enter a city or keyword to be able to search!");
	}
	
	
}
function saveEvent(array){
	var title = $(this).attr("data-title");
	var txt = "Nytt event tillagt:\n" + title;
	//localStorage.setItem("savedEvent", title);
	//document.getElementById('lbl_savedEvent').innerHTML = title;
	
	<?php
	$servername = "localhost";
	$username = "ab7675";
	$password = "v*m9XPC8";
	$dbname = "AB7675";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "INSERT INTO events (title)
	VALUES (array["title"])";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
	?>
	
	alert(txt);
}
document.getElementById('inputKeyword').onkeypress = function(e){
    if(!e) e = window.event;
    var keyCode = e.keyCode || e.which;
    if (keyCode == '13'){
      // Enter pressed
      search();
	  return false;
    }
}
document.getElementById('inputCity').onkeypress = function(e){
    if(!e) e = window.event;
    var keyCode = e.keyCode || e.which;
    if (keyCode == '13'){
      // Enter pressed
      search();
	  return false;
    }
}
</script>

<h1>Search event</h1>
<p>
Please enter a city or keyword to search for event
</p>
<hr></p>
<form>
<table width=100%><tr><td width=50%>Keyword:<br><input type="text" size="15" id="inputKeyword" autofocus></td>
<td width=50%>City:<br><input type="text" size="15" id="inputCity"></td></tr></table><p>
<button type="button" id="searchButton">Search</button>
</form>
<div class="searchResult"></div>