window.addEventListener("load", init);

//initialize two cards filter card and data card
function init() {
    var mainPath = "serviceVisitsData.php?table=";
    outputFilterCard(mainPath);
    setupFilters(mainPath);

}

//output all dropdown lists with all options
function outputFilterCard(mainPath) {
    outputFilter(mainPath, "deviceType", "#type");
    outputFilter(mainPath, "device", "#brand");
    outputFilter(mainPath, "browser", "#browser");
    outputFilter(mainPath, "referrer", "#referrer");
    outputFilter(mainPath, "operatingSystem", "#operatingSys");
}

//send Ajax request when user makes change on any filters and output result rows 
function dataRequestFromFilters(filtObj){
    $("#filters").on("change", "select", function() {
        $(".mdl-spinner").addClass("is-active");
        $.get(filtObj.url, function(data) {
            
            outputFilteredRows(data);
        })
        .always(function() {
            $(".mdl-spinner").removeClass("is-active");
        });
    });
}

//generate rows as the result based on user's choices in filters
function outputFilteredRows(data) {
    $("#filteredResult").empty();

    $.each(data, function(key, object) {
        $("#filteredResult").append($('<tr>')); 
        var tr = $("#filteredResult")[0].lastElementChild;
        
        var tdAction = $('<button id=dialogOpener-'+ object.visitID +' class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">');
        var icon = $('<i class="material-icons">').text("info");
        icon.appendTo(tdAction);
        tdAction.appendTo(tr);
        
        var date = object.visitDate;
        date = date.substr(0,10);
        var tdDate = $('<td class="mdl-data-table__cell--non-numeric">').text(date);
        tdDate.appendTo(tr);
        
        var time = object.visitTime;
        time = time.substr(11,18);
        var tdTime = $('<td class="mdl-data-table__cell--non-numeric">').text(time);
        tdTime.appendTo(tr);
        
        var tdIp = $('<td class="mdl-data-table__cell--non-numeric">').text(object.visitIP);
        tdIp.appendTo(tr);
         
        var tdCountry = $('<td class="mdl-data-table__cell--non-numeric">').text(object.visitCountry);
        tdCountry.appendTo(tr);
        
         addEventToDialog(object.visitID);
        });
}

//create dialogbox and append entire table to div element id "modalBox"
function instantiateDialogBox(id) {
    var dialogBox = $('<div id="dialog-'+ id + '" title="Detailed Information">');
    var table = $('<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">').appendTo(dialogBox);
    var thead = $("<thead>").appendTo(table);
    var trHead = $("<tr>").appendTo(thead);
    
    trHead = appendToTHead(trHead, "Visit ID");
    trHead = appendToTHead(trHead, "Visit Date");
    trHead = appendToTHead(trHead, "Visit Time");
    trHead = appendToTHead(trHead, "IP Address");
    trHead = appendToTHead(trHead, "Country");
    trHead = appendToTHead(trHead, "Device Type");
    trHead = appendToTHead(trHead, "Brand");
    trHead = appendToTHead(trHead, "Browser");
    trHead = appendToTHead(trHead, "Referrer");
    trHead = appendToTHead(trHead, "Operating System");
    
    var tbody = $("<tbody>").appendTo(table);
    var tr = $("<tr>").appendTo(tbody);
    
    var url = "serviceVisitsData.php?table=visits&visitID=" +id;
    
    $.get(url, function(data){
        //console.log(data);
        tr = appendToTr(tr, data.visitID);
        tr = appendToTr(tr, data.visitDate);
        tr = appendToTr(tr, data.visitTime);
        tr = appendToTr(tr, data.visitIP);
        tr = appendToTr(tr, data.countryName);
        tr = appendToTr(tr, data.visitDeviceType);
        tr = appendToTr(tr, data.visitDeviceBrand);
        tr = appendToTr(tr, data.visitBrowser);
        tr = appendToTr(tr, data.visitReferrer);
        tr = appendToTr(tr, data.visitOS);
    });
    
    dialogBox.appendTo($("#modalBox"));
}

//triggered when user clicked an icon on the beggining of a row and output detail information in dialog
function addEventToDialog(id) {
    
    instantiateDialogBox(id);
    
    $("#dialog-"+ id).dialog({
               autoOpen: false, 
               modal: true,
               hide: "puff",
               show : "slide",
               width: 1200
    });
    
    $("#dialogOpener-"+ id).on("click", function() {
        $("#dialog-"+id).dialog( "open" );
        
    });
}

