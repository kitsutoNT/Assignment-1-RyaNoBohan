window.addEventListener("load", init);

var countryName1 = "";
var country1 = [];
var countryName2 = "";
var country2 = [];
var countryName3 = "";
var country3 = [];
var countries = [];
var jan = [];
var may = [];
var sept = [];
var counter = 0;
var checkSwitch = false;

/*
This is the initial function which organized other main functions
*/
function init() 
{
    /*global google*/
    google.charts.load('current', {'packages':["corechart", "gauge", "line", "bar"]});
    displayDefaultAreaChart();
    displayAreaChart();
    displayDefaultGeoChart();
    displayGeoChart();
    outputTop10CountryOption();
    displayColumnChart();
    document.getElementById("chartIt").addEventListener("click", chartIt);
    document.getElementById("switch").addEventListener("click", switchButton);
}


/*
This can draw the area chart, and it needs the parameters to draw.
Parameters: days, visits, month
*/
function drawAreaChart(days, visits, month)
{
  google.charts.setOnLoadCallback(drawChart);
  
  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'day');
    data.addColumn('number', 'visits');
    for(var i = 0; i < days.length; i++)
        data.addRow([days[i], visits[i]]);
    
    var monthString = "";
    if(month == 1)
    {
      monthString = "January";
    }
    else if(month == 2)
    {
      monthString = "February";
    }
    else if(month == 3)
    {
      monthString = "March";
    }
    else if(month == 4)
    {
      monthString = "April";
    }
    else if(month == 5)
    {
      monthString = "May";
    }
    else if(month == 6)
    {
      monthString = "June";
    }
    else if(month == 7)
    {
      monthString = "July";
    }
    else if(month == 8)
    {
      monthString = "August";
    }
    else if(month == 9)
    {
      monthString = "September";
    }
    else if(month == 10)
    {
      monthString = "October";
    }
    else if(month == 11)
    {
      monthString = "November";
    }
    else if(month == 12)
    {
      monthString = "December";
    }

    var options = {
      title: ''+monthString+' Visits',
      hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
}

/*
This can display the default area chart, even the user has not choose the month yet. It just call the drawAreaChart
*/
function displayDefaultAreaChart()
{
  var defaultMonth = "serviceVisitsData.php?table=visits&month=01";
  $.get(defaultMonth, function(data) {
    var count = 1;
    var days = [];
    var visits = [];
    $.each(data, function(key, object) {
        var number = Number(object.numVisits);
        visits.push(number);
        days.push(count);
        count++;
    });
    drawAreaChart(days, visits, 1);
    loadingAnimation($("#areaChartCard .mdl-spinner"));
  })
  .always(function () {
    loadingAnimation($("#areaChartCard .mdl-spinner"));
  });
}

/*
THis can display the area chart which after the user choose any months in 2016. It also need to call the drawAreaChart
*/
function displayAreaChart()
{
  $("#monthDrop1").change(function(){
    var month = this.value;
    var chosenMonth = "serviceVisitsData.php?table=visits&month=" + this.value;
    $.get(chosenMonth, function(data) {
      var count = 1;
      var days = [];
      var visits = [];
      $.each(data, function(key, object) {
          var number = Number(object.numVisits);
          visits.push(number);
          days.push(count);
          count++;
      });
      drawAreaChart(days, visits, month);
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    })
    .always(function () {
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    });
  });
}

/*
This can display the default geo chart when the user has not choose any month in 2016 yet, it needs to call drawGeoChart.
*/
function displayDefaultGeoChart()
{
  var defaultMonth = "serviceVisitsData.php?table=countryVisitsGeoChart&month=01";
  $.get(defaultMonth, function(data) {
    var country = [];
    var visits = [];
    $.each(data, function(key, object) {
        var number = Number(object.numVisits);
        visits.push(number);
        country.push(object.countryName);
    });
    drawGeoChart(country, visits, 01);
    loadingAnimation($("#areaChartCard .mdl-spinner"));
  })
  .always(function () {
    loadingAnimation($("#areaChartCard .mdl-spinner"));
  });
}

/*
This can display the geo chart when the user already choose a month, it needs to call drawGeoChart.
*/
function displayGeoChart()
{
  $("#monthDrop2").change(function(){
    var month = this.value;
    var chosenMonth = "serviceVisitsData.php?table=countryVisitsGeoChart&month=" + this.value;
    $.get(chosenMonth, function(data) {
      var country = [];
      var visits = [];
      $.each(data, function(key, object) {
          var number = Number(object.numVisits);
          visits.push(number);
          country.push(object.countryName);
      });
      drawGeoChart(country, visits, month);
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    })
    .always(function () {
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    });
  });
}

/*
This is main function to draw geo chart, it will support how to use google charts to draw charts, it needs parameters.
Parameters: country, visits, month
*/
function drawGeoChart(country, visits, month)
{
    google.charts.setOnLoadCallback(drawRegionsMap);
    function drawRegionsMap() {
    
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Country');
    data.addColumn('number', 'Visits');
    for(var i = 0; i < visits.length; i++)
        data.addRow([country[i], visits[i]]);
    
    var options = {};
    
    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
    
    chart.draw(data, options);
    }
}

