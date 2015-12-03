/******************************************************/
/*    Funciones para manejo de datos de Graficas      */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    $("label[for=comercio-id]").css("display", "none");
    obtenerProductosMasVendidosComecio();

});


    $('#comercio-id').change(function(){
        var id = $('#comercio-id').val();

        $.ajax({
            method: "POST",
            url: rootURL + "/grafica/grafica-barras",
            dataType: "json",
            data: { id_comercio : id }
        }).done(function(data){

            console.log(data);
            dibujarGraficaBarras(data.length == 0 ? null : data);

        }).fail(function(){
            $.magnificPopup.open({
                items: {
                  src: '<div class="box box-warning white-popup"><h3>Ocurrio un error al obtener datos de graficas.</h3></div>',
                  type: 'inline'
                }
            });
        });

    });

function obtenerProductosMasVendidosComecio(){

    if($('#comercio-id').val() == 0){
        dibujarGraficaBarras(null);
        $.magnificPopup.open({
            items: {
              src: '<div class="box box-warning white-popup"><h3>Seleccione un comercio, para sacar sus estadisticas...</h3></div>',
              type: 'inline'
            }
        });
    }

}

function acotarNombreProductosGraficaBarras(data){

    var eje = [];

    if(data == null){
        return eje = ["No hay datos para graficar..."];
    }

    for(var i = 0; i < data.length; i++){
        if(data[i].nombre.length > 20){
            data[i].nombre = data[i].nombre.substr(0, 20);
            data[i].nombre.concat("...");
        }
        eje.push(data[i].nombre);
    }
    return eje;
}

function productosEjeYGraficaBarras(data){

    var eje = [];

    if(data == null){
        return eje = ["No hay datos para graficar..."];
    }

    for(var i = 0; i < data.length; i++){
        eje.push(data[i].id_producto);
    }
    return eje;
}

function cantidadesEjeYGraficaBarras(data){

    var eje = [];

    if(data == null){
        return eje = [0];
    }

    for(var i = 0; i < data.length; i++){
        eje.push(data[i].ventas);
    }
    return eje;
}

//-------------
//- BAR CHART -
//-------------
function dibujarGraficaBarras(data){
    var areaChartData = {
      labels: acotarNombreProductosGraficaBarras(data),
      datasets: [
        {
          fillColor: "#009933",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: cantidadesEjeYGraficaBarras(data)
        }
      ]
    };

    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].nomProductos){%><%=datasets[i].nomProductos%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: false
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

}
