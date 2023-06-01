/**
 * In short, the function shown below requests the data, based on the classificationId and catches any errors if they exist, and sends the retrieved data to the buildInventoryList 
 * function for building it into HTML and then displays it into the vehicle management web page.
 */
'use strict' // the 'use strict' directive tells the JavaScript parser to follow all rules strictly.
 
    // Get a list of vehicles in inventory based on the classificationId 
    // Finds the classification select element in the vehicle management page based on its ID and stores its reference into a local JavaScript variable.
    let classificationList = document.querySelector("#classificationList"); 
    // Attaches the eventListener to the variable representing the classification select element and listens for any "change". When a change occurs an anonymous function is executed.
    classificationList.addEventListener("change", function () { 
        // Captures the new value from the classification select element and stores it into a JavaScript variable.
        let classificationId = classificationList.value; 
        // Writes the value as part of a string to the console log for testing purposes. Note that the text is surrounded by "ticks", not single quotes. The "tick" key is to the left 
        // of the 1 on your keyboard. Text that is surrounded by ticks is known as a JavaScript template literal. A JavaScript template literal is equivalent to using double-quotes in 
        // PHP, it allows the value of a variable to be rendered within a string without the use of concatenation.
        console.log(`classificationId is: ${classificationId}`); 
        // The URL that will be used to request inventory data from the vehicles controller. Notice the two parameter name-value pairs at the end.
        let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId; 
        // The JavaScript "Fetch" which is a modern method of initiating an AJAX request.
        fetch(classIdURL) 
        // A "then" method that waits for data to be returned from the fetch. The response object is passed into an anonymous function for processing.
        .then(function (response) { 
            // An "if" test to see if the response was retuned successfully. If not, the error on line 24 occurs.
            if (response.ok) { 
                // If the response was successful, then the JSON object that was returned is converted to a JavaScript object and passed on to 
                // the next "then" statement on line 28.
                return response.json(); 
            } 
            // The error that occurs if it if test (line 11) fails
            throw Error("Network response was not OK"); 
        }) 
        // Accepts the JavaScript object from line 12, and passes it as a parameter into an anonymous function.
        .then(function (data) { 
            // Sends the JavaScript object to the console log for testing purposes.
            console.log(data);
            // Sends the JavaScript object to a new function that will parse the data into HTML table elements and inject them into the vehicle management view. 
            buildInventoryList(data); 
        }) 
        // A "catch" which captures any errors and sends them into an anonymous function.
        .catch(function (error) { 
            // Writes the caught error to the console log for us to see for troubleshooting.
            console.log('There was a problem: ', error.message) 
        }) 
    })

// Build inventory items into HTML table components and inject into DOM 
// Declare the function and indicates the JavaScript object is a required parmater.
function buildInventoryList(data) { 
    // Reaches into the HTML document, uses the ID to capture the element and assigns it to a JavaScript variable for use later.
    let inventoryDisplay = document.getElementById("inventoryDisplay"); 
    // Set up the table labels 
    // Creates a JavaScript variable and stores the beginning HTML element into it as a string.
    let dataTable = '<thead>'; 
    // Creates the table row and three table cells as a string and appends it to the variable created on line 5.
    dataTable += '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>'; 
    // Adds the closing thead element to the variable using the append operator.
    dataTable += '</thead>'; 
    // Set up the table body 
    // Appends the opening tbody tag to the string stored in the variable.
    dataTable += '<tbody>'; 
    // Iterate over all vehicles in the array and put each in a row 
    // Implements the foreach method on the data object. Each element in the object is sent into an anonymous function as a parameter.
    data.forEach(function (element) { 
    // Sends the name and id of each element to the console log for testing purposes.
     console.log(element.invId + ", " + element.invModel); 
     // Creates a table cell with the vehicle name and appends it to the variable.
     dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`; 
     // Creates a table cell with a link to begin the update process for this item (note the inclusion of the action and invId name-value pairs in the URL) and appends it to the variable.
     dataTable += `<td><a href='/phpmotors/vehicles?action=mod&invId=${element.invId}' title='Click to modify'>Modify</a></td>`; 
     // Creates a table cell with a link to begin the delete process for this item (note the inclusion of the action and id name-value pairs in the URL) and appends it to the variable.
     dataTable += `<td><a href='/phpmotors/vehicles?action=del&invId=${element.invId}' title='Click to delete'>Delete</a></td></tr>`; 
    })
    // Appends the closing tbody element to the variable. 
    dataTable += '</tbody>'; 
    // Display the contents in the Vehicle Management view 
    // Injects the finished table components into the vehicle management view DOM element that was identified on line 3.
    inventoryDisplay.innerHTML = dataTable; 
   }