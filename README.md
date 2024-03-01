# Teste de Desenvolvimento em Yii2 Framework

Este é um teste de desenvolvimento que utiliza o Yii2 Framework. Abaixo estão os requisitos e regras de negócio para este teste.

## Requisitos Obrigatórios

1. PHP 7.1
2. Composer na versão 1.10
3. Base de dados em MySQL 8
4. Usar JSON para o corpo na API

## Requisitos Desejáveis

1. Usar Docker como base para rodar, e fornecer o Dockerfile com instalação de todas dependências para validação e teste posterior
2. Estruturar base com boas práticas
3. Usar de conceitos atuais de desenvolvimento (ao critério do desenvolvedor)
4. Subir num repositório git (github por exemplo) para compartilhar
5. Montar a base por migrations do Yii2

## Regras de Negócio e Funcionamento Desejado

1. Autenticação por credencial (usuário/senha) e retorno de token (Bearer sugerido)
2. Para criar um usuário, faça um comando de terminal, que recebe o login, senha e nome desejados.
3. Todas APIs (exceto a de autenticação) devem ter a validação do token fornecido ao efetuar a autenticação, preferencialmente passar pelo Header (Authorization)
4. Desenvolver APIs para os seguintes itens:
    - Autenticação
    - Cadastro de cliente básico
        - Nome
        - CPF (com validação)
        - Dados de endereço (CEP, Logradouro, Número, Cidade, Estado, Complemento)
        - Foto
        - Sexo
    - Lista dos clientes
        - Usar paginação para o retorno
    - Cadastro de produto
        - Nome
        - Preço
        - Cliente (detentor do produto)
        - Foto
    - Lista dos produtos
        - Retornar paginado
        - Permitir filtrar pelo cliente

## Executando o Projeto
Para subir o projeto, você precisa ter o Docker e o Docker Compose instalados em sua máquina. Depois de instalados, siga os passos abaixo:

1. Acesse a raiz do projeto, via terminal
2. Execute o comando `docker-compose up -d`
3. Acesse o container da aplicação `docker-compose exec app bash` e execute:
    - `composer install`
    - `php yii migrate`
    - `php yii create-user/create <login> <senha> <nome>`
4. Acesse `localhost` no seu navegador, você deverá ver a aplicação executando

**Importante:** note que a porta padrão é a 80. Se essa porta já estiver em uso na sua máquina, você precisará alterar a porta no arquivo `docker-compose.yml`. O mesmo vale para o banco de dados MySQL na porta 3306.