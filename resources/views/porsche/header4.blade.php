<style>
    #header-template-4 .header{
        min-height: 3rem;
    }
    #header-template-4 .header-container {
        height:100%;
        align-items: center;
        background:black;
        padding:0.5rem;
    }

    #header-template-4 .header-flex-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #header-template-4 .header-right-links {
        display: flex;
        gap: 1rem;
    }
</style>

<header id="header-template-4" class="header">
    <div class="header-container" style="padding-top: 0.8rem;">
        <div class="header-flex-row"> 
            <!-- Logo a la izquierda -->
            <div class="header-left">
                <p-wordmark size="small" theme="dark"></p-wordmark>
            </div>
            
            <!-- Espacio central vacío -->
            <div class="header-center">
            </div>
            
            <!-- Enlaces a la derecha -->
            <div class="header-right header-right-links">
            @foreach ($landing->links as $link)
                <p-link-pure icon="none" underline="true" theme="dark" href="{{$link['link_url']}}">{{$link['link_name']}}</p-link-pure>
            @endforeach
            </div>
        </div>
    </div>
</header>