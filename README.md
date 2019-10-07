# Replicado-WS

Web Service para acesso aos dados do Replicado USP

## Configuração

* Copiar o arquivo config/config.sample.php para config/config.php
* Inserir no arquivo config.php 
    * Domínio de acesso ao Web Service 
    * Credenciais para acesso à base de dados de replicacao da USP
* Configurar o Apache para apontar para a pasta ```www/```
* Instalar as dependências do composer
    * ```composer update```

A API faz uso do uspdev/cache. Essa biblioteca de cache funciona com o memcached e ele precisa ser instalado e configurado. Para mais informações consulte http://github.com/uspdev/cache.

## Testes

Há alguns testes simples de verificação do funcionamento. Longe de ser unit teste ou algo assim mas se rodar direitinho quer dizer que as configurações gerais estão corretas.

```bash
php test/not_found.php
php test/require_auth.php
```

## Utilização

Acessar URL do serviço desejado com os parâmetros necessários. O retorno dos dados será em JSON.

### Exemplo 1

Acessando o endereço ```http://{dominio}/``` pelo navegador, vai retornar

```
{
    "posgraduacao_url": "http://{dominio}/posgraduacao",
    "pessoa_url": "http://{dominio}/pessoa",
    "login_url": "http://{dominio}/login",
    "logout_url": "http://{dominio}/logout"
}
```

### Exemplo 2

Para mostrar os programas de Pós-Graduação da unidade devemos acessar:

```
http://{dominio}/posgraduacao/programas/
```

## Consumidores

Há alguns exemplos de aplicações consumindo dados da API em <code>/consumer</code>.

## Informações disponíveis

Em princípio estarão disponíveis os métodos do uspdev/replicado mas nem todos estão implementados.

Navegando pela API ele mostrará os endpoints disponíveis com a respectiva documentação.

[Lista de endpoints disponíveis](doc/endpoints.md)

## Contribuindo nesse projeto

Ao inserir um novo endpoint ou modificar alguma coisa é importante atentar ao ```$help``` do endpoint. Essa documentação é exibida para o consumidor e é usada para gerar o arquivo ```doc/endpoints.md```. 

Para atualizar esse arquivo rode ```php doc-generator.php``` que ele irá coletar a documentação de fato exibida considerando o config.php local.

Antes de mexer no código abra uma issue e discuta com os mantenedores. Só depois faça um pull request seguindo o modelo fork->branch_da_issue->pull request.