// FUNÇÃO SOMENTE NUMEROS - USAR ESTE COMANDO NO CAMPO TIPO "TEXT" PARA FAZER O BLOQUEIO  onkeypress="return onlynumber();"
function onlynumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /^[0-9]+$/;
    if( !regex.test(key) ) {
       theEvent.returnValue = false;
       if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

