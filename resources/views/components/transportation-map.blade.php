{{--
Transportation Map Component
Displays an interactive Leaflet.js map with practice location and nearby public transportation markers
Includes full localization support and accessibility features
--}}

<section class="py-16 bg-gradient-to-br from-gentle-blue via-medical-light-blue to-warm-gray-25">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Map Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-6 py-3 bg-white bg-opacity-95 rounded-full text-sm font-medium text-trust-blue mb-6 shadow-card backdrop-blur-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                {{ __('messages.transportation.map_title') }}
            </div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-warm-gray-800 mb-4">
                {{ __('messages.transportation.map_title') }}
            </h2>
            <p class="text-xl text-warm-gray-600 max-w-3xl mx-auto">
                {{ __('messages.transportation.map_description') }}
            </p>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-3xl shadow-card border border-white border-opacity-70 backdrop-blur-sm overflow-hidden">
            <!-- Map Loading State -->
            <div id="map-loading" class="h-96 flex items-center justify-center bg-medical-light-blue" role="status" aria-live="polite">
                <div class="text-center">
                    <div class="inline-block w-8 h-8 border-4 border-medical-blue border-t-transparent rounded-full animate-spin mb-3" aria-hidden="true"></div>
                    <p class="text-warm-gray-700 font-medium">{{ __('messages.transportation.loading') }}</p>
                </div>
            </div>

            <!-- Map Error State -->
            <div id="map-error" class="hidden h-96 flex items-center justify-center bg-red-50" role="alert" aria-live="assertive">
                <div class="text-center">
                    <svg class="w-12 h-12 text-red-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700 font-medium">{{ __('messages.transportation.error_loading') }}</p>
                    <button onclick="window.transportationMap.initializeMap()" 
                            class="mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        {{ __('messages.common.retry') }}
                    </button>
                </div>
            </div>

            <!-- Leaflet Map Container -->
            <div id="transportation-map" 
                 class="hidden h-96 md:h-[500px] w-full z-10" 
                 role="application" 
                 aria-label="{{ __('messages.transportation.map_description_screen_reader') }}"
                 tabindex="0">
            </div>

            <!-- Map Legend -->
            <div class="p-6 bg-gradient-to-r from-warm-gray-50 to-gentle-blue border-t border-warm-gray-100">
                <h3 class="text-lg font-semibold text-warm-gray-800 mb-4">{{ __('messages.transportation.legend_title') }}</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-medical-blue rounded-full mr-2 flex-shrink-0"></div>
                        <span class="text-warm-gray-700">{{ __('messages.transportation.practice_popup') }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-600 rounded-full mr-2 flex-shrink-0"></div>
                        <span class="text-warm-gray-700">U-Bahn/S-Bahn</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-600 rounded-full mr-2 flex-shrink-0"></div>
                        <span class="text-warm-gray-700">Bus</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-600 rounded-full mr-2 flex-shrink-0"></div>
                        <span class="text-warm-gray-700">Tram</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-600 rounded-full mr-2 flex-shrink-0"></div>
                        <span class="text-warm-gray-700">Parking</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-600 rounded-full mr-2 flex-shrink-0"></div>
                        <span class="text-warm-gray-700">Bike Share</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<!-- Include Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
/**
 * Transportation Map Component
 * Leaflet.js map with localized transportation markers for medical practice
 */
class TransportationMap {
    constructor() {
        this.map = null;
        this.markers = [];
        this.isInitialized = false;
        this.currentLocale = '{{ app()->getLocale() }}';
        
        // Configuration from Laravel config
        this.config = {
            practiceLocation: @json(config('transportation.practice_location')),
            transportationMarkers: @json(config('transportation.transportation_markers')),
            mapConfig: @json(config('transportation.map_config')),
            markerIcons: @json(config('transportation.marker_icons'))
        };
        
        // Localized strings
        this.strings = {
            loading: @json(__('messages.transportation.loading')),
            errorLoading: @json(__('messages.transportation.error_loading')),
            practicePopup: @json(__('messages.transportation.practice_popup')),
            accessibilityInfo: @json(__('messages.transportation.accessibility_info')),
            noAccessibilityInfo: @json(__('messages.transportation.no_accessibility_info')),
            linesAvailable: @json(__('messages.transportation.lines_available')),
            walkingDistance: @json(__('messages.transportation.walking_distance')),
            zoomIn: @json(__('messages.transportation.zoom_in')),
            zoomOut: @json(__('messages.transportation.zoom_out')),
            centerMap: @json(__('messages.transportation.center_map')),
            markerDescription: @json(__('messages.transportation.marker_description'))
        };
        
        this.init();
    }
    
    init() {
        // Initialize map when component becomes visible
        const mapContainer = document.getElementById('transportation-map');
        if (mapContainer) {
            // Use Intersection Observer for performance
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this.isInitialized) {
                        this.initializeMap();
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });
            
            observer.observe(mapContainer.parentElement);
        }
    }
    
    async initializeMap() {
        if (this.isInitialized) return;
        
        try {
            const mapContainer = document.getElementById('transportation-map');
            const loadingContainer = document.getElementById('map-loading');
            const errorContainer = document.getElementById('map-error');
            
            if (!mapContainer) {
                throw new Error('Map container not found');
            }
            
            // Hide loading, show map container
            loadingContainer.classList.add('hidden');
            mapContainer.classList.remove('hidden');
            
            // Initialize Leaflet map
            this.map = L.map('transportation-map', {
                center: [this.config.practiceLocation.latitude, this.config.practiceLocation.longitude],
                zoom: this.config.mapConfig.default_zoom,
                minZoom: this.config.mapConfig.min_zoom,
                maxZoom: this.config.mapConfig.max_zoom,
                zoomControl: this.config.mapConfig.show_zoom_control,
                scrollWheelZoom: false, // Disabled by default for better UX
                accessibilityFeatures: true
            });
            
            // Add tile layer
            L.tileLayer(this.config.mapConfig.tile_layer, {
                attribution: this.config.mapConfig.tile_attribution,
                maxZoom: this.config.mapConfig.max_zoom
            }).addTo(this.map);
            
            // Add practice marker
            this.addPracticeMarker();
            
            // Add transportation markers
            this.addTransportationMarkers();
            
            // Add accessibility features
            this.setupAccessibility();
            
            // Add map controls
            this.addCustomControls();
            
            // Add keyboard navigation
            this.setupKeyboardNavigation();
            
            this.isInitialized = true;
            
            // Announce to screen readers
            this.announceToScreenReader('Map loaded successfully');
            
        } catch (error) {
            console.error('Error initializing map:', error);
            this.showError();
        }
    }
    
    addPracticeMarker() {
        const practiceIcon = L.divIcon({
            className: 'practice-marker',
            html: `
                <div class="w-8 h-8 bg-medical-blue rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 14h-2v-2h2v2zm0-6h-2V6h2v2zm-4 2h-2v2h2v-2zm0-4h-2v2h2V6zm4-4H5v16h14V2zm-2 14H7V4h10v12z"/>
                        <path d="M12 7h-2v2h2V7zm0 4h-2v2h2v-2z"/>
                    </svg>
                </div>
            `,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });
        
        const practiceMarker = L.marker([
            this.config.practiceLocation.latitude,
            this.config.practiceLocation.longitude
        ], { 
            icon: practiceIcon,
            alt: this.strings.practicePopup,
            keyboard: true,
            riseOnHover: true
        }).addTo(this.map);
        
        // Create popup content
        const popupContent = `
            <div class="p-3 min-w-[200px]">
                <h3 class="font-semibold text-medical-blue mb-2">${this.strings.practicePopup}</h3>
                <p class="text-sm text-warm-gray-600 mb-2">${this.translateMessage(this.config.practiceLocation.address)}</p>
                <div class="flex items-center text-xs text-warm-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    ${this.translateMessage(this.config.practiceLocation.name)}
                </div>
            </div>
        `;
        
        practiceMarker.bindPopup(popupContent, {
            closeButton: true,
            autoClose: false,
            className: 'practice-popup'
        });
        
        this.markers.push(practiceMarker);
    }
    
    addTransportationMarkers() {
        this.config.transportationMarkers.forEach(marker => {
            const markerIcon = this.createTransportationIcon(marker.type);
            
            const leafletMarker = L.marker([marker.latitude, marker.longitude], {
                icon: markerIcon,
                alt: this.strings.markerDescription.replace('{type}', marker.type).replace('{name}', this.translateMessage(marker.name)),
                keyboard: true,
                riseOnHover: true
            }).addTo(this.map);
            
            // Create popup content
            const popupContent = this.createTransportationPopup(marker);
            
            leafletMarker.bindPopup(popupContent, {
                closeButton: true,
                autoClose: false,
                className: `transportation-popup ${marker.type}-popup`
            });
            
            this.markers.push(leafletMarker);
        });
    }
    
    createTransportationIcon(type) {
        const iconConfig = {
            subway: { bg: 'bg-blue-600', icon: '🚇' },
            bus: { bg: 'bg-green-600', icon: '🚌' },
            tram: { bg: 'bg-yellow-600', icon: '🚋' },
            parking: { bg: 'bg-purple-600', icon: '🅿️' },
            bike: { bg: 'bg-orange-600', icon: '🚲' }
        };
        
        const config = iconConfig[type] || iconConfig.bus;
        
        return L.divIcon({
            className: `transportation-marker ${type}-marker`,
            html: `
                <div class="w-6 h-6 ${config.bg} rounded-full flex items-center justify-center shadow-lg border border-white text-white text-xs">
                    ${config.icon}
                </div>
            `,
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            popupAnchor: [0, -12]
        });
    }
    
    createTransportationPopup(marker) {
        let content = `
            <div class="p-3 min-w-[250px]">
                <h3 class="font-semibold text-medical-blue mb-2">${this.translateMessage(marker.name)}</h3>
                <p class="text-sm text-warm-gray-600 mb-3">${this.translateMessage(marker.description)}</p>
        `;
        
        // Add lines if available
        if (marker.lines && marker.lines.length > 0) {
            content += `
                <div class="mb-3">
                    <p class="text-xs font-medium text-warm-gray-700 mb-1">${this.strings.linesAvailable}:</p>
                    <div class="flex flex-wrap gap-1">
                        ${marker.lines.map(line => `
                            <span class="px-2 py-1 bg-medical-blue text-white text-xs rounded font-medium">${line}</span>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        // Add walking time
        if (marker.walking_time) {
            content += `
                <div class="flex items-center text-xs text-warm-gray-600 mb-2">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${this.strings.walkingDistance}: ${this.translateMessage(marker.walking_time)}
                </div>
            `;
        }
        
        // Add accessibility info
        const accessibilityText = marker.accessibility ? 
            this.strings.accessibilityInfo : 
            this.strings.noAccessibilityInfo;
        const accessibilityIcon = marker.accessibility ? '✓' : '⚠️';
        
        content += `
                <div class="flex items-center text-xs ${marker.accessibility ? 'text-green-600' : 'text-yellow-600'}">
                    <span class="mr-1">${accessibilityIcon}</span>
                    ${accessibilityText}
                </div>
        `;
        
        // Add parking specific info
        if (marker.type === 'parking' && marker.hourly_rate) {
            content += `
                <div class="text-xs text-warm-gray-600 mt-2">
                    <strong>Rate:</strong> ${marker.hourly_rate}/hour
                </div>
            `;
        }
        
        content += '</div>';
        return content;
    }
    
    setupAccessibility() {
        // Add focus indicators
        const mapContainer = document.getElementById('transportation-map');
        mapContainer.addEventListener('focus', () => {
            mapContainer.style.outline = '3px solid #3B7BB8';
            mapContainer.style.outlineOffset = '2px';
        });
        
        mapContainer.addEventListener('blur', () => {
            mapContainer.style.outline = 'none';
        });
        
        // Enable scroll wheel zoom on focus
        mapContainer.addEventListener('focus', () => {
            this.map.scrollWheelZoom.enable();
        });
        
        mapContainer.addEventListener('blur', () => {
            this.map.scrollWheelZoom.disable();
        });
    }
    
    setupKeyboardNavigation() {
        const mapContainer = document.getElementById('transportation-map');
        
        mapContainer.addEventListener('keydown', (e) => {
            const panDistance = 50;
            
            switch (e.key) {
                case 'ArrowUp':
                    e.preventDefault();
                    this.map.panBy([0, -panDistance]);
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    this.map.panBy([0, panDistance]);
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    this.map.panBy([-panDistance, 0]);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.map.panBy([panDistance, 0]);
                    break;
                case '+':
                case '=':
                    e.preventDefault();
                    this.map.zoomIn();
                    break;
                case '-':
                    e.preventDefault();
                    this.map.zoomOut();
                    break;
                case 'Home':
                    e.preventDefault();
                    this.centerOnPractice();
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    // Open nearest marker popup
                    this.openNearestMarker();
                    break;
            }
        });
    }
    
    addCustomControls() {
        // Center map control
        const centerControl = L.control({ position: 'topright' });
        centerControl.onAdd = () => {
            const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.innerHTML = `
                <a href="#" role="button" title="${this.strings.centerMap}" 
                   aria-label="${this.strings.centerMap}"
                   style="background-color: white; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #333;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 1v6m0 6v6m-6-6h6m6 0h6"></path>
                    </svg>
                </a>
            `;
            
            div.onclick = (e) => {
                e.preventDefault();
                this.centerOnPractice();
            };
            
            return div;
        };
        centerControl.addTo(this.map);
    }
    
    centerOnPractice() {
        this.map.setView([
            this.config.practiceLocation.latitude,
            this.config.practiceLocation.longitude
        ], this.config.mapConfig.default_zoom);
        
        this.announceToScreenReader('Map centered on practice location');
    }
    
    openNearestMarker() {
        if (this.markers.length > 0) {
            this.markers[0].openPopup();
        }
    }
    
    showError() {
        const loadingContainer = document.getElementById('map-loading');
        const errorContainer = document.getElementById('map-error');
        const mapContainer = document.getElementById('transportation-map');
        
        loadingContainer.classList.add('hidden');
        mapContainer.classList.add('hidden');
        errorContainer.classList.remove('hidden');
        
        this.announceToScreenReader(this.strings.errorLoading);
    }
    
    translateMessage(messageKey) {
        // Simple translation helper - in a real app this would be more sophisticated
        if (typeof messageKey === 'string' && messageKey.startsWith('messages.')) {
            // For demo purposes, return the key without 'messages.' prefix
            // In production, this would integrate with Laravel's localization
            return messageKey.replace('messages.', '').replace(/\./g, ' ').replace(/_/g, ' ');
        }
        return messageKey;
    }
    
    announceToScreenReader(message) {
        const liveRegion = document.getElementById('live-region');
        if (liveRegion) {
            liveRegion.textContent = message;
        }
    }
    
    // Public API
    destroy() {
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
        this.markers = [];
        this.isInitialized = false;
    }
    
    resize() {
        if (this.map) {
            this.map.invalidateSize();
        }
    }
}

