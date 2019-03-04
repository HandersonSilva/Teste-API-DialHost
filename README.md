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

#### Domcumentação via Postman (https://documenter.getpostman.com/view/852436/S11LsdH9)

#### O arquivo para ser importado no Postman se encontra na pasta **_Doc/TESTE-API-DIALHOST.postman.json_**

## Funcionamento da API

Para o funcionamento da API é necessário cadastrar um usuário que será autenticado utilizando o passport, após a autenticação o usuario poderá cadastrar,listar,editar e excluir clientes na API de acordo com o seu nivel de permissão, estão configurado dois niveis de permissões **administrador** e **usuario**.

-   administrador -> permissões (cadastrar,listar,editar e excluir);
-   usuario -> permissões (listar);

## Processo para Autenticação

### Cadastro do usuario

Envie uma requisição para a route.

```http
POST http://localhost:8000/api/users
```

passando os dados do usuario.

```js
{
 "name":"Teste",
 "email":"teste@teste.com",
 "password":"1234"
}
```

### Gerando o token de acesso

Após ter cadastrado um usuário basta enviar uma requisição para

```http
POST http://localhost:8000/oauth/token
```

passando os seguintes dados

```js
{
"grant_type":"password",
"client_id":"3",//php artisan passport:client --password
"client_secret":"Pmo3tWtgnzBSXvu5iw3zk5A67y6x7Dl0OCi2p2mS",//php artisan passport:client --password
"username":"teste@teste.com",
"password":"1234",
"scope":"administrador"
}
```

**OBS:** O client_id e client_secret deverá ser substituido pelos os que já foram criados, assim como os dados do usuário.

O **scope** define o tipo de usuário **administrador** ou **usuario**.

```js
{
"scope":"administrador"
}
{
"scope":"usuario"
}
```

#### A API retornará o tipo do token, tempo de expiração, access_token e o refresh_token.

### Exemplo:

```js
{
    "token_type": "Bearer",
    "expires_in": 1296000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImNmYjJmYzhlNzk0NmViMzI2YjczYjNhYjExZjI1ZTRhZjE3ZGFjOGJjZDkwOTU1N2EyMjg3NzJiZmZiNDI1NDFjODdjYjE3ZTBkZmRlNjc4In0.eyJhdWQiOiIzIiwianRpIjoiY2ZiMmZjOGU3OTQ2ZWIzMjZiNzNiM2FiMTFmMjVlNGFmMTdkYWM4YmNkOTA5NTU3YTIyODc3MmJmZmI0MjU0MWM4N2NiMTdlMGRmZGU2NzgiLCJpYXQiOjE1NTE2NTQ3MzcsIm5iZiI6MTU1MTY1NDczNywiZXhwIjoxNTUyOTUwNzM3LCJzdWIiOiIxIiwic2NvcGVzIjpbImFkbWluaXN0cmFkb3IiXX0.WKqzGmso9Dnjh5vYJlJTiucedebEAtpUV8BbiyRckJ2VxuSFYbaJtodr5tgQeroZfkert09kSku2iGXQSZU3Mz9YJDksfW8GXOjbelqyPfTG7B6HnMCVxoywSyDleddB6_N3rqN8Ti2YJtlJUJyUHrMEwAn-g3bwx3nUXeNPaafpVZXpOHpp2UKxgrMEcTF-_UKM_Eo3Jaqiw_hzuK0mPD54ctFDrjpOhqcRBwYUE9bqZoE7OBy3R8psobn_Q-VmjQpFQkICI6vBN3J7ijV3NEOV9KLu_dTJiuxLzlzHLCg3BByKP2LEiDbCvlwBaJ9ixBtqa6-hrBWe4oB-fTd20M-nj0s06IqMxI6CO4x0nAJ_NOTwgR4uObSFw4CUxGwdxt9Hit4h1g90SFWaXcWqAeQuvAFBBV8hO86Dp-_b2OMhOguVF18uvcFhVHvjcr88GaCXf0IKMKWXZhI_0QV9UfuVTCwCFw01WiGx8pFFJ4zc1eM6dfF5mvddOe7JZylPa_aMX8m93PA_EgdvxNrRQijkKz9VfMCII07-lhePRhm5Pf5YaDqfP_cn3WyJ9VTvLhj41cB3pR4hWd3ZJixuoMhpleRqx26q2k-Gx1rpJuLB4HMua-6vEwXzNasPQFgP6vtAnjxjKDIvbs1CXfQN5n3nQ0uL4Xp09S6NZn6se0U",
    "refresh_token": "def502005c5c953186db5edc70c1caaa43033fd937e03294440b74e65a4bf49bd645a84e2c10b425e5e7bb86406e1dcbd68831be11ed489a3e7330cd93acb24ce2373022d58e19f3233279095753f62b899e5032b53b0c9478218223210b0c6d6a7f28d58c68bb763acb5e72d93522e4b4059cacc3f1eef07ad03d06c983db39bff5b07af56ac5e4505e3ad3e0ffd4e18c73b0260cde6a271607fe240b5cbdcd3a989d48a8cd6220bf33895fcd5df9123fdff90bbab0b8539d1a28884a67ff4158f585c6c9a86ec7677464499428f844e15a146a197a5ac45cedd3c7d83c3e4826108ffbbf57285cece7bb78d1de102463506cabb97832cd5a4191183c89a06169f70c944bb5db40e31877ff5284f0a511b750981f1fed3552c120a913c8d31ee75d0b5ed220622e9d48185009e359e06f7e2272f7789656ef37869830787b5958af9677b9b1cf35c138a836c3efa6b8085a1f9d13d5eb9ee2335f8d7f3964e6a98f178cc230e2daa49b7889b3fda077"
}
```

**OBS:** O **access_token** está configurado para expirar em 30 dias, sendo assim não há necessidade de utilizar o refresh_token para este teste.

### Com o access_token já criado basta configura-lo no Headers do postman e realizar o acesso as routes da API.

## Testando o CRUD Clientes (Para todas as rotas é necessario passar o access_token no Headers)

### Cadastro de clientes

Envie uma requisição para a route

```http
POST http://localhost:8000/api/clientes
```

passando os dados do Cliente.

```js
{
	"nome":"DialHost",
    "nome_fantasia":"DialHost",
    "seguimento":"Tecnologia",
    "cpf/cnpj":"00000000000000",
    "email":"DialHost@DialHost.com",
    "telefone":"111111111"
}
```

### Listando todos os clientes

Envie uma requisição para a route

```http
GET http://localhost:8000/api/clientes
```

API retornará todos os clientes cadastrados.

### Listando cliente por ID

Envie uma requisição para a route

```http
GET http://localhost:8000/api/cliente/{id}

```

Passando o id do cliente

```http
GET http://localhost:8000/api/cliente/1

```

API retornará o cliente cadastrado com o id enviado.

### Editando os dados do cliente

Envie uma requisição para a route

```http
PUT http://localhost:8000/api/cliente/{id}

```

Passando o id e os dados do cliente

```http
PUT http://localhost:8000/api/cliente/1

```

```js
////dados a ser alterado para o cliente id 1
{
    "email":"DialHost@DialHost.com",
    "telefone":"1212312312333"
}
```

A API retornará um objeto em json do cliente com os dados atualizados.

### Excluindo um cliente

Envie uma requisição para a route passando o ID do cliente no qual deseja excluir.

```http
DELETE http://localhost:8000/api/cliente/{id}

```

Exemplo

```http
DELETE http://localhost:8000/api/cliente/1

```

API retornará uma mensagem de sucesso ou error.

## CRUD cliente finalizado.
