//Função para validar o CEP:
function validation(){
	//Se o campo estiver vazio:
	if(document.form.cep.value==""){
		alert("Por favor, preencha o campo CEP.");
		document.form.cep.focus();
		return false;
	}
	//Se o tamanho for !=9 (pois o CEP possui oito números e um hífen, resultando em 9 caracteres):
	if(document.form.cep.value.length!=9){
		alert("O CEP deve conter 8 números.");
		document.form.cep.focus();
		return false;
	}
}
//Função para permitir somente números
function number(evt){
	var theevent=evt || window.event;
	var key=theevent.keyCode || theevent.which;
	key=String.fromCharCode(key);
	var regex=/^[0-9.]+$/;//Especificação de dígitos
	if(!regex.test(key)){
		theevent.returnValue=false;
		if(theevent.preventDefault){
			theevent.preventDefault();
		}
	}
}
//Função para colocar hífen do CEP:
function mask(){
	var cep=document.getElementById('cep');
	if(cep.value.length==5){
		cep.value+="-";
	}
}