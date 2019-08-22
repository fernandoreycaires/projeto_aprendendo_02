
function momento(){
    var msg = window.document.getElementById('msg')
    var data = new Date()
    var hora = data.getHours()
    var minu = data.getMinutes()

    //Acrscenta um 0 nos minutos abaixo de 9
    if (minu < 9 ){
        minu = '0' + minu
    }

    //verifica a hora do dia e alterna a imagem do backgroug e mostra a hora 
    
    if (hora >= 0 && hora < 12){
        //BOM DIA
        msg.innerHTML = 'Bom dia !'
        msg.style.color = 'black' 
        document.body.background = '../storage/manha.jpg'
    }else if (hora >= 12 && hora <= 18){
        // BOA TARDE
        msg.innerHTML = 'Boa tarde !'
        msg.style.color = 'rgb(231, 231, 231)'  
        document.body.background = '../storage/tarde.jpg'
    }else {
        //BOA NOITE
        msg.innerHTML = 'Boa noite !'
        msg.style.color = 'white' 
        document.body.background = '../storage/noite.jpg'
    }

    msg.innerHTML += ` Agora são ${hora}:${minu}`
}