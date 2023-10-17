{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    {{-- Chart Library --}}
    <script src="/js/chart.js"></script>

    <div class="page-content">
        {{-- Put page content here --}}
        <div class="p-5 w-75">
            <h3>Fire Incidents 2023</h3>
            <hr>
            <canvas id="myChart" style="width:100%; height:300px;"></canvas>
        </div>
    </div>



    {{-- Chart Script --}}
    <script>
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ];

        // put the fire incindents each month in array
        var fireIncidents = [0, 8, 8, 9, 9, 9, 16, 11, 14, 14, 15, 19];

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "gray",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: fireIncidents
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 100
                        }
                    }],
                }
            }
        });
    </script>
@endsection
