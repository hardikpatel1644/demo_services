(function($) {
    $( document ).ready(function() {
    $('.jvectormap-field').each(function() {
        var $this = $(this);

        // Get regions fields
        var $fields = $this.nextAll('.jvectormap-regions');

        // Get select buttons
        var $btnSelectedAll = $this.prev('.jvectormap-buttons').find('.jvectormap-selectall');
        var $btnClearAll = $this.prev('.jvectormap-buttons').find('.jvectormap-unselectall');
        
        // Get hidden fields
        var $codes = $this.prevAll('input[type=hidden][name$="[codes]"]');
        var $regions = $this.prevAll('input[type=hidden][name$="[regions]"]');

        // Display map
        $this.vectorMap({
            map: $this.data('map'),
            regionsSelectable: !!$this.data('regions-selectable'),
            zoomOnScroll: !!$this.data('zoom-on-scroll'),
            zoomButtons: !!$this.data('zoom-buttons'),
            backgroundColor: $this.data('background-color'),
            regionStyle: {
                initial: $this.data('region-style-initial'),
                hover: $this.data('region-style-hover'),
                selected: $this.data('region-style-selected'),
                selectedHover: $this.data('region-style-selected-hover')
            },
            onRegionSelected: function(e, code, isSelected, selectedRegions) {
                var arrRegionsName = new Array();
                var arrLen = selectedRegions.length;
                var map = $this.vectorMap("get", "mapObject");
                for(var i = 0; i < arrLen; i++) {
                    arrRegionsName.push(map.getRegionName(selectedRegions[i]));
                }
                var selRegionsNames = arrRegionsName.join();
                var selRegionsCode = selectedRegions.join();

                // Set hidden field
                $regions.attr("value", selRegionsNames);
                $codes.attr("value", selRegionsCode);

                // Display region label
                if(isSelected)
                    $('.jvectormap-region-'+code, $fields).removeClass('unselected');
                else
                    $('.jvectormap-region-'+code, $fields).addClass('unselected');
            }
        });

        var mapObject = $this.vectorMap('get', 'mapObject');

        // Display fields
        var regionsCount = $.map(mapObject.regions, function(n, i) { return i; }).length;
        var maxColumn = 3;
        var regionsByColumn = Math.ceil(regionsCount / maxColumn);
        var currentColumn = 1;
        var i = 0;
        for(var regionKey in mapObject.regions) {
            var region = mapObject.regions[regionKey];

            var $label = $('<p />')
                .text(region.config.name)
                .addClass('jvectormap-region jvectormap-region-'+regionKey+' unselected');

            $('.jvectormap-regions-'+currentColumn, $fields).append($label);

            i++;
            if(i % regionsByColumn == 0) {
                i = 0;
                currentColumn++;
            }
        }
        
        // buttons for Selecting and Deselecting.
        $btnSelectedAll.click(function(){
            mapObject.setSelectedRegions(mapObject.regions);
            return false;
        });
        
        $btnClearAll.click(function(){
            mapObject.clearSelectedRegions();
            return false;
        });
        
        // Selec regions
        mapObject.setSelectedRegions($codes.val().split(','));
    });
})
})
(jQuery);