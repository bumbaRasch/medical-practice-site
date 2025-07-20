<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Practice Location Configuration
    |--------------------------------------------------------------------------
    |
    | Define the primary location of the medical practice for map centering
    | and reference point for nearby transportation markers.
    |
    */
    
    'practice_location' => [
        'latitude' => 52.5200, // Berlin coordinates as example - update with actual practice location
        'longitude' => 13.4050,
        'name' => 'messages.common.practice_name',
        'address' => 'messages.common.address',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Public Transportation Markers
    |--------------------------------------------------------------------------
    |
    | Define nearby public transportation stations, bus stops, and other
    | relevant transportation options for patients visiting the practice.
    | All text supports full localization via translation keys.
    |
    */
    
    'transportation_markers' => [
        // U-Bahn/Subway Stations
        [
            'type' => 'subway',
            'latitude' => 52.5210,
            'longitude' => 13.4070,
            'name' => 'messages.transportation.subway.potsdamer_platz.name',
            'description' => 'messages.transportation.subway.potsdamer_platz.description',
            'lines' => ['U2', 'S1', 'S2', 'S25'],
            'walking_time' => 'messages.transportation.walking_time.5_min',
            'accessibility' => true,
        ],
        [
            'type' => 'subway',
            'latitude' => 52.5190,
            'longitude' => 13.4030,
            'name' => 'messages.transportation.subway.brandenburger_tor.name',
            'description' => 'messages.transportation.subway.brandenburger_tor.description',
            'lines' => ['S1', 'S2', 'S25'],
            'walking_time' => 'messages.transportation.walking_time.7_min',
            'accessibility' => true,
        ],
        
        // Bus Stops
        [
            'type' => 'bus',
            'latitude' => 52.5195,
            'longitude' => 13.4045,
            'name' => 'messages.transportation.bus.unter_den_linden.name',
            'description' => 'messages.transportation.bus.unter_den_linden.description',
            'lines' => ['100', '200', 'TXL'],
            'walking_time' => 'messages.transportation.walking_time.3_min',
            'accessibility' => true,
        ],
        [
            'type' => 'bus',
            'latitude' => 52.5180,
            'longitude' => 13.4060,
            'name' => 'messages.transportation.bus.wilhelmstrasse.name',
            'description' => 'messages.transportation.bus.wilhelmstrasse.description',
            'lines' => ['M41', '300'],
            'walking_time' => 'messages.transportation.walking_time.4_min',
            'accessibility' => false,
        ],
        
        // Tram Stops
        [
            'type' => 'tram',
            'latitude' => 52.5205,
            'longitude' => 13.4055,
            'name' => 'messages.transportation.tram.friedrichstrasse.name',
            'description' => 'messages.transportation.tram.friedrichstrasse.description',
            'lines' => ['M1', 'M12'],
            'walking_time' => 'messages.transportation.walking_time.6_min',
            'accessibility' => true,
        ],
        
        // Parking Options
        [
            'type' => 'parking',
            'latitude' => 52.5188,
            'longitude' => 13.4040,
            'name' => 'messages.transportation.parking.potsdamer_platz_arkaden.name',
            'description' => 'messages.transportation.parking.potsdamer_platz_arkaden.description',
            'capacity' => 800,
            'walking_time' => 'messages.transportation.walking_time.5_min',
            'hourly_rate' => '2.50€',
            'accessibility' => true,
        ],
        [
            'type' => 'parking',
            'latitude' => 52.5215,
            'longitude' => 13.4065,
            'name' => 'messages.transportation.parking.street_parking.name',
            'description' => 'messages.transportation.parking.street_parking.description',
            'capacity' => null,
            'walking_time' => 'messages.transportation.walking_time.2_min',
            'hourly_rate' => '2.00€',
            'accessibility' => false,
        ],
        
        // Bike Sharing Stations
        [
            'type' => 'bike',
            'latitude' => 52.5198,
            'longitude' => 13.4048,
            'name' => 'messages.transportation.bike.nextbike_station_1.name',
            'description' => 'messages.transportation.bike.nextbike_station_1.description',
            'bikes_available' => null, // Dynamic data would come from API
            'walking_time' => 'messages.transportation.walking_time.1_min',
            'accessibility' => true,
        ],
        [
            'type' => 'bike',
            'latitude' => 52.5192,
            'longitude' => 13.4052,
            'name' => 'messages.transportation.bike.lidl_bike_station.name',
            'description' => 'messages.transportation.bike.lidl_bike_station.description',
            'bikes_available' => null,
            'walking_time' => 'messages.transportation.walking_time.3_min',
            'accessibility' => true,
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Map Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the Leaflet.js map display, including
    | zoom levels, tile layers, and marker styling preferences.
    |
    */
    
    'map_config' => [
        'default_zoom' => 15,
        'min_zoom' => 12,
        'max_zoom' => 18,
        'tile_layer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'tile_attribution' => '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        'marker_cluster' => true,
        'show_scale' => true,
        'show_zoom_control' => true,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Marker Icons Configuration
    |--------------------------------------------------------------------------
    |
    | Define custom icons for different transportation types to provide
    | clear visual distinction on the map.
    |
    */
    
    'marker_icons' => [
        'practice' => [
            'icon_url' => '/images/icons/medical-cross.svg',
            'icon_size' => [32, 32],
            'icon_anchor' => [16, 32],
            'popup_anchor' => [0, -32],
            'shadow_url' => '/images/icons/marker-shadow.png',
            'shadow_size' => [41, 41],
            'shadow_anchor' => [13, 41],
        ],
        'subway' => [
            'icon_url' => '/images/icons/subway.svg',
            'icon_size' => [24, 24],
            'icon_anchor' => [12, 24],
            'popup_anchor' => [0, -24],
        ],
        'bus' => [
            'icon_url' => '/images/icons/bus.svg',
            'icon_size' => [24, 24],
            'icon_anchor' => [12, 24],
            'popup_anchor' => [0, -24],
        ],
        'tram' => [
            'icon_url' => '/images/icons/tram.svg',
            'icon_size' => [24, 24],
            'icon_anchor' => [12, 24],
            'popup_anchor' => [0, -24],
        ],
        'parking' => [
            'icon_url' => '/images/icons/parking.svg',
            'icon_size' => [24, 24],
            'icon_anchor' => [12, 24],
            'popup_anchor' => [0, -24],
        ],
        'bike' => [
            'icon_url' => '/images/icons/bike.svg',
            'icon_size' => [24, 24],
            'icon_anchor' => [12, 24],
            'popup_anchor' => [0, -24],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Accessibility Features
    |--------------------------------------------------------------------------
    |
    | Configuration for map accessibility features to ensure WCAG compliance
    | and provide alternative access methods for users with disabilities.
    |
    */
    
    'accessibility' => [
        'keyboard_navigation' => true,
        'high_contrast_mode' => false,
        'screen_reader_descriptions' => true,
        'alternative_text_view' => true,
        'focus_indicators' => true,
        'tab_order_support' => true,
    ],
];