<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title></title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/porsche-design-system/components-js/index.js"></script>
    <style>
      body {
        margin: 0;
        padding: 0;
        display: none; /* Oculta el contenido inicialmente */
      }

    </style>
  </head>
  <body>
    
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
    {!! $landing->body !!}
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

    <script type="text/javascript">
      window.addEventListener('load', function() {

        document.body.style.display = 'block'; // Muestra el contenido cuando todo está cargado
        porscheDesignSystem.load();
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
          form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('/formulario', {
              method: 'POST',
              body: formData,
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Formulario enviado correctamente');
                form.reset();
              } else {
                alert('Error al enviar el formulario');
              }
            });
          });
        });
      });
    </script>
  </body>
</html>