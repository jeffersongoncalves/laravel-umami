@php($settings = app(\JeffersonGoncalves\Umami\Settings\UmamiSettings::class))

@if(!empty($settings->website_id))
    <script async defer data-website-id="{{ $settings->website_id }}"
            src="{{ $settings->host_analytics }}/script.js"
            @if($settings->host_url) data-host-url="{{ $settings->host_url }}" @endif
            @if($settings->domains) data-domains="{{ $settings->domains }}" @endif
            @if($settings->tag) data-tag="{{ $settings->tag }}" @endif
            data-auto-track="{{ $settings->auto_track ? 'true' : 'false' }}"
            data-exclude-search="{{ $settings->exclude_search ? 'true' : 'false' }}"
            data-exclude-hash="{{ $settings->exclude_hash ? 'true' : 'false' }}">
    </script>
@endif
