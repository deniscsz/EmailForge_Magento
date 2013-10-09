EmailForge_Magento
==================

Sobre o M�dulo
--------------

O m�dulo fornece a integra��o entre o Magento e a ferramenta EmailForge da Splio. Atrav�s do m�dulo os emails recolhidos da inscri��o de Newsletter do Magento s�o inseridos automaticamente nas suas listas de email podendo segmenta-los por alguns campos padr�es.

O m�dulo tamb�m fornece uma rota (controller) onde � poss�vel fazer a integra��o de qualquer formul�rio personalizado (busca, formul�rio de contato, modais e pop ups) atrav�s de javascript.

Requerimentos
--------------

- Magento 1.4.2.0 ou superior
- PHP 5.2.0 ou superior

Observa��es
--------------

- A URL que seu formul�rio personalizado deve fazer o POST com o email e listas de emails (devem existir previamente no EmailForge) � "http://<MagentoBaseUrl>/emailforge/splio/contact". Voc� pode utilizar qualquer formul�rio dentro do seu dom�nio para cadastrar email em suas bases desde que o destino do post esteja correto.

Veja um exemplo:

    var email_value = "teste@mail.com.br";
    jQuery.post("http://meusite.com.br/emailforge/splio/contact",{email:email_value,lists:"MyListEmail"},function(result) {
		if(result) {
			alert('O email '+email_value+' foi cadastrado com sucesso');
		}
    });
	
Bugs?
--------------
Utilize o pr�prio GitHub para reportar problemas ou entre em contato comigo via email: denis dot spalenza (at) xpdev dot com dot br