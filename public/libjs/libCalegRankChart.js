$(document).ready(function() {
	
    chartCalegRank = new Chart(document.getElementById("chart"), {
               type: 'bar',
               data: {
                // labels: ["17-25", "26-35", "36-45", "46-55", "56-65",">65"],
                 label : [],
                 datasets: [
                   {
                     label: "Anggota",
                     //backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45870"],
                     //data: [50,35,60,25,35,30],
                       data: [],
                       borderColor:  'rgb(54, 162, 235)',
                     backgroundColor: 'rgba(54, 162, 235,0.1)',
                     borderWidth: 2,
                     borderRadius: 5
                   }
                   
                 ]
               },
               options: {
                 legend: { display: false },
                 title: {
                   display: true,
                   text: 'Ranking Jumlah Anggota Relawan'
                 },
                 indexAxis: 'y',
                 plugins:{
                     datalabels:{
                         anchor:'end',
                         align:'end',
                         labels:{
                             value:{
                                 color:'white'
                             }
                         }
                     }
                 }
               }
           });
            ajax_CalegRankChart(chartCalegRank);
   
   
   
   
   });
   
   
   
   
   
    function ajax_CalegRankChart(chart, data) {
              let url = currentClass+'/chart_caleg_rank' ;
             $.getJSON(url, data).done(function(response) {
                   if (response.status) {
                       chart.options.title.text = response.title;
                       chart.data.labels = response.labels;
                       chart.data.datasets[0].data = response.data.jumlah;
                          
                       chart.update(); // finally update our chart
                       $("#lastUpdate").html(response.lastUpdate);
                   }
                   
                   
   
               });
           }
   