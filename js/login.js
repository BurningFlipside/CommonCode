function loginSubmitted(e) {
  e.preventDefault();
  let url = document.body.dataset.loginUrl;
  if(url === undefined) {
    let dir  = document.querySelector('script[src*=login]').getAttribute('src');
    let parts = dir.split('/');
    dir = parts.slice(0, parts.length-3).join('/');
    url = dir+'/api/v1/login';
  }
  let form = e.target.form;
  fetch(url, {
    method: 'POST',
    body: new URLSearchParams(new FormData(form))
  }).then(response => {
    if(response.ok) {
      return response.json();
    } else {
      let failed = getParameterByName('failed')*1;
      let return_val = window.location;
      failed++;
      window.location = window.loginUrl+'?failed='+failed+'&return='+return_val;
    }
  }).then(data => {
    let url = '';
    if(data['return']) {
      url = data['return'];
    } else {
      url = getParameterByName('return');
      if(url === null) {
        url = window.location;
      }
    }
    if(data.extended) {
      console.log(data.extended);
    }
    window.location = url;
  });
  return false;
}

function login_dialog_shown()
{
    $('[name=username]').focus();
}

function retryBootstrap() {
  if($('#login-dialog').modal === undefined) {
    window.setTimeout(retryBootstrap, 100);
    return;
  }
  $('#login-dialog').modal({show: false, backdrop: 'static'});
  $('#login-dialog').on('shown.bs.modal', login_dialog_shown);
}

function doLoginInit() {
  let loginLink = document.querySelector('ul a[href*=login]');
  if(loginLink !== null) {
    if(window.browser_supports_cors !== undefined && browser_supports_cors()) {
      loginLink.setAttribute('data-bs-toggle', 'modal');
      loginLink.setAttribute('data-bs-target', '#login-dialog');
      loginLink.removeAttribute('href');
      loginLink.style.cursor = 'pointer';
      loginLink = document.querySelector('#content a[href*="login"]');
      if (loginLink !== null) {
        loginLink.setAttribute('data-bs-toggle', 'modal');
        loginLink.setAttribute('data-bs-target', '#login-dialog');
        loginLink.removeAttribute('href');
        loginLink.style.cursor = 'pointer';
      }
    } else {
      loginLink.setAttribute('href', loginLink.getAttribute('href')+'?return='+document.URL);
    }
  }
  let mainForm = document.getElementById('login_main_form');
  if(mainForm !== null) {
    mainForm.querySelector('button[type=submit]').addEventListener('click', loginSubmitted);
  }
  let dialogForm = document.getElementById('login_dialog_form');
  if(dialogForm !== null) {
    dialogForm.querySelector('button[type=submit]').addEventListener('click', loginSubmitted);
  }
  let loginDialog = document.getElementById('login-dialog');
  if(loginDialog !== null) {
    retryBootstrap();
  }
}

function retryInit() {
  if($ != undefined) {
    $(doLoginInit);
  } else {
    window.setTimeout(retryInit, 200);
  }
}

window.addEventListener('load', retryInit);
