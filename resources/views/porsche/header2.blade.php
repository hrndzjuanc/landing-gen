<style>
    #header-template-2 .header{
        min-height: 3rem;
    }
    #header-template-2 .header-container {
        height:100%;
        align-items: center;
        background:black;
        padding:0.5rem;
    }

    #header-template-2 .header-flex-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #header-template-2 .header-right-links {
        display: flex;
        gap: 1rem;
    }
</style>

<header id="header-template-2" class="header">
    <!-- Template 1  -->
    <div class="header-container">
        <div class="header-flex-row"> 
            <div class="header-left">
                </div>
                <div class="header-center">
                    <p-wordmark size="small" theme="dark"></p-wordmark>
                </div>
                <div class="header-right">
                    <p-button id="btn-header-2" variant="secondary" theme="dark" icon="menu-lines" hide-label="true"></p-button>
                </div>
        </div>
        <!-- Flyout -->
        <p-flyout theme="dark" id="flyout-2" open="false" aria="{ 'aria-label': 'Some Heading' }">
        <p-heading slot="header" size="large" tag="h2" theme="dark" >Menú</p-heading>
        <div style="display:grid;grid-template-columns: 1fr;gap:1rem;">
            @foreach ($landing->links as $link)
                <p-link-pure icon="none" underline="true" theme="dark" href="{{$link['link_url']}}">{{$link['link_name']}}</p-link-pure>
            @endforeach
        </div>
    </p-flyout>
    <script>
    const flyout2 = document.getElementById('flyout-2');
    const btnHeader2 = document.getElementById('btn-header-2');
    flyout2.addEventListener('dismiss', () => (flyout2.open = false));
    btnHeader2.addEventListener('click', () => (flyout2.open = true));
    </script>
    </div>
</header>