# Eventos FAPESP

### Introdução
O sistema de eventos será desenvolvido em **Laravel**[^1] *(versão 5.6)* e utilizando tecnologias complementares no *front-end* como o **LESS**[^2] para estilos das páginas *(CSS)*, além do **ECMAScript 6**[^3] e **VueJS**[^4] no javascript. Para comportar essas tecnologias e agilizar o processo de desenvolvimento foi configurado no projeto o *Webpack* para automatizar as tarefas de compilação como *LESS*, *ES6* e outros.

#### Pré Requisitos
1. PHP *>= 7.1.3*
2. Git
3. Composer
4. NodeJS

#### Iniciando e Configurando o Ambiente
Atendendo os requisitos citados no item anterior, seguir os seguintes passos:
1. Realizar o download do repositório para uma pasta, **detalhes na sessão *git***
2. Entrar na pasta do repositório e realizar a instalação das dependências
    * **PHP:** `php composer.phar update` ou `composer update`
    * **Javascript:** `npm install`
3. Gerar o arquivo com as configurações do sistema. `composer post-root-package-install`
4. Atualizar as configurações de banco de dados para rodar através do seu banco de dados local
5. Rodar os comandos para gerar as tabelas do banco de dados `php artisan migrate`
5. Rodar comando para adicionar os dados iniciais do banco de dados `php artisan db:seed`

#### Rodando o Ambiente de Desenvolvimento
Para inicializar e utilizar o sistema você precisa subir o servidor **PHP** e o renderizador **javascript**[^5], para isso será utilizado **artisan**[^6] que é uma importante ferramenta que irá auxíliar em diversas tarefas durante o processo de desenvolvimento.

**Servidor:** `composer init-server` ou `php artisan serve --port=3000`  
**Renderizador:** `npm watch`

---

### Git

Aqui iremos apresentar uma breve introdução de como trabalhar em projetos utilizando o Git para que flua melhor e com o menor número de problemas possíveis.

#### 1. Baixando um repositório
Para realizar o download de um repositório existente basta executar seguinte comando `git clone http://192.168.0.53:8080/REPOSITORIO.git` que o sistema do git cria uma pasta com o mesmo nome do repositório com o conteúdo do mesmo dentro. Caso necessite/deseje criar o repositório em uma pasta com nome específico você pode executar o mesmo comando indicando a pasta de destino `git clone http://192.168.0.53:8080/REPOSITORIO.git ./PASTA_DE_DESTINO`.

#### 2. Processo
Nesta sessão vamos explanar um pouco a forma com a qual será trabalhado o **Git** dentro do ecossistema da empresa.

##### 2.1 Iniciando uma nova tarefa
Sempre que formos iniciar uma nova tarefa devemos nos atentar a alguns pontos muito importantes para evitarmos transtornos referente a perda de dados dos outros colaboradores.

Segue abaixo o passo-a-passo do processo, da criação da branch até a subida para produção.

##### 2.1.1 Cria uma branch referente a tarefa
```bash
git checkout -b NOME_DA_BRANCH
```

##### 2.1.2 Fazendo o commit e push da solução
```bash
git commit -m "DESCRIÇÃO"
git push origin NOME_DA_BRANCH
```

##### 2.2 Jogando a solução para a branch de desenvolvimento

Após concluir todo o escopo da tarefa, a mesma passar pela revisão e está pronta para ir o servidor de desenvolvimento devemos subir a mesma para branch development.

##### 2.2.1 Faz checkout para a development para fazer um pull
```bash
git checkout development
git pull origin development
```

##### 2.2.2 Retorna a branch da tarefa para fazer *reabase*
```bash
git checkout NOME_DA_BRANCH
git rebase development
```

##### 2.2.3 Executar merge em development
```bash
git checkout development
git merge NOME_DA_BRANCH
git push origin development
```
<sup>**Ps.:** Em caso de dúvida se tudo ocorreu corretamente, solicitar auxílio para não correr o risco de acabar removendo sem querer algo de outro desenvolvedor, entre outros.</sup>

##### 2.2.4 Deixando a branch no mesmo estados da master
```bash
git checkout NOME_DA_BRANCH
git push origin NOME_DA_BRANCH -f
```

##### 2.2.5 Finalizando o processo
```bash
git checkout development
```

