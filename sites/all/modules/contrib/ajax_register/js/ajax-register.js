(function ($) {

  Drupal.behaviors.ajaxRegister = {
    attach: function (context){

      // Make modal window height scaled automatically.
      $('.ctools-modal-content, #modal-content', context).height('auto');

      // Position code lifted from http://www.quirksmode.org/viewport/compatibility.html
      if (self.pageYOffset) { // all except Explorer
        var wt = self.pageYOffset;
      }
      else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
        var wt = document.documentElement.scrollTop;
      }
      else if (document.body) { // all other Explorers
        var wt = document.body.scrollTop;
      }

      // Fix CTools bug: calculate correct 'top' value.
      var mdcTop = wt + ( $(window).height() / 2 ) - ($('#modalContent', context).outerHeight() / 2);
      $('#modalContent', context).css({
        top: mdcTop + 'px'
      });
    }
  }

  Drupal.theme.prototype.customTheme = function () {
    var html = ''
    html += '  <div id="ctools-modal">'
    html += '  <div class="popup-container">'
    html += '    <div class="ctools-modal-dialog">'
    html += '      <div class="popup-box">'
    html += '        <div class="modal-header popup-header">';
    html += '         <a href="#"><img src="/sites/all/themes/local_fixer/images/sm-logo.png" alt="LOCAL fixer"/></a>';
    html += '         <span><a href="#" class="close" data-dismiss="modal" aria-hidden="true" title="Close"><img src="/sites/all/themes/local_fixer/images/close-icon.png" alt="Close"/></a></span>';
    html += '         </div>';
    html += '        <div id="modal-content" class="modal-body popup-data">';
    html += '        </div>';
    html += '        <div class="popup-footer clearfix">';
		html += '        </div>';
    html += '      </div>';
    html += '    </div>';
    html += '    </div>';
    html += '  </div>';
    return html;
  }
  
  Drupal.theme.prototype.customthrobberTheme = function () {
    var html = '';
    html += '  <div class="loading-spinner" style="width: 200px; margin: -20px 0 0 -100px; position: absolute; top: 45%; left: 50%">';
    html += '    <div class="progress progress-striped active">';
    html += '      <div class="progress-bar" style="width: 100%;"></div>';
    html += '    </div>';
    html += '  </div>';
    return html;
  }
  

})(jQuery);
