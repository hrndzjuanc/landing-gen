<x-filament-panels::page>
    <script src="/porsche-design-system/components-js/index.js"></script>
      <style>
      body{
        margin:0;
        padding:0;
      }
      </style>
      <a href="{{ url()->previous() }}" style="max-width:100px;" class="fi-btn fi-btn-size-md inline-flex items-center justify-center py-2 gap-2 font-medium rounded-lg bg-primary-600 text-white shadow-sm hover:bg-primary-500 focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-primary-600">
      <span>Volver</span>
      </a>

      <div>
        @if ($landing->header_type === '1')
        @include('porsche.header1')
      @elseif ($landing->header_type === '2')
        @include('porsche.header2')
      @elseif ($landing->header_type === '3')
        @include('porsche.header3')
      @elseif ($landing->header_type === '4')
        @include('porsche.header4')
      @endif

      @if ($landing->body)
        <div id="preview-container">
          <iframe 
            style="width: 100%; height: 100%; min-height: 60vh; border: none; overflow: hidden;" 
            srcdoc="{!! htmlspecialchars($landing->body) !!}"
            sandbox="allow-scripts allow-same-origin">
          </iframe>
        </div>
      @endif


      @if ($landing->footer_type === '1')
        @include('porsche.footer1')
      @elseif ($landing->footer_type === '2')
        @include('porsche.footer2')
      @elseif ($landing->footer_type === '3')
        @include('porsche.footer3')
      @elseif ($landing->footer_type === '4')
        @include('porsche.footer4')
      @endif
      </div>
    <script type="text/javascript">
      porscheDesignSystem.load();
    </script>

</x-filament-panels::page>