[^1]: **Laravel Framework**<br>O *Laravel* é um framework baseado no já consagrado *Symphony* e tem como base o desenvolvimento rápido para *PHP*. Vem com a ideia de software livre e de código aberto, cujo o principal objetivo é permitir que você trabalhe de forma estruturada e rápida, utilizando-se de diversos *Design Patter* já enraizados no framework.<br><br>Ele trabalha em cima do modelo já muito conhecido *MVC* e possui diversos recursos que simplificam e agilizam o desenvolvimento, tais como, o *Eloquent* que é um ótimo *ORM (eu não o considero um ORM por não fazer um real mapeamento como ocorre no Doctrine do Symphony, mas mesmo assim é uma excepcional ferramenta)* e possui um dos melhores *QueryBuilder* em *PHP*. Para uma melhor familiaridade com o laravel pode ver os posts do *João Roberto* no *[Medium](https://medium.com/joaorobertopb/laravel-al%C3%A9m-do-b%C3%A1sico-0-introdu%C3%A7%C3%A3o-96d37a938d14)* que explica bem a base do framework e [esse outro](https://medium.com/joaorobertopb/o-que-%C3%A9-laravel-porque-us%C3%A1-lo-955c95d2453d) que explica bem o que é o *Laravel*.

[^2]: **LESS Stylesheet**<br>O *LESS* é uma linguagem de folha de estilos dinâmica desenhada por *Alexis Sellier*. Teve como sua principal influência o *Sass* e em contra partida, influênciou a nova sintaxe da *Sass (SCSS)*, que adaptou sua sintaxe de formação de blocos do tipo *CSS*. A sintaxe indentada do *LESS* é uma metalinguagem aninhada, uma vez que um código válido em *CSS* também é válido nele e tem a mesma semântica.<br><br>O *LESS* fornece os seguintes mecanismos: variáveis, aninhamento, mixins, operadores e funções; a principal diferença entre ele e outros pré-compiladores de *CSS* é que ele também permite a compilação em tempo real pelo navegador por meio de um *javascript*, o *less.js*. Com isso ele pode ser executado tanto no lado do cliente quanto no lado do servidor, ou pode ser compilado em *CSS* plano.

[^3]: **ECMAScript 6**<br>O *ECMAScript* é uma linguagem de programação baseada em scripts, padronizada pela *[Ecma International](https://www.ecma-international.org)* na especificação *ECMA-262*. A linguagem é bastante usada em tecnologias para Internet, sendo esta base para a criação do *JavaScript/JScript* e também do *ActionScript*.<br><br>O *ES6*, *ECMAScript 6* ou *ES2015*, é simplesmente a mais nova versão do *JavaScript*, lançada em 2015 a *ES6* tem seus principais objetivos de ser uma linguagem melhor para construir aplicações complexas, resolver problemas antigos do *javascript* e facilitar o desenvolvimento de bibliotecas.<br><br>Essa nova versão veio com diversos novos recursos para melhorar performance, escrita e principalmente a semantica do *javascript*, entre eles estão novas maneiras de declarar variáveis, orientação a objeto, modulos e muitos outros. para conhecer mais sobre as novidades e história só verificar esse excelente post no blog da *[Medium](https://medium.com/@matheusml/o-guia-do-es6-tudo-que-voc%C3%AA-precisa-saber-8c287876325f)*.

[^4]: **VueJS**<br>O *Vue.js (comumente chamado de Vue; pronunciado vju, como view)* é um framework *JavaScript* com licensa *open source* para construir interfaces com o usuário. A integração em projetos que usam outras bibliotecas *javaScript* como *jQuery* e outras é simplificada com o *Vue*, pois foi projetado para ser adotado de forma incremental. Ele também pode funcionar como uma estrutura de aplicativo da *Web* capaz de alimentar aplicativos avançados de página única. Para conhecer mais você pode acessar esse post do *[Medium](https://medium.com/@kessiacastro/vue-js-tutorial-iniciando-com-componentes-4445b3eb0ffe)* que possui uma boa explicação das bases do *Vue*.

[^5]: **Iniciando o Servidor**<br>A ordem dos serviços devem ser na ordem abaixo, sendo que, inicializa-se o servidor **PHP**, aguarde a mensagem que o mesmo está funcionando e após isso inicia o serviço do renderizador.

[^6]: **Artisan**<br>É a ferramenta de linha de comando do *Laravel* e é instalada automaticamente quando se cria um novo projeto. Com ela, podemos gerar a maioria das classes que são as ferramentas disponibilizadas pelo framework. Pense em qualquer coisa. Precisa de um novo Model? `php artisan make:model Artists`. Precisa de um FormRequest? `php artisan make:request ArtistRequest`. E assim para tudo o que se pode fazer com o framework. Para mais informações há um ótimo artigo em [vedovelli.com.br](http://www.vedovelli.com.br/web-development/o-que-e-o-artisan/).