//append th tag to tr tag in table heading tag
function appendToTHead(trHead, headerName){
    var th = $('<th class="mdl-data-table__cell--non-numeric">').text(headerName);
    th.appendTo(trHead);
    
    return trHead
}

//append td tag to tr tag in table body tag
function appendToTr(tr, objData) {
    var td = $("<th>").text(objData);
    td.appendTo(tr);
    
    return tr;
}

//generalized function for output 4 different dropdown list
function outputFilter(mainPath, filterType, trIdName) {
    var url = mainPath + filterType;
    
    $(trIdName).append($("<select>").addClass("mdl-textfield__input"));
    var select = $(trIdName + " select");
    var firstOption = $("<option value=0>").text("Select a " + filterType);
    firstOption.appendTo(select);
    
    $.get(url, function(data) {
        $.each(data, function (key, object) {
            select.append($('<option>', {value: object.id, text: object.name})); 
        });
    })
}

//autocomplete function 
function autocompleteCountries(objType, filtObj){
    var urlCountries = "serviceVisitsData.php?table=country";
    var updatedObj ={};
    $("#search").autocomplete({
        source: urlCountries,
        autoFocus:true,
        minLength: 1,
        select: function(event, ui){
            updatedObj = addCountryToURL(objType, filtObj, ui.item.value);
            console.log(updatedObj);
            $.get(filtObj.url, function(data) {
                //show loading animation by adding "is-active" class to spinner
            loadingAnimation($(".mdl-spinner"));
            outputFilteredRows(data);
            })
            
            .always(function() {
                //delete loading animatin by removing "is-active" class in spinner
            loadingAnimation($(".mdl-spinner"));
            });
        },
    });
    
    //if user deleted country name in textbox, then update country value in url with empty string
    $("#search").on("input", function() {
        if ($(this).val() == "") {
            updatedObj.url = updatedObj.url.replace("&country=" + updatedObj.country, "");
            updatedObj.country=null;
            $.get(filtObj.url, function(data) {
            outputFilteredRows(data);
            });
        }
    })
    
    return updatedObj;
}

//setup filters and save information of url in filtObj
function setupFilters(mainPath) {
    var url = mainPath + "filteredData";

    url = "serviceVisitsData.php?table=filteredData";
    var filtObj = {};
    filtObj["type"] = "";
    filtObj["brand"] = "";
    filtObj["browser"] = "";
    filtObj["referrer"] = "";
    filtObj["operatingSys"] = "";
    filtObj["country"] = "";
    
    filtObj["url"] = url + "&type=" + filtObj["type"] + "&brand=" + filtObj["brand"] 
                    + "&browser=" + filtObj["browser"] + "&referrer="+filtObj["referrer"] 
                    + "&operatingSys="+ filtObj["operatingSys"] + "&country=" +filtObj["country"];
    
    var updatedObj= {};
    
    updatedObj = addEventToFilters("type", filtObj);
    updatedObj = addEventToFilters("brand", filtObj);
    updatedObj = addEventToFilters("browser", filtObj);
    updatedObj = addEventToFilters("referrer", filtObj);
    updatedObj = addEventToFilters("operatingSys", filtObj);
    //deal with textbox
    updatedObj = autocompleteCountries("country", filtObj);
    dataRequestFromFilters(filtObj);
}

//Triggered when user makes any changes on any dropdown lists
//replace old value in url with user's new choice in dropdown lists
function addEventToFilters(objType, filtObj) {
    
    $("#"+ objType).on("change","select", function (e) {
        var newType = $("#" + objType + " option:selected").text();
        if (filtObj[objType] == "") {
            filtObj.url = filtObj.url.replace("&" + objType + "=", "&" + objType + "=" + newType);
        }
        else {
            filtObj.url = filtObj.url.replace(filtObj[objType], newType);
        }
        filtObj[objType] = newType;
        
        return filtObj;
    })
} 

//Since this is input textbox, we cannot use the same way as dropdown lists did
//replace old value of country in url with user's new choice from autocomplete suggestions
function addCountryToURL(objType, filtObj, countryValue) {
    if (filtObj[objType] == "") {
        filtObj.url += "&" + objType + "=" + countryValue;
    }
    else {
        filtObj.url = filtObj.url.replace(filtObj[objType], countryValue);
    }
    filtObj[objType] = countryValue;
    
    return filtObj;
}