// Initialize map when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.transportationMap = new TransportationMap();
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (window.transportationMap) {
        window.transportationMap.destroy();
    }
});
</script>

<style>
/* Map-specific styles */
.practice-marker {
    filter: drop-shadow(0 4px 8px rgba(59, 123, 184, 0.3));
}

.transportation-marker {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.leaflet-popup-content {
    margin: 0;
}

.practice-popup .leaflet-popup-content-wrapper {
    background-color: #EBF4FD;
    border: 2px solid #3B7BB8;
}

.transportation-popup .leaflet-popup-content-wrapper {
    background-color: white;
}

.leaflet-control-custom:hover {
    background-color: #f5f5f5 !important;
}

/* Accessibility improvements */
.leaflet-marker-icon:focus {
    outline: 3px solid #3B7BB8;
    outline-offset: 2px;
}

.leaflet-popup-close-button:focus {
    outline: 2px solid #3B7BB8;
    outline-offset: 1px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .leaflet-popup-content-wrapper {
        max-width: 250px;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .practice-marker div {
        border-width: 3px;
        border-color: #000;
    }
    
    .transportation-marker div {
        border-width: 2px;
        border-color: #000;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .leaflet-zoom-anim,
    .leaflet-pan-anim {
        animation: none !important;
        transition: none !important;
    }
}
</style>