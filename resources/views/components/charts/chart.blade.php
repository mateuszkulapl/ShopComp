@props(['products','group'])
<div class="w-full h-96 mb-8">
    <div id="chart{{$group->ean}}" class="w-full"></div>
</div>

<script>

var options = {
    chart: {
        type: 'line',
        stacked: false,
        background: '#1e293b',
        height: '100%',
        locales: [
            {
                "name": "pl",
                "options": {
                    "months": ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"
                    ],
                    "shortMonths": ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"
                    ],
                    "days": ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"
                    ],
                    "shortDays": ["Nd", "Pn", "Wt", "Śr", "Cz", "Pt", "Sb"],
                    "toolbar": {
                        "exportToSVG": "Pobierz SVG", "exportToPNG": "Pobierz PNG", "exportToCSV": "Pobierz CSV", "menu": "Menu", "selection": "Wybieranie", "selectionZoom": "Zoom: Wybieranie", "zoomIn": "Przybliż", "zoomOut": "Oddal", "pan": "Przesuwanie", "reset": "Resetuj"
                    }
                }
            }
        ],
        defaultLocale: "pl",
        toolbar: {
        show: true,
        offsetX: 0,
        offsetY: 0,
        tools: {
          download: true,
          selection: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
          pan: true,
          reset: true,
          customIcons: []
        },
        export: {
          svg: {
            filename: @json($group->ean)+@json('_'.\Carbon\Carbon::now()->format('Y-m-d_h:i')),
          },
          png: {
            filename: @json($group->ean)+@json('_'.\Carbon\Carbon::now()->format('Y-m-d_h:i')),
          }
        },
        autoSelected: 'zoom' 
      },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'stepline',
    },
    markers: {
        size: 1,
    },
    tooltip: {
        enabled: true,
        shared: false,
        followCursor: true,

        custom: ({ series, seriesIndex, dataPointIndex, w }) => {
        const hoverXValue=w.globals.seriesX[seriesIndex][dataPointIndex];
        let html='';
        const includesHoverXValue=(element)=>element==hoverXValue;
        const hoverXIndexes = w.globals.seriesX.map(seriesX => {
            return seriesX.findIndex(includesHoverXValue);
        });
        html=hoverXIndexes.map((xIndex,seriesIndex) => {
            let value;
            if(xIndex!==-1)
            value=w.globals.yLabelFormatters[0](series[seriesIndex][xIndex]);
            else
            value="-";

            return `<div class="apexcharts-tooltip-series-group apexcharts-active" style="order: ${seriesIndex}; display: flex;">
                <span class="apexcharts-tooltip-marker" style="background-color: ${w.globals.colors[seriesIndex]};"></span>
                <div class="apexcharts-tooltip-text" style="flex:1">
                    <div class="apexcharts-tooltip-y-group">
                        <span class="apexcharts-tooltip-text-y-label">${w.globals.seriesNames[seriesIndex]}</span>
                        <span class="apexcharts-tooltip-text-y-value" style="float:right; margin-left:8px;">${value}</span>
                    </div>
                </div>
            </div>`;
        });
        return `<div class="apexcharts-tooltip-title">${w.globals.xLabelFormatter(hoverXValue)}</div>` + html.join('');
        },
    },
    xaxis: {
        type: 'datetime',
        labels: {
            formatter: function (timestamp) {
                return new Date(timestamp).toLocaleDateString();
            },
            datetimeFormatter: {
                year: 'yyyy',
                month: 'MMM \'yy',
                day: 'dd MM yyyy',
                hour: 'HH:mm'
            }
        }
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                if(typeof value ==='number')
                return value.toLocaleString(undefined,{style:"currency",currency:'PLN'});
                else
                return value;
            }
        },
    },
    theme: {
        mode: 'dark',
        palette: 'palette1',
        monochrome: {
            enabled: false,
            color: '#255aee',
            shadeTo: 'light',
            shadeIntensity: 0.65
        },
    },
    title: {
        text: 'Cena '+@json($products->first()->title),
        align: 'center',
        margin: 0,
        offsetX: 0,
        offsetY: 0,
        floating: true,
        style: {
        fontSize:  '16px',
        fontWeight:  'bold',
        color:  '#fff'
        },
    },
    // annotations: {
    //     xaxis: [
    //         {
    //         x: 1643670000000,
    //         color: '#fff',
    //         borderColor:'#fff',

    //         label: {
    //             style: {
    //             color: '#fff',
    //             background:'#0f172a',
    //             borderColor:'#fff'
    //             },
    //             text: 'Tarcza antyinflacyjna',
    //             orientation:'horizontal'
    //         }
    //         }
    //     ]
    // },
    series: [

        @foreach ($products as $product)
        {
        name: @json($product->shop->name),
        data: {{$product->getChartPrices()}}
        },
        @endforeach

    ]

}

var chart{{$group->ean}} = new ApexCharts(document.querySelector("#chart{{$group->ean}}"), options);

chart{{$group->ean}}.render();


</script>
