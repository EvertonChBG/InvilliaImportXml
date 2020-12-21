# Desafio Invillia

Resultado do Teste para desenvolvedor Senior na Invilia.

## Desafio
- Criar um aplicativo para carregar manualmente os XMLs fornecidos (people.xml e shiporders.xml) e
tenha uma opção para processá-los de forma assíncrona.



## Objetivos
- Symfony / Laravel
- Imagens do Docker usadas
- Uma página de índice para fazer upload do XML com um botão para processá-lo. (normal ou assincrono)
- Rest APIs para os dados XML, apenas os métodos GET.
- Criação de Testes Automatizados.
- README.md com as instruções para instalar o aplicativo.

### Pontos bônus: ###

- Método de autenticação para as APIs.
- Documentação gerada para as APIs.



## Execução da Aplicação

Observações:
- `Após iniciar as containers, será iniciado o scheduler que ficará monitorando as atividades de importação
pendentes, Estás atividades são processos definidos como assincronos durante a importação.`

- `Os Erros pertinentes a chaves duplicadas no banco de dados será armazenado em log e também será 
apresentado como retorno na tela inicial da importação`
  
- `As Importações Assicronas, está sendo logado em um arquivo cron.log as ações realizadas junto
  com o tempo de processamento.`

Para iniciar a execução das containers:

- `docker-compose up --build`

Uma solução não elegante mas como trabalhei com os fontes mapeado pelo volume no docker-compose.yml, é preciso:

- `sudo chmod 777 src/storage -Rf`

Para Criar a estrutura/Dados do banco de dados:

- `docker-compose exec app php artisan migrate`
- `docker-compose exec app php artisan db:seed`

Comando para compilar os Js e Css

- `docker-compose exec app npm install`
- `docker-compose exec app npm run prod`

Após iniciadas, será possível o acesso via nevegador através do endereço:

[http://localhost:8100/](http://localhost:8100/)

A Documentação da api está disponível através do endereço:

[http://localhost:8100/api/documentation](http://localhost:8100/api/documentation)

