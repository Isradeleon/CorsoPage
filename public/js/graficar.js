$(document).ready(function(){
    $("#Boton2").click(function(){

        $.ajax({
            url:"/Estadisticas",
            type:"POST",
            datatype:"json",
            data:{
            }

        }).done(function(response){
            console.log(response);  //se pone arreglo y se accede el del numero
            
            chart = new Highcharts.Chart({
                chart: {
                     renderTo: 'containeer2',
                     type: 'bar'
        },
        title: {
            text: 'Canciones'
        },
        xAxis: {
            categories: response.canciones
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Reporte'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Favoritos',
            data: response.numeros
        }]
            });

        });
    });
});
