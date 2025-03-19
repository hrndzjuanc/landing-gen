<style>
    #header-template-1 .header{
        min-height: 3rem;
    }
    #header-template-1 .header-container {
        height:100%;
        align-items: center;
        padding:0.5rem;
    }

    #header-template-1 .header-flex-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #header-template-1 .header-right-links {
        display: flex;
        gap: 1rem;
    }
</style>

<header id="header-template-1" class="header">
    <!-- Template 1  -->
    <div class="header-container">
        <div class="header-flex-row"> 
            <div class="header-left">
                </div>
                <div class="header-center">
                    <p-wordmark size="small"></p-wordmark>
                </div>
                <div class="header-right">
                    <p-button id="btn-header-1" variant="secondary" icon="menu-lines" hide-label="true"></p-button>
                </div>
        </div>
        <!-- Flyout -->
        <p-flyout id="flyout-1" open="false" aria="{ 'aria-label': 'Some Heading' }">
        <p-heading slot="header" size="large" tag="h2">Menú</p-heading>
        <div style="display:grid;grid-template-columns: 1fr;gap:1rem;">
        @foreach ($landing->links as $link)
                <p-link-pure icon="none" underline="true" href="{{$link['link_url']}}">{{$link['link_name']}}</p-link-pure>
            @endforeach
        </div>
    </p-flyout>
    <script>
    const flyout1 = document.getElementById('flyout-1');
    const btnHeader1 = document.getElementById('btn-header-1');
    flyout1.addEventListener('dismiss', () => (flyout1.open = false));
    btnHeader1.addEventListener('click', () => (flyout1.open = true));
    </script>
    </div>

</header>