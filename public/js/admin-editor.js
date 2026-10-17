/**
 * Admin Rich Text Editor Integration
 * 100% Free Open Source Summernote BS5 initializer
 */
(function ($) {
  'use strict';

  function initRichEditors() {
    if (typeof $.fn.summernote === 'undefined') {
      console.warn('Summernote plugin is not loaded yet.');
      return;
    }

    $('.rich-editor, .summernote').each(function () {
      var $textarea = $(this);

      // Prevent double initialization
      if ($textarea.next('.note-editor').length > 0) {
        return;
      }

      var customHeight = parseInt($textarea.data('height'), 10) || 220;
      var placeholder = $textarea.attr('placeholder') || 'Type or paste content here...';

      $textarea.summernote({
        placeholder: placeholder,
        height: customHeight,
        minHeight: 140,
        maxHeight: 700,
        dialogsInBody: true,
        dialogsFade: true,
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana', 'Outfit', 'Inter'],
        fontNamesIgnoreCheck: ['Outfit', 'Inter'],
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph', 'height']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video', 'hr']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
          onChange: function (contents) {
            $textarea.val(contents);
          },
          onBlur: function () {
            $textarea.val($textarea.summernote('code'));
          },
          onImageUpload: function (files) {
            var $editor = $(this);
            var csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();
            for (var i = 0; i < files.length; i++) {
              var formData = new FormData();
              formData.append('image', files[i]);
              formData.append('_token', csrfToken);
              $.ajax({
                url: '/admin/media/upload',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                  if (res && res.url) {
                    $editor.summernote('insertImage', res.url);
                  }
                },
                error: function (xhr) {
                  alert('Image upload failed: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Server error'));
                }
              });
            }
          }
        }
      });
    });
  }

  // Document ready
  $(function () {
    initRichEditors();

    // Ensure all rich-editors sync content into textareas before form submit
    $(document).on('submit', 'form', function () {
      $(this).find('.rich-editor, .summernote').each(function () {
        if ($(this).data('summernote')) {
          $(this).val($(this).summernote('code'));
        }
      });
    });

    // Support tab switching in AdminLTE if editors are inside tabs
    $('button[data-bs-toggle="tab"], a[data-toggle="tab"]').on('shown.bs.tab', function () {
      initRichEditors();
    });
  });

  // Global helper for dynamic views
  window.initRichEditors = initRichEditors;
})(jQuery);
