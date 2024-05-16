$(document).ready(function($) {
   var baseUrl = $('meta[name="base-url"]').attr('content')

   let urlWindow = $(location).attr('href'),
      parts = urlWindow.split("/"),
      last_part = parts[parts.length - 1];
   if (last_part == 'web-settings') {
      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: urlWindow + '/get-web-settings',
         type: 'GET',
         success: function(responses) {
            let form = $('#form-web-settings')
            form.find('input[name="website_name"]').val(responses.website_name)
            form.find('input[name="school_name"]').val(responses.school_name)
            form.find('input[name="phone_number"]').val(responses.phone_number)
            form.find('input[name="link_video"]').val(responses.link_video)
            form.find('input[name="email"]').val(responses.email)
            form.find('input[name="facebook"]').val(responses.facebook)
            form.find('input[name="instagram"]').val(responses.instagram)
            form.find('input[name="twitter"]').val(responses.twitter)
            form.find('input[name="youtube"]').val(responses.youtube)
            form.find('textarea[name="address"]').val(responses.address)
            form.find('textarea[name="title_kwu"]').val(responses.title_kwu)
            form.find('textarea[name="subtitle_kwu"]').val(responses.subtitle_kwu)
            form.find('textarea[name="caption_index"]').val(responses.caption_index)
            form.find('textarea[name="caption_company"]').val(responses.caption_company)
            form.find('textarea[name="caption_search"]').val(responses.caption_search)
            form.find('select[name="province"]').val(responses.province).trigger('change')
            if (responses.logo_white != '' && responses.logo_white !== 'storage/' && responses.logo_white != undefined) {
               // form.find('input[name="logo_white"]').after('<input type="text" name="temp_logo_white" value="' + responses.logo_white + '" hidden readonly>')
               let url = baseUrl + '/public/storage/' + responses.logo_white;
               resetPreview('logo_white', url, 'logo-white.png', null);
            }
            if (responses.logo_black != '' && responses.logo_black !== 'storage/' && responses.logo_black != undefined) {
               // form.find('input[name="logo_black"]').after('<input type="text" name="temp_logo_black" value="' + responses.logo_black + '" hidden readonly>')
               let url = baseUrl + '/public/storage/' + responses.logo_black;
               resetPreview('logo_black', url, 'logo-black.png', null);
            }
            if (responses.image_kwu != '' && responses.image_kwu !== 'storage/' && responses.image_kwu != undefined) {
               // form.find('input[name="image_kwu"]').after('<input type="text" name="temp_image_kwu" value="' + responses.image_kwu + '" hidden readonly>')
               let url = baseUrl + '/public/storage/' + responses.image_kwu;
               resetPreview('image_kwu', url, 'image-kwu.png', null);
            }
            if (responses.cover_index != '' && responses.cover_index !== 'storage/' && responses.cover_index != undefined) {
               // form.find('input[name="cover_index"]').after('<input type="text" name="temp_cover_index" value="' + responses.cover_index + '" hidden readonly>')
               let url = baseUrl + '/public/storage/' + responses.cover_index;
               console.log(url);
               resetPreview('cover_index', url, 'cover-index.png', null);
            }
            if (responses.cover_company != '' && responses.cover_company !== 'storage/' && responses.cover_company != undefined) {
               // form.find('input[name="cover_company"]').after('<input type="text" name="temp_cover_company" value="' + responses.cover_company + '" hidden readonly>')
               let url = baseUrl + '/public/storage/' + responses.cover_company;
               resetPreview('cover_company', url, 'cover-company.png', null);
            }
            if (responses.cover_search != '' && responses.cover_search !== 'storage/' && responses.cover_search != undefined) {
               // form.find('input[name="cover_search"]').after('<input type="text" name="temp_cover_search" value="' + responses.cover_search + '" hidden readonly>')
               let url = baseUrl + '/public/storage/' + responses.cover_search;
               resetPreview('cover_search', url, 'cover-search.png', null);
            }
            if (responses.image_sliders != null) {
               $.each(responses.image_sliders, function(key, value) {
                  if (key > 1) {
                     addBrandLogo()
                  }
                  if (value.image != '' && value.image !== 'storage/') {
                     let url = baseUrl + '/public/storage/' + value.image;
                     resetPreview('brandLogo' + value.index, url, 'brand-logo ' + value.index + '.png', value.id);
                  }
               });
            }

            let timer = setTimeout(function run() {
               if (form.find('select[name="city"] option').length > 1) {
                  form.find('select[name="city"]').val(responses.city).trigger('change')
                  stop()
               } else {
                  timer = setTimeout(run, 500)
               }
            }, 500);

            function stop() {
               clearTimeout(timer)
            }
         },
         error: function(exception) { console.log("error" + exception.responseText) }
      });
   }

   $('body').on('click', '.dropify-clear', function() {
      let container = $(this).parent('.dropify-wrapper')
      let input = container.find('input[name="brand_logo[]"]')
      let key = input.attr('data-key')
      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: baseUrl + '/admin/delete-image-slider',
         type: 'POST',
         data: { key: key },
         success: function(responses) {
            if (responses.status == 200) {
               Swal.fire({
                  position: 'center',
                  type: 'success',
                  title: 'Sukses',
                  text: responses.message,
                  showConfirmButton: false,
                  timer: 2000,
               })
            }
         },
         error: function(exception) {
            Swal.fire({
               position: 'center',
               type: 'error',
               title: 'Gagal',
               text: 'gagal',
               showConfirmButton: false,
               timer: 2000,
            })
         }
      });
   })

   $('body').on('click', '#addBrandInput', function() {
      addBrandLogo()
   })

   $('#province').on('change', function() {
      if ($(this).val() != 0) {
         let id = $(this).val()
         let temp_url = $(this).data('url')
         let url = temp_url + '/get-cities/' + id
         $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'GET',
            success: function(responses) {
               $('#city').empty();
               // $('#city').append('<option value="0" selected>Pilih Kota/Kabupaten</option>');
               $('#city').append(
                  '<option value="0">Pilih Kota/Kabupaten</option>');
               $.each(responses, function(key, value) {
                  $('#city').append('<option value="' + value.id + '">' +
                     value.name + '</option>');
               })

            },
            error: function(exception) {
               console.log("error" + exception.responseText)
            }
         });
      } else {
         $('#city').empty();
      }
   })

   function addBrandLogo() {
      let container = $('form #container-form')
      let count = $('form #container-form .brandLogo').length
      let content = $('body div#content-brandLogo').clone().find('input').val('').end()
      if (count < 16) {
         content.find('input[type="number"]').val(count + 1)
         content.find('input[name="brand_logo[]"]').attr('id', 'brandLogo' + (count + 1))
         content.find('input[name="brand_logo[]"]').addClass('dropify').dropify()
         content.removeAttr('hidden')
         content.removeAttr('id')
         container.append(content)
      }
   }

   function resetPreview(name, src, fname = '', id = null) {
      let input = $('#' + name);
      let wrapper = input.closest('.dropify-wrapper');
      let preview = wrapper.find('.dropify-preview');
      let filename = wrapper.find('.dropify-filename-inner');
      let render = wrapper.find('.dropify-render').html('');

      input.val('').attr('title', fname);
      wrapper.removeClass('has-error').addClass('has-preview');
      filename.html(fname);

      render.append($('<img />').attr('src', src).css('max-height', input.data('height') || ''));
      preview.fadeIn();
      if (id != null) {
         input.attr('data-key', id)
      }
   }

   $('#viewResume').on('show.bs.modal', function(e) {
      let button = $(e.relatedTarget)
      let url = button.data('url');
      let modal = $(this)
      modal.find('#modal-resume').empty()
      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: url,
         type: 'GET',
         success: function(responses) {
            if (responses.status == 'NOT_COMPLETE') {
               $('#viewResume').modal('hide')
               Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Gagal',
                  text: 'Terjadi kesalahan saat generate Resume. Profile Alumni belum dilengkapi',
                  showConfirmButton: false,
                  timer: 5000,
               })
            } else {
               modal.find('#modal-resume').empty().append(responses);
            }
         },
         error: function(exception) { console.log("error" + exception.responseText) }
      });
   })
})