window.addEventListener("load", init);

//initialize three cards in this page
function init() {
    outputBrowserCard();
    outputDeviceCard();
    outputCountryCard();
}

function outputBrowserCard () {
    var url = "serviceVisitsData.php?table=browser";
    $.get(url, function(data) {
        $.each(data, function( key, object) {
        $("#browserOutput").append($('<tr>')); 
        
        var trBrowser = $("#browserOutput")[0].lastElementChild;
        
        var td = $('<td class="mdl-data-table__cell--non-numeric">').text(object.name);
        td.appendTo(trBrowser);
        td = $('<td>').text(object.percentVisits);
        td.appendTo(trBrowser);
        });
    });
}

//call loading animation when user makes change in device filter
function outputDeviceCard() {
    var url = 'serviceVisitsData.php?table=device';
    
    $.get(url, function(data) {
        deviceDropDownListOptions(data);
    });
        
    $("#deviceDrop").change(function(){
        var chosenBrand = url + "&brand_id=" + this.value;
        $("#deviceCard .mdl-spinner").addClass("is-active");
        $.get(chosenBrand, function(data) {
            outputDeviceVisitCount(data);
            
        })
         .always(function () {
             $(".mdl-spinner").removeClass("is-active");
         });   
    });
    
}

//helper function called by outputDeviceCard function to output the # of visits by devices
function outputDeviceVisitCount(data) {
    $("#brandCount").text(data);
    $("#brandName").text($("#deviceDrop")[0].selectedOptions[0].innerText);
}

//helper function called by outputDeviceCard function to output all devices in options in dropdown lists
function deviceDropDownListOptions(data){
    $.each(data, function( key, object) {
        $("#deviceDrop").append($('<option>', {value: object.id, text: object.name})); 
    });
} 

//call loading animation when user changes continent in filter 
function outputCountryCard() {
    var url = "serviceVisitsData.php?table=continent";
    
    $.get(url, function(data) {
        continentDropDownListOptions(data);
    });

    $("#continentDrop").change(function(){
        var chosenContinent = "serviceVisitsData.php?table=country&continentCode=" + this.value;
        $("#countryCard .mdl-spinner").addClass("is-active");
        $.get(chosenContinent, function(data) {
            outputCountriesVisitCount(data);
        })
            .always(function () {
             $("#countryCard .mdl-spinner").removeClass("is-active");
            });   
    })
}

//helper function called by outputCountryCard function to output the # of visits by countries
function outputCountriesVisitCount(data) {
    $("#countryCount").empty();
    
    $.each(data, function( key, object) {
        $("#countryCount").append($('<tr>')); 
        
        var trCountry = $("#countryCount")[0].lastElementChild;
        
        var td = $('<td class="mdl-data-table__cell--non-numeric">').text(object.name);
        td.appendTo(trCountry);
        td = $('<td>').text(object.visitCount);
        td.appendTo(trCountry);
        });
}

// helper function called by outputCountryCard to output all continents in options in dropdown list
function continentDropDownListOptions(data) {
    $.each(data, function( key, object) {
        $("#continentDrop").append($('<option>', {value: object.ContinentCode, text: object.ContinentName})); 
    });
}


