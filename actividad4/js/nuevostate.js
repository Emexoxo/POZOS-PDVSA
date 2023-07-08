if(window.history.replaceState) {
    console.log('Funciona');
    window.history.replaceState(null, null, window.location.href);
}