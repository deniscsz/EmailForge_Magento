EmailForge_Magento
==================

Sobre o Módulo
--------------

O módulo fornece a integração entre o Magento e a ferramenta EmailForge da Splio. Através do módulo os emails recolhidos da inscrição de Newsletter do Magento são inseridos automaticamente nas suas listas de email podendo segmenta-los por alguns campos padrões.

O módulo também fornece uma rota (controller) onde é possível fazer a integração de qualquer formulário personalizado (busca, formulário de contato, modais e pop ups) através de javascript.

Requerimentos
--------------

- Magento 1.4.2.0 ou superior
- PHP 5.2.0 ou superior

Observações
--------------

- A URL que seu formulário personalizado deve fazer o POST com o email e listas de emails (devem existir previamente no EmailForge) é "http://<MagentoBaseUrl>/emailforge/splio/contact". Você pode utilizar qualquer formulário dentro do seu domínio para cadastrar email em suas bases desde que o destino do post esteja correto.

Veja um exemplo:

    var email_value = "teste@mail.com.br";
    jQuery.post("http://meusite.com.br/emailforge/splio/contact",{email:email_value,lists:"MyListEmail"},function(result) {
		if(result) {
			alert('O email '+email_value+' foi cadastrado com sucesso');
		}
    });
	
Bugs?
--------------
Utilize o próprio GitHub para reportar problemas ou entre em contato comigo via email: denis dot spalenza (at) xpdev dot com dot br