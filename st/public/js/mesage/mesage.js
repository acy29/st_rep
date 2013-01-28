  
/*
*Default use with guide
*/
  function generate(type) {
  	var n = noty({
  		text: type,// text
  		type: type,// type of msj
      dismissQueue: true,
  		layout: 'topRight',// topRight .js posicion of msj (required extra-js)
  		theme: 'defaultTheme'// default.js
  	});
  }


  function generateAll() {
    generate('alert');
    generate('information');
    generate('error');
    generate('warning');
    generate('notification');
    generate('success');
  }
  
  $(document).ready(function() {
    //generateAll();//*** uncomment for all examples
  });

/*
*Produccion
*/
  function notification(type) {
    var n = noty({
      text: type,
      type: 'notification',
      dismissQueue: true,
      layout: 'topRight',
      theme: 'defaultTheme'
    });
    setTimeout(function() {
      $.noty.closeAll();
    }, 10000);
  }

  function error(type) {
    var n = noty({
      text: type,
      type: 'error',
      dismissQueue: true,
      layout: 'topRight',
      theme: 'defaultTheme'
    });
    setTimeout(function() {
      $.noty.closeAll();
    }, 10000);
  }

  function success(type) {
    var n = noty({
      text: type,
      type: 'success',
      dismissQueue: true,
      layout: 'topRight',
      theme: 'defaultTheme'
    });    
    setTimeout(function() {
      $.noty.closeAll();
    }, 10000);
  }

  function information(type) {
    var n = noty({
      text: type,
      type: 'information',
      dismissQueue: true,
      layout: 'topRight',
      theme: 'defaultTheme'
    });
    setTimeout(function() {
      $.noty.closeAll();
    }, 10000);
  }
