@if(!empty(config('umami.website_id')))
    <script async defer data-website-id="{{ config('umami.website_id') }}"
            src="{{ config('umami.host_analytics') }}/script.js"
            @if(config('umami.host_url')) data-host-url="{{ config('umami.host_url') }}" @endif
            @if(config('umami.domains')) data-domains="{{ config('umami.domains') }}" @endif
            @if(config('umami.tag')) data-tag="{{ config('umami.tag') }}" @endif
            data-auto-track="{{ config('umami.auto_track') }}"
            data-exclude-search="{{ config('umami.exclude_search') }}"
            data-exclude-hash="{{ config('umami.exclude_hash') }}">
    </script>
@endif