/*
This can display the column chart when the user choose three different counties already. Also, it can switch the charts.
*/
function displayColumnChart()
{
  $("#countryDrop1").change(function(){
    var chosenCountryISO = "serviceVisitsData.php?table=countryVisitsJanMaySept&countryISO=" + this.value;
    $.get(chosenCountryISO, function(data) {
      var countryName = "";
      var visitsJan = "";
      var visitsMay = "";
      var visitsSept = "";
      $.each(data, function(key, object) {
          visitsJan = Number(object.visitsJan);
          visitsMay = Number(object.visitsMay);
          visitsSept = Number(object.visitsSept);
          countryName = object.countryName;
      });
      countryName1 = countryName;
      country1.push(visitsJan);
      country1.push(visitsMay);
      country1.push(visitsSept);
      jan[0] = visitsJan;
      may[0] = visitsMay;
      sept[0] = visitsSept;
      countries[0] = countryName;
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    })
    .always(function () {
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    });
  });
  
  $("#countryDrop2").change(function(){
    var chosenCountryISO = "serviceVisitsData.php?table=countryVisitsJanMaySept&countryISO=" + this.value;
    $.get(chosenCountryISO, function(data) {
      var countryName = "";
      var visitsJan = "";
      var visitsMay = "";
      var visitsSept = "";
      $.each(data, function(key, object) {
          visitsJan = Number(object.visitsJan);
          visitsMay = Number(object.visitsMay);
          visitsSept = Number(object.visitsSept);
          countryName = object.countryName;
      });
      countryName2 = countryName;
      country2.push(visitsJan);
      country2.push(visitsMay);
      country2.push(visitsSept);
      jan[1] = visitsJan;
      may[1] = visitsMay;
      sept[1] = visitsSept;
      countries[1] = countryName;
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    })
    .always(function () {
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    });
  });
  
  $("#countryDrop3").change(function(){
    var chosenCountryISO = "serviceVisitsData.php?table=countryVisitsJanMaySept&countryISO=" + this.value;
    $.get(chosenCountryISO, function(data) {
      var countryName = "";
      var visitsJan = "";
      var visitsMay = "";
      var visitsSept = "";
      $.each(data, function(key, object) {
          visitsJan = Number(object.visitsJan);
          visitsMay = Number(object.visitsMay);
          visitsSept = Number(object.visitsSept);
          countryName = object.countryName;
      });
      countryName3 = countryName;
      country3.push(visitsJan);
      country3.push(visitsMay);
      country3.push(visitsSept);
      jan[2] = visitsJan;
      may[2] = visitsMay;
      sept[2] = visitsSept;
      countries[2] = countryName;
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    })
    .always(function () {
      loadingAnimation($("#areaChartCard .mdl-spinner"));
    });
  });
}

/*
This is a charIt button function, which will check the options are following the rules, and then click the button, and draw the chart.
*/
function chartIt()
{
  if(checkFullOptions() == true)
  {
    drawColumnChart1(countryName1, countryName2, countryName3, country1, country2, country3);
    checkSwitch = true;
  }
  else
  {
    alert("Please choose three unique countries");
    checkSwitch = false;
  }
}

/*
This is a checker which can check the user choosing options are following the rules. User must choose 3 unique countries.
*/
function checkFullOptions()
{
  if(countryName1 == countryName2 || countryName1 == countryName3 || countryName2 == countryName3 || countryName1 == "" || countryName2 == "" || countryName3 == "")
  {
    return false;
  }
  else
  {
    return true;
  }
}

/*
This is a switch button function, which can switch the chart after the chart is already displayed.
*/
function switchButton()
{
  if(checkSwitch == true)
  {
    if(counter%2 == 0)
    {
      drawColumnChart2(countries, jan, may, sept);
      counter++;
    }
    else
    {
      drawColumnChart1(countryName1, countryName2, countryName3, country1, country2, country3);
      counter++;
    }
  }
}

/*
This will connect with database to get the countries name and let them to be the options
*/
function outputTop10CountryOption() {
    var url = "serviceVisitsData.php?table=countryVisitsTop10&countryISO";
    
    $.get(url, function(data) {
        countryTop10DropDownListOptions(data);
    });
}

/*
This will create the drop down list options based on the data
Parameters: data
*/
function countryTop10DropDownListOptions(data) {
    $.each(data, function( key, object) {
        $("#countryDrop1").append($('<option>', {value: object.countryISO, text: object.countryName})); 
    });
    $.each(data, function( key, object) {
        $("#countryDrop2").append($('<option>', {value: object.countryISO, text: object.countryName})); 
    });
    $.each(data, function( key, object) {
        $("#countryDrop3").append($('<option>', {value: object.countryISO, text: object.countryName})); 
    });
}

/*
This function will draw the type 1 column chart
Parameters: countryName1, countryName2, countryName3, country1, country2, country3
*/
function drawColumnChart1(countryName1, countryName2, countryName3, country1, country2, country3)
{
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = new google.visualization.DataTable();
      
      var year = ['Jan', 'May', 'Sept'];
      
      data.addColumn('string', 'Year');
      data.addColumn('number', countryName1);
      data.addColumn('number', countryName2);
      data.addColumn('number', countryName3);

      for(var i = 0; i < 3; i++)
          data.addRow([year[i], country1[i], country2[i], country3[i]]);
      
      var options = {
        chart: {
          title: 'Site Visits',
          subtitle: '2016',
        }
      };
      
      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
      
      chart.draw(data, options);
    }
}

/*
This function will draw the type 2 column chart
Parameters: countryName1, countryName2, countryName3, country1, country2, country3
*/
function drawColumnChart2(countries, jan, may, sept)
{
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Country');
    data.addColumn('number', 'Jan');
    data.addColumn('number', 'May');
    data.addColumn('number', 'Sept');
    for(var i = 0; i < 3; i++)
        data.addRow([countries[i], jan[i], may[i], sept[i]]);

    var options = {
        chart: {
            title: 'Site Visits',
            subtitle: '2016',
        }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, options);
}

/*
This is the loading animation funtion which can support a loading animation affect during the loading time
*/
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