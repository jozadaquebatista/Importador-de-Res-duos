# Waste Importer (PHP + Laravel)

Done for a back-end developer test
### Objetivo do produto a ser entregue

Criar uma API RESTful que:

- Receberá uma planilha de residuos (segue em anexo) que deve ser processada em background (queue).

- Ter um endpoint que informe se a planilha for processada com sucesso ou não.

- Seja possível visualizar, atualizar e apagar os resíduos (só é possível criar novos produtos via planilha).

--------

## Explicação de alguns termos

**Wastes** = Resíduos

**Transaction** = Planilha

## Enpoints da Aplicação

- As **{transactions}** são um tipo de uuid(token randômico único) para cada planilha que é importada, esse token é necessário pois o cliente precisa de uma forma para consultar o status das planilhas de resíduos posteriosmente.

- Quando um recurso é criado através do POST automaticamente é retornado um hash de transação que indentifica a planilha, o cliente pode usa-lo para consultar o os registros importados com sucesso da planilha realizando um GET em **api/v1/wastes/{transaction}**.

-------

- O banco de dados resolvi fazer utilizando sqlite, apenas para facilitar a avaliação, então para funcionar, só é necessário criar um arquivo vazio com o nome "database.sqlite" dentro do diretório database. 

- Para testar, é importante executar os comando abaixo nessa ordem:

    1) **php artisan migrate**; // ou php artisan migrate:fresh, realiza as migrations
    2) **php artisan db:seed**; // alimenta a base wastes com dados pré-definidos
    3) **php artisan queue:work**; // executa a queue, executar em um terminal diferente do passo 4
    4) **php artisan serve**; // inicia o servidor, executar em um terminal de comando diferente do passo 3)

**Status Codes**
- Os endpoints podem retornar apenas 2 tipos:
    - **200**: significa que houve sucesso na operação
    - **400**: significa que houve algum tipo de problema com os dados enviados pelo cliente

## POST 
**insere os resíduos da planilha, na view home.blade.php tem um formulário de exemplo para fazer envio, essa rota também atualiza os resíduos(mais informações no código)**

    - url: api/v1/wastes (Content-type: multipart/form-data)

## GET
**retorna todos os resíduos de forma paginada**

    - url: api/v1/wastes (Content-type: application/json)


## GET
**retorna todos os resíduos inseridos para uma determinada planilha**

    - url: api/v1/wastes/{transaction} (Content-type: application/json)

## PUT
**faz o mesmo que a rota POST**

    - url: api/v1/wastes/{transaction} (Content-type: application/json)

## DELETE
**deleta um resíduo específico, passando o seu Id**

    - url: api/v1/wastes/{id} (Content-type: application/json)
    
- Nota: não fiz um endpoint específico para retornar o status da planilha, pois o seguinte **api/v1/wastes/{transaction}** retorna os registros inseridos com sucesso(e não a planilha inteira), resolvi que o endpoint poderia commitar a planilha, mesmo que algum registro não tenha sido inserido, isso o cliente poderia verificar fazendo uma comparação, caso retorne um array vazio, quer dizer que não não houve sucesso ao tentar importar a planilha e algo aconteceu de errado. Caso tenha algum erro, o cliente poderá enviar novamente a mesma planilha com as alterações.

## Testes Automatizados ...

- Para executar os testes, executar o seguinte comando:
    - **php artisan test**
