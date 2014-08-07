var dialog = {
  loading: function (node) {
    return $('<span class="loading-cover">')
      .css('font-size', Math.max(14, Math.min(node.height(), node.width(), 128) / 4) + 'px')
      .append('<span class="fa fa-spin fa-circle-o-notch">')
      .appendTo(node.addClass('loading'));
  },

  unloading: function (node) {
    return node.removeClass('loading').find('.loading-cover').remove();
  }
};


$(function () {
  $('.form-selectors a').on('click', function () {
    var self = $(this);
    var form = self.parents('form');
    var cls  = self.attr('class');

    console.log(form);
    form.find('.specific-form').each(function () {
      var self = $(this);
      if      ( self.hasClass(cls) && !self.hasClass('in')) self.collapse('show');
      else if (!self.hasClass(cls) &&  self.hasClass('in')) self.collapse('hide');
    });
    form.attr('method', self.attr('data-method'));
    form.find('button[type="submit"]').html(self.html());
  });

  $('.user-form').on('submit', function (ev) {
    ev.preventDefault();
    var self   = $(this);
    var action = self.attr('action');
    var method = self.attr('method');
    dialog.loading(self);

    $.ajax(action, {
      data:   self.serialize(),
      method: method,
      success: function () {
        if (method == 'FORGOT') {
          dialog.unloading(self);
          $('.form-selectors a.sign-in').click();
          $('.on-remind').removeClass('hidden');
        }
        else if ($('meta[itemprop="login"]').length) {
          location.reload();
        }
        else {
          location.href = '/';
        }
      },
      error: function (data) {
        dialog.unloading(self);
        $('.login-error').html($(data.responseText).find('.error-description').html());
      }
    });
  });

  $('.form-toggles a').on('click', function () {
    $('.' + $(this).attr('class') + '-form').collapse('toggle');
  });

  $('.date').each(function () {
    $(this).text(moment(parseInt($(this).text()) * 1000).fromNow());
  });
});
