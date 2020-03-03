<h3>Atualização ProGest - Sistema de Gerenciamento de Materiais em insituições públicas</h3>
-Realizada no período 2019.2, com base no sistema já criado, que se encontra em: https://github.com/loppesdan/progest;
<h4>Pré requisitos:</h4>

-PHP >= 5.4, PHP < 7

-MySQL

-Composer

-Mcrypt PHP Extension

-OpenSSL PHP Extension

-Mbstring PHP Extension

-Tokenizer PHP Extension

<h4>O progest é um sistema web de código aberto, desenvolvido no Instituto Federal de Educação, Ciência e Tecnologia da Bahia, campus Vitória da Conquista.</h4>

<h4>Principais funcoinalidades:</h4>
-Cadastro de servidores, setores, coordenações e fornecedores;

-Cadastro de empenhos de materiais;

-Cadastro de entradas de materiais;

-Cadastro de solicitações de materiais (para consumo) por servidores;

-Cadastro de saídas de materiais;

-Cadastro de devoluções de materiais;

-Tela de solicitação de matériais de forma remota (não é necessário que o servidor compareça ao almoxarifado);

-Relatórios gerenciais: contábil (saldos de entrada e saída por subitem), empenhos, entradas, saídas, situação de fornecedores.

<h4>Principais Atualizações:</h4>
-Correção do Relatório Contábil;

-Criação Relatório de consumo por solicitante;

-Criação Relatório de consumo por material;

-Criação campo para visualização de devoluções na área do solicitante;

-Correção de demandas para facilitar a navegação e utilização;

<h4>Instalação:</h4>
Basta importar o arquivo database.sql, colocar os arquivos do projeto em um diretório em seu servidor web e rodar o comando "composer install" dentro da pasta do projeto.

O banco importado contém dois usuários, um com permissão de Administrador e outro Solicitante:

email: administrador@progest.com senha: administrador1

email: solicitante@progest.com senha: solicitante1
