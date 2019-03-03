# Teste-API-DialHost

## Sobre API

A API é um CRUD de clientes criado utilizando o framework laravel e banco de dados mysql com autintacação em dois niveis de acesso administrador e usuario comum usando o Passport.

## Requesitos

-   php = "^7.1.3".
-   laravel = "5.8.\*".
-   passport= "^7.2".
-   mysql.
-   Composer.

## Funcionalidades

-   Cadastro de usuário para autenticação;
-   Criação de token de acesso;
-   Cadastro de clientes;
-   Listagem de todos os clientes;
-   Listagem de clientes por ID;
-   Edição de clientes;
-   Exclusão de clientes;
-   Gerenciamento de acesso através de token;
-   Validação de dados utilizando o Validation do laravel;

## Instalação

Realize o clone do projeto (https://github.com/HandersonSilva/Teste-API-DialHost.git).

Crie um banco de dados no mysql e utilize o Arquivo .env.example para configura-lo no projeto;

### Instalando dependencias;

-   composer install

#### Criando as tabelas no banco

-   php artisan migrate

#### Rode o comando seguinte para gerar as chaves de acesso do Passport

-   php artisan passport:install

#### Criando a chave de acesso para um cliente externo

-   php artisan passport:client --password

O comando **php artisan passport:client --password** vai gerar um client_id e client_secret que será usado para realizar a requisição do token de acesso a API.

#### Exemplo:

```js
Client ID: 3
Client secret: Pmo3tWtgnzBSXvu5iw3zk5A67y6x7Dl0OCi2p2mS
```

#### Gerando a Key do projeto

-   php artisan key:generate

Pronto após o comando **php artisan key:generate** a API já está configurada, para testar basta excutar o comando **php artisan serve** e utilizar um aplicativo ou o navegador para acessar a route http://localhost:8000/api/, se estiver tudo certo você terá o retorno "Teste API Rest DialHost".

## Corrigindo retorno de tela de login padrão do laravel para usuário não autenticado.

Caso o usuário tente acessar uma route na qual não está autorizado a API irá retornar a tela padão de login para que o usuário se autentique, para resolver isso acesse a seguinte class **vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php** e altere o metodo **unauthenticated** para:

```php
protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
        ? response()->json(['message' => 'Usuário não autorizado'], 401)
        : response()->json(['message' => 'Usuario nao autorizado'], 401);
    }
```

#### Pronto, agora sempre que o usuário não estiver autenticado o retorno será sempre uma mensagem.

## Conteudo útil para realizar o teste da API

Para realização dos teste e acesso as funcionalidades da API foi utilizado a aplicação **Postman**, sendo assim segue o link da documentação da API postman e o arquivo utilizado no desenvolvimento da API.

### Domcumentação via Postman (https://documenter.getpostman.com/view/852436/S11LsdH9)

### Arquivo para ser importado no Postman se encontra na pasta **_Doc/TESTE-API-DIALHOST.postman.json_**
