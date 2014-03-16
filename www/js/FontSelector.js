/**
* Font selector plugin
* turns an ordinary input field into a list of web-safe fonts
* Usage: $('select').fontSelector(options);
* You can pass in the following options:
* value        :    the initial value of the select field
* onChange :    a function to call when a new value is chosen
*
* Author     : James Carmichael
* Website    : www.siteclick.co.uk
* License    : MIT
*/
jQuery.fn.fontSelector = function(settings) {
 
  var fonts = new Array(
    'Arial,Arial,Helvetica,sans-serif',
    'Arial Black,Arial Black,Gadget,sans-serif',
    'Comic Sans MS,Comic Sans MS,cursive',
    'Courier New,Courier New,Courier,monospace',
    'Georgia,Georgia,serif',
    'Impact,Charcoal,sans-serif',
    'Lucida Console,Monaco,monospace',
    'Lucida Sans Unicode,Lucida Grande,sans-serif',
    'Palatino Linotype,Book Antiqua,Palatino,serif',
    'Tahoma,Geneva,sans-serif',
    'Times New Roman,Times,serif',
    'Trebuchet MS,Helvetica,sans-serif',
    'Verdana,Geneva,sans-serif' );
   
  return this.each(function() {
     
    // Store the input field
    var sel = this;
     
    /* add individual font divs to fonts */
    jQuery.each(fonts, function(i, item) {
       
      // Add option to selector
      jQuery(sel).append('<option value="' + item + '">' + item.split(',')[0] + '</option>');
       
      // Select initial value
      if (item == settings.value)
        jQuery(sel).children('option:last').attr('selected', 'selected');
   
    })
    
    // Bind onchange event handler
    if(settings.onChange)
      jQuery(sel).bind('change',    settings.onChange);
    
  });
}
