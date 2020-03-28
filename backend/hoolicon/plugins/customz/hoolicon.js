function deleteConfirm(conf_) {
  // conf_ : predefined confirmation message
  var quest = conf_ ? conf_ : 'Are you sure you want to delete?';
  var confirmed = confirm(quest);
  if (confirmed == true) {
    return true;
  } else {
    return false;
  }
}

function deleteItem(options) {
  var quest = options.conf_ ? options.conf_ : 'Are you sure you want to delete?';
  var conf = confirm(quest);
  if (conf == true) {
    $.ajax({
      type: 'POST',
      url: site_url+'actions/delete/delete',
      data: {data: options},
      dataType: 'JSON',
      success: function(data) {
        if (data.status == 1) {
          if (options.init == 'dt') {
            $('#tr_'+options.id).fadeOut('slow'); 
          } else if (options.type == 2) { 
          }
          toast(data.msg, 'success', 1);
        } else {
          toast(data.msg, 'error', 1); 
        }
      }
    });
  } else {
    return false;
  }
}

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
}); 

function toast(body, type, hide, delay) {
  var autohide = hide ? true : false;
  var delay = delay ? delay : 3000;

  if (type === 'success') {
    title = 'Success';
    icon = 'fas fa-check-circle fa-lg';
    _class = 'bg-success';
  } else if (type === 'warning') {
    title = 'Warning';
    icon = 'fas exclamation-triangle fa-lg';
    _class = 'bg-warning';
  } else if (type === 'info') {
    title = 'Notice';
    icon = 'fas fa-info fa-lg';
    _class = 'bg-info';
  } else if (type === 'error') {
    title = 'Error';
    icon = 'fas fa-ban fa-lg';
    _class = 'bg-danger';
  } else {
    title = 'Notification';
    icon = '';
    _class = '';
  }

  $(document).Toasts('create', {
    class: _class,
    icon: icon,
    title: title,
    autohide: autohide,
    hide: delay,
    body: body
  })
}
