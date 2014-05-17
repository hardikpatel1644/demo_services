(function($) {
    // Datatable
    $('#purchaser-order-list').dataTable({
        "bProcessing": true,
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "full_numbers"
    });

    // Tanks
    $('#purchaser-tank .progress-bar').progressbar({
        display_text: 'center',
        use_percentage: false,
        amount_format: function(p, t) {
            return p + ' / ' + t + 'm³';
        }
    });

    // Chart updater
    function updateChart($chart, series, xMin, xMax, yMin, yMax) {
        // Set new datas
        var data = $chart.getData();
        data[0].data = series;
        $chart.setData(data);

        // Set axis limits
        var options = $chart.getOptions();
        options.xaxes[0].min = xMin;
        options.xaxes[0].max = xMax;
        options.yaxes[0].min = yMin;
        options.yaxes[0].max = yMax;

        // Update chart axes
        $chart.setupGrid();

        // Draw chart
        $chart.draw();
    }

    // Charts tabs
    var tabsLoaded = 0, maxTabsLoaded = 0;
    var $chartTabs = $('#purchaser-chart a[data-toggle="tab"]');
    $chartTabs.on('show.bs.tab', function() {
        return (tabsLoaded == maxTabsLoaded);
    });
    $chartTabs.on('shown.bs.tab', function(e) {
        var $target = $(e.target);

        // Unselect all tabs
        $chartTabs.removeClass('dk');

        // Select current target
        $target.addClass('dk');

        // Display/Update chart
        var $chart = $($target.attr('href') + '-chart');
        var $plot = $chart.data('plot');
        if($plot) {
            updateChart(
                $plot,
                $chart.data('series'),
                $chart.data('xmin'),
                $chart.data('xmax'),
                $chart.data('ymin'),
                $chart.data('ymax')
            );
        } else {
            $.plot($chart, [{data: $chart.data('series') }],
                {
                    canvas: true,
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2,
                            fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.3
                                }, {
                                    opacity: 0.8
                                }]
                            }
                        },
                        points: {
                            radius: 3,
                            show: true
                        },
                        grow: {
                            active: true,
                            steps: 50
                        },
                        shadowSize: 1
                    },
                    grid: {
                        hoverable: true,
                        clickable: false,
                        tickColor: "#f0f0f0",
                        borderWidth: 1,
                        color: '#f0f0f0'
                    },
                    colors: ["#65bd77"],
                    xaxis: {
                        show: false,
                        mode: 'time',
                        minTickSize: [1, 'hour'],
                        timezone: 'browser',
                        timeformat: "%d/%m/%Y à %H:%M:%S UTC",
                        min: $chart.data('xmin'),
                        max: $chart.data('xmax')
                    },
                    yaxis: {
                        ticks: 10,
                        min: $chart.data('ymin'),
                        max: $chart.data('ymax')
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%y$ le %x",
                        defaultTheme: false,
                        shifts: {
                            x: 0,
                            y: 20
                        }
                    }
                }
            );
        }
    });
    function updateTabs() {
        tabsLoaded++;

        // Display home tab, if all tabs are loaded
        if(tabsLoaded == maxTabsLoaded)
            $('#purchaser-tab-home').tab('show');
    }

    // Charts
    $("#purchaser-brent-chart, #purchaser-lgo-chart, #purchaser-eur-usd-chart").each(function() {
        var $this = $(this);

        // Increase max tabs
        maxTabsLoaded++;

        // Prepare AJAX
        var firstLoad = true;
        var url = $this.data('url');
        var $tab = $('#' + $this.attr('id') + '-value');
        var updateInterval = 10 * 60 * 1000; // 10 min
        var oneDay = 1000 * 60 * 60 * 24; // one day in millisecond
        function update() {
            function onDataReceived(series) {
                // Increase loaded tabs
                if(firstLoad) {
                    firstLoad = false;
                    updateTabs();
                }

                // Calculate axes limits
                var yDiff = series.maximum - series.minimum;
                var yMargin = 100000, yNextMargin;
                if(yDiff > 0) {
                    do {
                        yMargin /= 10;
                        yNextMargin = yMargin / 10;
                    } while( !(yMargin >= yDiff && yNextMargin < yDiff) );
                } else {
                    yNextMargin = 0.01;
                }
                
                var yMin = series.minimum - yNextMargin;
                var yMax = series.maximum + yNextMargin;

                // Calculate xaxis limits
                var xMax = new Date();
                var xMin = new Date(xMax.getTime() - oneDay);
                xMax.setHours(22, 59, 59);
                xMin.setHours(0, 0, 0, 1);

                // Get jQuery flot
                var $chart = $this.data('plot');
                if($chart) {
                    updateChart(
                        $chart,
                        series.data,
                        xMin.getTime(),
                        xMax.getTime(),
                        yMin,
                        yMax
                    );
                } else {
                    $this.data('series', series.data);
                    $this.data('xmin', xMin.getTime());
                    $this.data('xmax', xMax.getTime());
                    $this.data('ymin', yMin);
                    $this.data('ymax', yMax);
                }
                
                // Update tab label
                if(series.data.length > 0)
                    $tab.text(series.data[series.data.length - 1][1] + '$');
                
                // Relaunch timer
                setTimeout(update, updateInterval);
            }
            
            // Launch Ajax request
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: onDataReceived
            });
        }
        update();
    });
})(window.jQuery);