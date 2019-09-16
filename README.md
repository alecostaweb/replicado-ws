# Replicado-WS

Web Service para acesso aos dados do Replicado USP

## Configuração

* Renomear o arquivo config/config.sample.php para config/config.php
* Inserir no arquivo config.php 
    * Domínio de acesso ao Web Service 
    * Credenciais para acesso a base de dados de replicacao da USP
* Configurar o Apache para apontar para a pasta www/
* Instalar as dependências do composer
    * ```composer update```

## Testes

Há alguns testes simples de verificação do funcionamento. Longe de ser unit teste ou algo assim mas se rodar direitinho quer dizer que as configurações gerais estão corretas.
```bash
php test/not_found.php
php test/require_auth.php
```

## Utilização

Acessar URL do serviço desejado com os parâmetros necessários. O retorno dos dados será em JSON .

Exemplos

Acessando o endereço ```http://{dominio}/``` pelo navegador, vai retornar

```
{
    "posgraduacao_url": "http://{dominio}/posgraduacao",
    "pessoa_url": "http://{dominio}/pessoa",
    "login_url": "http://{dominio}/login",
    "logout_url": "http://{dominio}/logout"
}
```

Para mostrar os programas de Pós-Graduação da unidade devemos acessar:

```
http://{dominio}/posgraduacao/programas/
```

## Consumidores

Há alguns exemplos de aplicações consumindo dados da API em <code>/consumers</code>.

## Informações disponíveis

Em princípio estarão disponíveis os métodos do uspdev/replicado mas nem todos estão implementados.

Navegando pela API ele mostrará os endpoints disponíveis com a respectiva documentação.