
function searchOrders()
{
    var searchOrderString = document.getElementById("searchedTime").value;
    //alert("I see you are serching for ..." + searchPLayerString);
    var xhr = new XMLHttpRequest();
    
    xhr.open('POST','searchedtime.php');
    
    xhr.setRequestHeader('content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function(){
	
	if (xhr.readyState === 4 && xhr.status === 200) {
			//alert(xhr.responseText); // 'This is the output.'
                        document.getElementById("SearchResults").innerHTML = xhr.responseText;
            }
    };
        xhr.send('searchedTime=' + searchOrderString);
};
    
function handleError(error) {
    alert('An AJAX error has occured: ' + error);
}




