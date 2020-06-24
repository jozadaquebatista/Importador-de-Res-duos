# Backend Developer

## Waste Importer (PHP + Laravel)
Done for a back-end developer test

### Objetivo do produto a ser entregue

Criar uma API RESTful que:

- Receberá uma planilha de residuos (segue em anexo) que deve ser processada em background (queue).

- Ter um endpoint que informe se a planilha for processada com sucesso ou não.

- Seja possível visualizar, atualizar e apagar os resíduos (só é possível criar novos produtos via planilha).
 
--

## (Em processo) Rotas da Aplicação

**Wastes** = Resíduos

**Transaction** = Planilha

- O banco de dados resolvi fazer utilizando sqlite, apenas para facilitar a avaliação de análise, então para funcionar, só é necessário criar um arquivo vazio com o nome "database.sqlite" dentro do diretório database. 

- Para testar, é importante executar os comando abaixo nessa ordem:

1) php artisan queue:table; // cria o arquivo de migrations dos jobs
2) php artisan migrate; // realiza as migrations 
3) php artisan db:seed; // alimenta a base wastes com dados pré-definidos
4) php artisan queue:work // executa a queue

## POST 
**insere os resíduos da planilha, na view home.blade.php tem um formulário de exemplo para fazer envio, essa rota também atualiza os resíduos(mais informações no código)**

    - url: api/v1/wastes

## GET
**retorna todos os resíduos de forma paginada**

    - url: api/v1/wastes


## GET
**retorna todos os resíduos inseridos para uma determinada planilha**

    - url: api/v1/wastes/{transaction}

## PUT
**faz o mesmo que a rota POST, não sei se manterei essa rota**

    - url: api/v1/wastes/{transaction}

## DELETE
**deleta um resíduo específico, passando o seu Id**

    - url: api/v1/wastes/{id}

- As {transactions} são um tipo de uuid(token randômico) para os recursos criados(para cada planilha é criado um) através da Queue, elas são necessárias pois o cliente precisa de uma forma para consultar o status das planilhas de resíduos posteriosmente.

- Quando um recurso é criado através do POST automaticamente é retornado um hash de transação, o cliente pode usa-lo para consultar o status dos resíduos


## (Em processo) Testes Automatizados ...
    -...
