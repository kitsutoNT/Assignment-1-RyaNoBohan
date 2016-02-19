window.addEventListener("load", init);

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
        //console.log(trBrowser);
        
        var td = $('<td class="mdl-data-table__cell--non-numeric">').text(object.name);
        td.appendTo(trBrowser);
        td = $('<td>').text(object.percentVisits);
        td.appendTo(trBrowser);
        });
    });
        // .done(function (data) {
        //         console.log(data);
        //         console.log("this is success"); 
        //     })
        //     .fail(function (jqXHR) {
        //      //console.log("Error: " + jqXHR.status);
        //      //console.log(jqXHR);
        //      //console.log("this is error");
        //  })
        //  .always(function () {
        //      //console.log("All Done");
        //      //console.log("this is always done");
        //  });   
}



function outputDeviceCard() {
    var url = 'serviceVisitsData.php?table=device';
    $.get(url, function(data) {
        deviceDropDownListOptions(data);
    });
        
    $("#deviceDrop").change(function(){
        var chosenBrand = url + "&brand_id=" + this.value;
        
        $.get(chosenBrand, function(data) {
            outputDeviceVisitCount(data);
            loadingAnimation($("#deviceCard .mdl-spinner"));
        })
            
         .always(function () {
             //console.log("All Done");
             //console.log("this is always done");
             loadingAnimation($("#deviceCard .mdl-spinner"));
         });   
    });
    
}

function outputDeviceVisitCount(data) {
    $("#brandCount").text(data);
    $("#brandName").text($("#deviceDrop")[0].selectedOptions[0].innerText);
    
}

function deviceDropDownListOptions(data){
    $.each(data, function( key, object) {
        $("#deviceDrop").append($('<option>', {value: object.id, text: object.name})); 
    });
} 

function outputCountryCard() {
    var url = "serviceVisitsData.php?table=continent";
    
    $.get(url, function(data) {
        continentDropDownListOptions(data);
        //console.log(data);
    });
    
    $("#continentDrop").change(function(){
        var chosenContinent = "serviceVisitsData.php?table=country&continentCode=" + this.value;
        $.get(chosenContinent, function(data) {
            //console.log(data);
            outputCountriesVisitCount(data);
           loadingAnimation($("#countryCard .mdl-spinner"));
        })
            .always(function () {
             //console.log("All Done");
             //console.log("this is always done");
             loadingAnimation($("#countryCard .mdl-spinner"));
            });   
    })
}

function outputCountriesVisitCount(data) {
    $("#countryCount").empty();
    
    $.each(data, function( key, object) {
        $("#countryCount").append($('<tr>')); 
        
        var trCountry = $("#countryCount")[0].lastElementChild;
        //console.log(trBrowser);
        
        var td = $('<td class="mdl-data-table__cell--non-numeric">').text(object.name);
        td.appendTo(trCountry);
        td = $('<td>').text(object.visitCount);
        td.appendTo(trCountry);
        });
}

function continentDropDownListOptions(data) {
    $.each(data, function( key, object) {
        $("#continentDrop").append($('<option>', {value: object.ContinentCode, text: object.ContinentName})); 
    });
}

function loadingAnimation($element) {
    if ($element.hasClass("is-active") == false) {
        $element.addClass("is-active");
        console.log("showing loading animation");
    }
    else {
        console.log("removed loading animation");
        $element.removeClass("is-active");
    }
}