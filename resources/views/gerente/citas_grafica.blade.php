@extends('menu_layouts.menu_base')

@section('menus')
  @include('gerente.menusgerente')
@endsection

@section('content')
<h2>Estadísticas de citas</h2>
<hr>
<div class="col-xs-12">
  <div class="col-md-7">
    <div id="pieChartMonth" style="width:100%; max-height:400px; margin: 0 auto"></div>
  </div>
  <div class="col-md-5">
    <div id="pieChartYear" style="width:100%; max-height:400px; margin: 0 auto"></div>
  </div>
</div>
@endsection

@section("the_js")
<script type="text/javascript" src="public/js/highcharts.js"></script>

<script type="text/javascript">
//GRAFICA DEL MES
$(document).ready(function(){
  $.ajax({
      url:"/citas_gyear",
      type:"post",
      data:{
          _token:"{{csrf_token()}}"
      }
  }).done(function(res){
    console.log(res);
    var brands=[];
    if (res[1]) {
      brands[0]={name:"Inconclusas",
      y:Number(res[1].length)};
    }else{
      brands[0]={name:"Inconclusas",
      y:0};
    }
    if (res[2]) {
      brands[1]={name:"Exitosas",
      y:Number(res[2].length)};
    }else{
      brands[1]={name:"Exitosas",
      y:0};
    }
    if (res[3]) {
      brands[2]={name:"Canceladas",
      y:Number(res[3].length)};
    }else{
      brands[2]={name:"Canceladas",
      y:0};
    }
    var chart = new Highcharts.Chart({
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
        renderTo: 'pieChartYear'
      },
      credits: {
        enabled: false
      },
      title: {
        text: '<span style="font-size:20px;">Citas de este año.</span>'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<span style="font-size:13px;">{point.name}: {point.percentage:.1f} %</span>',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
          }
        }
      },
      colors: ["#ddd","#5CB85C","#D9534F"],
      series: [{
        name: 'Citas',
        colorByPoint: true,
        data: brands
      }]
    });

  });
});
</script>

<script type="text/javascript">
//GRAFICA DEL MES
$(document).ready(function(){
  $.ajax({
      url:"/citas_g",
      type:"post",
      data:{
          _token:"{{csrf_token()}}"
      }
  }).done(function(res){
    console.log(res);
    var brands=[];
    if (res[1]) {
      brands[0]={name:"Inconclusas",
      y:Number(res[1].length)};
    }else{
      brands[0]={name:"Inconclusas",
      y:0};
    }
    if (res[2]) {
      brands[1]={name:"Exitosas",
      y:Number(res[2].length)};
    }else{
      brands[1]={name:"Exitosas",
      y:0};
    }
    if (res[3]) {
      brands[2]={name:"Canceladas",
      y:Number(res[3].length)};
    }else{
      brands[2]={name:"Canceladas",
      y:0};
    }
    var chart = new Highcharts.Chart({
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
        renderTo: 'pieChartMonth'
      },
      credits: {
        enabled: false
      },
      colors: ["#ddd","#5CB85C","#D9534F"],
      title: {
        text: '<span style="font-size:20px;">Citas de este mes.</span>'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<span style="font-size:13px;">{point.name}: {point.percentage:.1f} %</span>',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
          }
        }
      },
      series: [{
        name: 'Citas',
        colorByPoint: true,
        data: brands
      }]
    });

  });
});
</script>
@endsection
