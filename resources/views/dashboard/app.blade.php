<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? ucfirst($title) . " | " : '' }}OnlineClass</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template') }}/adminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('template') }}/adminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template') }}/adminLTE/dist/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
  </head>
  <body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
    <div class="wrapper">

      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <x-application-logo class="animation__wobble" alt="Logo" height="120" />
      </div> 
        @include('dashboard.navbar')

        @include('dashboard.sidebar-left')

        @yield('content')

        @include('dashboard.sidebar-right')

        @include('dashboard.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('template') }}/adminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('template') }}/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('template') }}/adminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template') }}/adminLTE/dist/js/adminlte.js"></script>

    <!-- Tinymce -->
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->

    <!-- SweetAlert2 -->
    <script src="{{ asset('template') }}/adminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        function makeToast(bg, isi)
        {
            $(document).Toasts('create', {
                class: bg,
                title: isi,
            });
        }

        @if (session()->has('message'))
          makeToast('bg-success', '<?= session('message') ?>');
        @endif

        @if (session()->has('error'))
          makeToast('bg-danger', '<?= session('error') ?>');
          
        @endif

        @if (session()->has('errors'))
          @foreach ( session('errors') as $error)
            makeToast('bg-danger', {{ $error }});
            
          @endforeach
        @endif

        // function showEditorTinymce(textarea) {
        //   const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
          
        //   tinymce.init({
        //     selector: textarea,
        //     plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        //     editimage_cors_hosts: ['picsum.photos'],
        //     menubar: 'file edit view insert format tools table help',
        //     toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        //     toolbar_sticky: true,
        //     autosave_ask_before_unload: false,
        //     autosave_interval: '30s',
        //     autosave_prefix: '{path}{query}-{id}-',
        //     autosave_restore_when_empty: false,
        //     autosave_retention: '2m',
        //     image_advtab: true,
        //     image_class_list: [{title: 'image-responsive',value: 'about-img-wrap'}],
        //     importcss_append: true,
        //     file_picker_callback: (callback, value, meta) => {
        //         /* Provide file and text for the link dialog */
        //         if (meta.filetype === 'file') {
        //         callback('https://www.google.com/logos/google.jpg', {
        //             text: 'My text'
        //         });
        //         }

        //         /* Provide image and alt text for the image dialog */
        //         if (meta.filetype === 'image') {
        //         callback('https://www.google.com/logos/google.jpg', {
        //             alt: 'My alt text'
        //         });
        //         }

        //         /* Provide alternative source and posted for the media dialog */
        //         if (meta.filetype === 'media') {
        //         callback('movie.mp4', {
        //             source2: 'alt.ogg',
        //             poster: 'https://www.google.com/logos/google.jpg'
        //         });
        //         }
        //     },
        //     templates: [{
        //         title: 'New Table',
        //         description: 'creates a new table',
        //         content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
        //         },
        //         {
        //         title: 'Starting my story',
        //         description: 'A cure for writers block',
        //         content: 'Once upon a time...'
        //         },
        //         {
        //         title: 'New list with dates',
        //         description: 'New List with dates',
        //         content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
        //         }
        //     ],
        //     template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        //     template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        //     height: 600,
        //     image_caption: true,
        //     quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        //     noneditable_class: 'mceNonEditable',
        //     toolbar_mode: 'sliding',
        //     contextmenu: 'link image table',
        //     skin: useDarkMode ? 'oxide-dark' : 'oxide',
        //     content_css: useDarkMode ? 'dark' : 'default',
        //     content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',

        //     image_title: true,
        //     automatic_uploads: true,
        //     images_upload_url: "/dashboard/gallery/image-from-editor",
        //     file_picker_types: 'image',
        //     file_picker_callback: function(cb, value, meta) {
        //         var input = document.createElement('input');
        //         input.setAttribute('type', 'file');
        //         input.setAttribute('name', 'image');
        //         input.setAttribute('accept', 'image/*');
        //         input.onchange = function() {
        //             var file = this.files[0];

        //             var reader = new FileReader();
        //             reader.readAsDataURL(file);
        //             reader.onload = function () {
        //                 var id = 'blobid' + (new Date()).getTime();
        //                 var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        //                 var base64 = reader.result.split(',')[1];
        //                 var blobInfo = blobCache.create(id, file, base64);
        //                 blobCache.add(blobInfo);
        //                 cb(blobInfo.blobUri(), { title: file.name });
        //             };
        //         };
        //         input.click();
        //     }
        //   });
        // }

        function darkMode() { // function untuk tampilan gelap
          $('body').addClass('dark-mode');
          $('#moon').addClass('active');
          $('#sun').removeClass('active');
        }

        function lightMode() { // function untuk tampilan terang
          $('body').removeClass('dark-mode');
          $('#sun').addClass('active');
          $('#moon').removeClass('active');
        }
    </script>

    @yield('script')
  </body>
</html>
