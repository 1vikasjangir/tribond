@include('layouts.header')

<style type="text/css">
    a img{
        width: 25%;
    }
</style>
<h1 style="text-align: center">Show Instagram Feed on your Website</h1>
<div id="instafeed-container"></div>

<script src="https://cdn.jsdelivr.net/gh/stevenschobert/instafeed.js@2.0.0rc1/src/instafeed.min.js"></script>
<script type="text/javascript">
    window.INSTAGRAM_TOKEN = `{{ config('services.instagram.instagram_token') }}`;
    const instagramToken = window.INSTAGRAM_TOKEN;
    var userFeed = new Instafeed({
        get: 'user',
        target: "instafeed-container",
        resolution: 'low_resolution',
        accessToken: instagramToken
    });
    userFeed.run();
</script>

@include('layouts.footer')
