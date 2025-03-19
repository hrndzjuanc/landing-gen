<style>
    /* Nuevas clases */
    .footer-links-container {
        display: flex;
        justify-content: center;
        padding: 1rem;
        gap: 1rem;
    }

    .footer-text {
        display: flex;
        justify-content: center;
        padding: 1rem;
        max-width: 40%;
        margin: 0 auto;
        text-align: center;
    }

    .footer-logo {
        display: flex;
        justify-content: center;
        padding: 1rem;
    }

    .footer-dark {
        background-color: black;
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        color: white;
    }

</style>

<footer class="header" style="background-color: black;">
    <div id="header-template-3" class="header-container" style="padding-top: 0.8rem;">
        <div> 
            <!-- Enlaces a la derecha -->
            <div class="footer-links-container">
            @foreach ($landing->links as $link)
                <p-link-pure icon="none" underline="true" theme="dark"href="{{$link['link_url']}}">{{$link['link_name']}}</p-link-pure>
            @endforeach
            </div>
        </div>
        <div class="footer-text">
            <p-text theme="dark">{{ $landing->footer_text}}</p-text>
        </div>

        <div class="footer-logo">
            <p-wordmark size="small" theme="dark"></p-wordmark>
        </div>
    </div>
</footer>