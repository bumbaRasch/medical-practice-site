<?php

return [
    /*
     * Determine if the response cache middleware should be enabled.
     */
    'enabled' => env('RESPONSE_CACHE_ENABLED', true),

    /*
     * The given class will determinate if a request should be cached. The
     * default class will cache all successful GET-requests.
     *
     * You can provide your own class given that it implements the
     * CacheProfile interface.
     */
    'cache_profile' => App\Http\CacheProfiles\MedicalWebsiteCacheProfile::class,

    /*
     * When using the default CacheRequestsWithoutQuery cache profile, 
     * all requests with a query string parameter will not be cached.
     * You can provide your own parameter to be ignored here.
     */
    'ignored_query_parameters' => [],

    /*
     * This setting determines if a http header showing the cache time
     * should be added to a cached response. This can be handy when
     * debugging.
     */
    'add_cache_time_header' => env('APP_DEBUG', false),

    /*
     * Here you may define the cache store that should be used to store
     * requests. This can be any store that is configured in your cache
     * config file.
     */
    'cache_store' => env('RESPONSE_CACHE_DRIVER', 'file'),

    /*
     * Here you may define in minutes how long responses must be cached.
     */
    'cache_lifetime_in_minutes' => env('RESPONSE_CACHE_LIFETIME', 60 * 24), // 24 hours

    /*
     * When enabled this setting will cause the responsecache module to write
     * information to the laravel log concerning each cache event.
     */
    'cache_tag_header_name' => env('RESPONSE_CACHE_TAG_HEADER_NAME', 'laravel-responsecache'),

    /*
     * This setting determines whether the cache should be flushed when the
     * application is updated. Generally you will want this to be true.
     */
    'forget_cache_on_update' => env('RESPONSE_CACHE_FORGET_ON_UPDATE', true),

    /*
     * Optionally, you can provide a replacer that will replace the cache key
     * before storing it. This is useful if you want to cache different
     * variations of the same page based on user attributes etc.
     */
    'cache_key_replacer' => null,

    /*
     * You can provide a serializer that will be used to serialize the cache
     * tags. The built-in one should handle most use cases.
     */
    'serializer' => Spatie\ResponseCache\Serializers\DefaultSerializer::class,
];