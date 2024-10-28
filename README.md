Para rodar o projeto:

>composer install
> 
> npm install
> 
> npm i chart.js
> 

* Caso não rode
>O Projeto está usando banco de dados SQLITE,caso o projeto não rode
> 
> php.ini - alterar linha 
> > ";extension=pdo_sqlite"
> > >apagar o ";", deixando apenas "extension=pdo_sqlite"
>

> Criar arquivo chamado "database.sqlite" na pasta "database" (Stars>database)

> 
>php artisan key:generate
>
>php artisan migrate

Inicia o projeto:
>php artisan serve
>
>Entre em http://127.0.0.1:8000

> Rotas:
> 
> Como foi usado os arquivos disponibilizados, foi criado uma rota para cada um.
>
>thefuck-sample-100.json thefuck-sample-100.json
> http://127.0.0.1:8000/stars/sample100
>
>thefuck-sample-1000.json thefuck-sample-1000.json 
> http://127.0.0.1:8000/stars/sample1000
>
>
>thefuck-sample-full.json thefuck-sample-full.json)
> http://127.0.0.1:8000/stars/sampleFull


