@php
    $fbPixel = setting('fb_pixel_id') ?: config('store.meta_pixel_id');
    $gtmId = setting('gtm_id') ?: config('store.google_tag_manager_id');
    $gaId = setting('ga_measurement_id');
    $customHeader = setting('custom_header_scripts');
@endphp

@if($fbPixel && preg_match('/^\d+$/', (string) $fbPixel))
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', {{ Illuminate\Support\Js::from($fbPixel) }});
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $fbPixel }}&ev=PageView&noscript=1"
    alt="fb_pixel"/></noscript>
@endif

@if($gtmId)
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f)})(window,document,'script','dataLayer',{{ Illuminate\Support\Js::from($gtmId) }});
    </script>
@endif

@if($gaId)
    <!-- Google Analytics GA4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
@endif

@if($customHeader)
    {!! $customHeader !!}
@endif
