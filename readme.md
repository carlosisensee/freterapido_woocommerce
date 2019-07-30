![Frete Rápido - Sistema Inteligente de Gestão Logística](https://freterapido.com/imgs/frete_rapido.png)

<hr>

### Módulo para plataforma WooCommerce

Versão do módulo: 1.0.5

Versão mínima de utilização do PHP: **5.4**

Compatibilidade com WooCommerce: **2.6.x** ao **3.2.x**

Links úteis:

- [Painel administrativo][2]
- [suporte@freterapido.com][3]

---------------

### IMPORTANTE

Este módulo é apenas um referencial de integração e cabe ao cliente a função de configurá-lo e adaptá-lo a sua respectiva loja, levando em conta as particularidades e conflitos que podem surgir durante o processo de integração.

A Frete Rápido não mantem e/ou oferece suporte para a integração com o **WooCommerce**, disponibilizamos o módulo padrão que atente a modalidade de envio simples.

**Este módulo não opera Dropshipphig!**

Caso seja necessário adaptações deste módulo para atender a sua loja, é possível alterar o código fonte, desde que atenda a [API da Frete Rápido][8]. E [neste link][7] você encontra a documentação de orientações do **WooCommerce**.

A Frete Rápido não se responsabiliza por eventualidades advindas deste módulo.

---------------

### Plugin adicional

Para o correto funcionamento do módulo do Frete Rápido é **obrigatória** a utilização do plugin [WooCommerce Extra Checkout Fields for Brazil][9] para que sejam informados os campos adicionais do destinatário durante o checkout, como CPF, RG, CNPJ e Inscrição Estadual.
A instalação é simples, basta seguir os passos no seu painel WordPress:

1. Acesse o menu **Plugins** > **Adicionar novo**
2. No campo de pesquisa procure por **WooCommerce Extra Checkout Fields for Brazil**
3. Quando aparecer o plugin pesquisado clique em **Instalar** e depois em **Ativar**
4. Depois de instalado, basta acessar o menu **WooCommerce** > **Campos do checkout** e realizar as configurações do plugin

Para mais informações você pode visitar o link do plugin no [WooCommerce.org][9] ou [Github][10].

---------------

### Instalação

>**ATENÇÃO!** Recomendamos que seja feito backup da sua loja antes de realizar qualquer instalação. A instalação desse módulo é de inteira responsabilidade do lojista.

---------------

# Documentação Frete Rápido

##  - [Configurações iniciais](https://freterapido.com/wiki/docs/integrations/woocommerce/#instalacao).

1. [Configuração do módulo](https://freterapido.com/wiki/docs/integrations/woocommerce/#_1-configuracoes-do-modulo).

2. [Medidas e Prazo de envio](https://freterapido.com/wiki/docs/integrations/woocommerce/#_2-medidas-peso-e-prazo).

3. [Categorias](https://freterapido.com/wiki/docs/integrations/woocommerce/#_3-categorias).

##  - [Contratação do Frete](https://freterapido.com/wiki/docs/integrations/woocommerce/#contratacao-do-frete).

##  - [Cotação de frete na página do produto](https://freterapido.com/wiki/docs/integrations/woocommerce/#cotacoes-de-frete-na-pagina-do-produto).

---------------

### Considerações finais:
1. Para obter cotações dos Correios é necessário configurar o seu contrato com os Correios no [Painel administrativo do Frete Rápido][2] > Integrações > Correios.
2. Esse módulo atende solicitações de coleta para destinatários Pessoa Física. Para atender Pessoas Jurídicas, o módulo pode ser adaptado por você de acordo com a [API da Frete Rápido][8].

--------

### Contribuições
Encontrou algum bug ou tem sugestões de melhorias no código? Sensacional! Não se acanhe, nos envie um *pull request* com a sua alteração e ajude este projeto a ficar ainda melhor.

1. Faça um "Fork"
2. Crie seu branch para a funcionalidade: ` $ git checkout -b feature/nova-funcionalidade`
3. Faça o commit suas modificações: ` $ git commit -am "adiciona nova funcionalidade"`
4. Faça o push para a branch: ` $ git push origin feature/nova-funcionalidade`
5. Crie um novo Pull Request

---------------

### Licença
[MIT][5]


[2]: https://freterapido.com/painel/?origin=github_woocommerce "Painel do Frete Rápido"
[3]: mailto:suporte@freterapido.com "E-mail para a galera super gente fina :)"
[5]: https://github.com/freterapido/freterapido_woocommerce/blob/master/LICENSE
[7]: https://woocommerce.com/developers/
[8]: https://www.freterapido.com/dev/
[9]: https://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/
[10]: https://github.com/claudiosanches/woocommerce-extra-checkout-fields-for-brazil
