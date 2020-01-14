$(document).ready(function() {
  var summary_prak = [];
  var detprakoff = [];
  var cujian1 = $('#donut-cujian1')[0].getContext('2d');
  var no = window.location.pathname.substring(window.location.pathname.lastIndexOf('/')+1);
  var cujian2 = $('#donut-cujian2')[0].getContext('2d');
  // let bujian1 = $('#bars-ujian1')[0].getContext('2d');
  // document.title = ".:Virtual Lab Teknik Mesin:.";
  WebFont.load({
    google: {
      families: ['Roboto Slab', 'serif']
    }
  });
  Chart.pluginService.register({
    beforeDraw: function (chart) {
      let width = chart.chart.width,
          height = chart.chart.height,
          ctx = chart.chart.ctx;
      ctx.restore();
      
      if (chart.config.type == 'doughnut') {
        let fontSize = (height / 80).toFixed(2);
        ctx.font = fontSize + "em 'Roboto Slab'";
        ctx.fillStyle = chart.config.options.elements.center.color || '#000';
        ctx.textBaseline = "middle";
        ctx.textAlign = "center";

        let text = chart.config.options.elements.center.text,
            textX = Math.round(width / 2),
            textY = height/2.10;

        ctx.fillText(text[1], textX, textY);
        ctx.font = (fontSize/3) + "em sans-serif";
        ctx.fillStyle = '#474747';
        ctx.textBaseline = "middle";
        ctx.textAlign = "center";
        ctx.fillText(text[0], textX, textY+(textY/4.5));
        ctx.save();
      }
    }
  });
  function configDonut(dt, judul) {
    return {
      type: 'doughnut',
      data: {
        labels: [
          "Sudah mengerjakan"
        ],
        datasets: [{
          data: dt,
          backgroundColor: ['#1B2B6F']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        elements: {
          center: {
            text: ['complete',dt[0]+'%'],
            fontStyle: 'Arial'
          }
        },
        cutoutPercentage: 90,
        legend: {
          display: true,
          position: 'bottom',
        },
        title: {
          display: true,
          text: judul
        }
      }
    };
  }

  function overview(){
    let dtdonutujian1 = [summary_prak['ujian1'].jml_mhs_taken, summary_prak['ujian1'].jml_mhs-summary_prak['ujian1'].jml_mhs_taken ];
    let dtdonutujian2 = [summary_prak['ujian2'].jml_mhs_taken, summary_prak['ujian2'].jml_mhs-summary_prak['ujian2'].jml_mhs_taken ];
    let donutujian1 = new Chart(cujian1, configDonut(dtdonutujian1, 'Pengerjaan'));
    let donutKKM = new Chart(cujian2, configDonut(dtdonutujian2, 'Pengerjaan'));
  }

  function create_table_det(dt_det) {
    let wrap = null;
    let body = null;
    wrap = "<div class='table-responsive'>"
    body = "<table class='table table-hover' id='tbdet_prakoff'>";
    body += "<thead>";
    body += "<tr>";
    body += "<th>#</th>";
    body += "<th>Nama Mahasiswa</th>";
    body += "<th>User</th>";
    body += "<th>Nilai</th>";
    body += "</tr>";
    body += "</thead>";
    body += "<tbody>";
    dt_det.forEach(function(dt, i){
      let trcolor = dt.iddet? (dt.nilai? (dt.nilai >= 80? "limegreen" : "tomato") : "lightsteelblue" ) : "";
      body += "<tr class='det-off' data-href='"+window.location.origin+ "/penilaian/periksa/" +dt.iddet+"' style='background-color:"+trcolor+"'>";
      body += "<td></td>";
      body += "<td>"+dt.nama+"</td>";
      body += "<td>"+dt.username+"</td>";
      body += "<td>"+(dt.nilai ? dt.nilai : "")+"</td>";
      body += "</tr>";
    });
    body += "</tbody>";
    body += "</table></div>";
    $mcontextPrakoff.innerHTML = body;

    let tbdet_prakoff = $('#tbdet_prakoff').DataTable({
      "searching": false,
      "columnDefs": [ {
          "searchable": false,
          "orderable": false,
          "targets": 0
      } ],
      "order": [[ 3, 'desc' ]]
    });
    tbdet_prakoff.on( 'order.dt search.dt', function () {
        tbdet_prakoff.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $(".det-off").click(function() {
    window.document.location = $(this).data("href");
  });
  }

  $mcontextPrakoff = document.getElementById('prakoff-context');
  let tunmarked = $('#unmarked').DataTable({
    "columnDefs": [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
    } ],
    "order": [[ 1, 'asc' ]]
  });
  tunmarked.on( 'order.dt search.dt', function () {
      tunmarked.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();
  let tmarked = $('#marked').DataTable({
    "columnDefs": [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
    } ],
    "order": [[ 1, 'asc' ]]
  });
  tmarked.on( 'order.dt search.dt', function () {
      tmarked.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();
  let tunmarked2 = $('#unmarked2').DataTable({
    "columnDefs": [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
    } ],
    "order": [[ 1, 'asc' ]]
  });
  tunmarked2.on( 'order.dt search.dt', function () {
      tunmarked2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();
  let tmarked2 = $('#marked2').DataTable({
    "columnDefs": [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
    } ],
    "order": [[ 1, 'asc' ]]
  });
  tmarked2.on( 'order.dt search.dt', function () {
      tmarked2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();
  $(".det-soal").click(function() {
    window.document.location = $(this).data("href");
  });
  $(".prodet").click(function(){
    let $modal_title = document.getElementById('mtitle');
    $modal_title.innerHTML = "Tabel Detail Praktikum "+no+ " Offering "+$(this).attr('name-off');
    console.log($(this).attr('name-off'));
    $.get(window.location.origin + '/penilaian/detailoff/' + $(this).data('off')).done(function(dt){
      create_table_det(dt);
    });
  });

  $.when(
    $.get(window.location.origin + '/penilaian/summary/' + no)
  ).done(function(dt1){
    summary_prak['ujian1'] = dt1['ujian1'];
    summary_prak['ujian2'] = dt1['ujian2'];
  }).then(function(){
    overview();
  });
});