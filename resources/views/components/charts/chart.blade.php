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
        enabled: false
    },
    stroke: {
        curve: 'stepline',
    },
    markers: {
        size: 1,
    },
    tooltip: {
        enabled: true,
        enabledOnSeries: undefined,
        shared: true,
        followCursor: false,
    },
    xaxis: {
        type: 'datetime'
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
    floating: false,
    style: {
      fontSize:  '16px',
      fontWeight:  'bold',
      color:  '#fff'
    },
    },
    series: [
        @foreach ($products as $product)
        {
        name: @json($product->shop->name),
        data: [
            @foreach ($product->prices as $price)
                {{ $price->getXYPair() }},
            @endforeach
        ]
        },
        @endforeach
    ]
}

var chart{{$group->ean}} = new ApexCharts(document.querySelector("#chart{{$group->ean}}"), options);

chart{{$group->ean}}.render();


</script>
