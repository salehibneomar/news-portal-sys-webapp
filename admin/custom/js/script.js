

  $('.select2bs4').select2({
      theme: 'bootstrap4'
  });
   
  $('#image').change(function(e){
    var imageName = e.target.files[0].name;
    $('#imageLabel').text(imageName);
  });

  $('#formReset').click(function(){
    $('#imageLabel').text('Choose image');;
  });

  $('.bs4-tags-input').tagsinput({
        maxTags: 6,
        trimValue: true,
        confirmKeys: [44],
        maxChars: 30,
        allowDuplicates: false
  });

  $('.bootstrap-tagsinput > input:first').focus(function(){
        $('.bootstrap-tagsinput').addClass('form-control-focus-class');
  });

  $('.bootstrap-tagsinput > input:first').focusout(function(){
      $('.bootstrap-tagsinput').removeClass('form-control-focus-class');
  });


