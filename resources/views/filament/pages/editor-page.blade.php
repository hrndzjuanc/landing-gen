<x-filament-panels::page>
  <div class="flex justify-between items-center gap-4 mb-6">

    <div>
      <x-filament::button
        onclick="window.history.back()"
        type="button"
        class="fi-btn fi-btn-size-md inline-flex items-center justify-center py-2 gap-2 font-medium rounded-lg bg-primary-600 text-white shadow-sm hover:bg-primary-500 focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-primary-600"
        style="max-width:150px;"
      >
        <span>Volver</span>
      </x-filament::button>
    </div>
    
    <div class="w-full">
      <div class="bg-amber-50 border-l-4 border-amber-400 p-4 w-full">
        <div class="flex items-start">
          <div class="flex-shrink-0 px-2 py-1">
            <svg 
              class="h-6 w-6 text-amber-400" 
              xmlns="http://www.w3.org/2000/svg" 
              fill="none" 
              viewBox="0 0 24 24" 
              stroke="currentColor"
            >
              <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" 
              />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-lg font-medium text-amber-800">Requisitos importantes para formularios</h3>
            <div class="mt-2 text-amber-200">
              <p class="mb-2">Para garantizar el correcto funcionamiento de los formularios, asegúrate de seguir estas pautas:</p>
              <ul class="list-disc list-inside space-y-1 ml-2">
                <li>Los botones deben ser de tipo <code class="bg-amber-100 px-1 rounded">submit</code></li>
                <li>Los campos del formulario deben tener 'name' sin espacios, utilizando guiones bajos. 
                  <br>Ejemplos: <code class="bg-amber-100 px-1 rounded">nombre</code> o <code class="bg-amber-100 px-1 rounded">correo_electronico</code>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://unpkg.com/@grapesjs/studio-sdk/dist/index.umd.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/@grapesjs/studio-sdk/dist/style.css"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <div id="studio-editor" style="height: 100dvh"></div>
  
  <script>
    const ASSETS_UPLOAD_URL = '/upload-landing-image';
    const landingId = '{{ $landing->id }}';

    const getBody = async () => {
      const response = await fetch(`/obtener-proyecto/${landingId}`);
      return response.text();
    };

    (async function initializeEditor() {
      const initialBody = await getBody();
      
      GrapesJsStudioSDK.createStudioEditor({
        root: '#studio-editor',
        licenseKey: 'aeaf53bfae0b4c2db34a728a3e74f56090fb8f0fb7ef4207859e24ba22354201',
        project: { type: 'web' },
        assets: {
          storageType: 'self',
          onUpload: async ({ files }) => {
            const body = new FormData();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            for (const file of files) {
              body.append('files', file);
            }
            const response = await fetch(`${ASSETS_UPLOAD_URL}/${landingId}`, { method: 'POST', body });
            const result = await response.json();
            return [{ src: result.path }];
          },
          onDelete: async ({ assets }) => {}
        },
        storage: {
          type: 'self',
          onSave: async ({ project, editor }) => {
            const html = await getHtml(editor, 'STAGE');
            const body = new FormData();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('html', html);
            try {
              const response = await fetch(`/actualizar-cuerpo/${landingId}`, { 
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body 
              });
              if (!response.ok) throw new Error('Error al guardar el proyecto');
              return await response.json();
            } catch (error) {
              console.error('Error en onSave:', error);
              throw error;
            }
          },
          onLoad: async () => {
            const response = await fetch(`/obtener-proyecto/${landingId}`);
            const project = await response.text();
            return { project };
          },
          project: { pages: [{ name: 'Home', component: initialBody }] },
          autosaveChanges: 100,
          autosaveIntervalMs: 10000
        }
      });
    })();

    (async () => {
      setTimeout(async () => {
        await fetch(`/obtener-proyecto/${landingId}`);
      }, 2000);
    })();

    const getHtml = async (editor, env) => {
      const files = await editor.runCommand('studio:projectFiles', { styles: 'inline' });
      const firstPage = files.find(file => file.mimeType === 'text/html');
      return firstPage.content;
    };
  </script>
</x-filament-panels::page>
