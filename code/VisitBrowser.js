window.addEventListener("load", init);

function init() {
    outputFilterCard();
    outputDataCard();
    
}

function outputFilterCard() {
    var mainPath = "serviceVisitsData.php?table=";
    //outputDeviceTypeFilter(mainPath);
    outputFilter(mainPath, "deviceType", "#device-typeFilter");
    outputFilter(mainPath, "device", "#device-brandFilter");
    outputFilter(mainPath, "browser", "#browserName");
    outputFilter(mainPath, "referrer", "#referrerName");
    outputFilter(mainPath, "operatingSystem", "#operatingSystem");
}

// function outputDeviceTypeFilter(mainPath) {
//     var url = mainPath + "deviceType";
//     var select = $("<select>").appendTo($("#device-typeFilter"));
//     var firstOption = $("<option>", {text: Select a Device Type});
//     firstOption.appendTo($("#device-typeFilter select"));
//     $.get(url, function(data) {
//         $.each(data, function (key, object) {
//             select.append($('<option>', {value: object.id, text: object.name})); 
//         });
//     })
    
// }

function outputFilter(mainPath, filterType, trIdName) {
    var url = mainPath + filterType;
    
    $(trIdName).append($("<select>").addClass("mdl-textfield__input"));
    var select = $(trIdName + " select");
    console.log(select);
    var firstOption = $("<option>").text("Select a " + filterType);
    firstOption.appendTo(select);
    
    $.get(url, function(data) {
        console.log(data);
        $.each(data, function (key, object) {
            select.append($('<option>', {value: object.id, text: object.name})); 
        });
    })
}





function outputDataCard() {
    
}