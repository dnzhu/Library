(function() {
  var allow_extensions, avatar_well, reader, uploader;

  allow_extensions = 'jpg,png,gif'.split(',');

  avatar_well = $('#avatar_well');

  uploader = new plupload.Uploader({
    runtimes: 'html5, flash',
    browse_button: 'pickfiles',
    container: 'avatar_well',
    drop_element: 'avatar_well',
    file_data_name: 'image',
    multi_selection: false,
    max_file_size: '2mb',
    url: url('user/avatar'),
    flash_swf_url: url('js/vendor/plupload/plupload.flash.swf'),
    filters: [
      {
        title: 'image files',
        extensions: allow_extensions.join(',')
      }
    ]
  });

  uploader.init();

  reader = new FileReader();

  reader.onload = function(e) {
    var img;
    img = $('<img>').attr('src', e.target.result).on('load', function(e) {
      var height, width;
      width = this.width;
      height = this.height;
      if (this.width > this.height) {
        width = Math.min(this.width, 480);
        height = this.height * width / this.width;
      } else {
        height = Math.min(this.height, 480);
        width = this.width * height / this.height;
      }
      this.width = width;
      this.height = height;
      $('#modal .modal-body').html(this);
      $('#modal').modal();
    });
    return $('#modal').on('show.bs.modal', function() {
      return img.Jcrop({
        minSize: [32, 32],
        aspectRatio: 1,
        setSelect: [0, 0, 140, 140]
      }, function() {
        var jcrop;
        jcrop = this;
        $('#modal').on('click', '#upload', function(e) {
          e.preventDefault();
          uploader.settings.multipart_params = jcrop.tellSelect();
          uploader.start();
        });
      });
    });
  };

  uploader.bind('Error', function(up, error) {
    up.refresh();
    alert(error.message);
  });

  uploader.bind('FilesAdded', function(up, files) {
    var len;
    len = up.files.length;
    if (len > 1) {
      up.splice(0, len - 1);
    }
    reader.readAsDataURL(up.files[0].getNative());
    up.refresh();
  });

  uploader.bind('FileUploaded', function(up, file, resp) {
    $('#modal').modal('hide');
    window.location.reload();
  });

}).call(this);
