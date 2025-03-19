<style>
    /* Nuevas clases */
    footer#template-2{
        display: flex;
        justify-content: space-between;
        padding: 0.5rem;
        gap: 1rem;
        background-color: black;
    }
</style>

<footer id="template-2">
        <p-wordmark size="small" theme="dark"></p-wordmark>
        <p-text theme="dark">{{ $landing->footer_text}}</p-text>
</footer>