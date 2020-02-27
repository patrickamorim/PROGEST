ProGest - Sistema de Gerenciamento de Materiais em insituições públicas
Pré requisitos:

-PHP >= 5.4, PHP < 7

-MySQL

-Composer

-Mcrypt PHP Extension

-OpenSSL PHP Extension

-Mbstring PHP Extension

-Tokenizer PHP Extension

O progest é um sistema web de código aberto, desenvolvido no Instituto Federal de Educação, Ciência e Tecnologia da Bahia, campus Vitória da Conquista.

Principais funcoinalidades:
-Cadastro de servidores, setores, coordenações e fornecedores;

-Cadastro de empenhos de materiais;

-Cadastro de entradas de materiais;

-Cadastro de solicitações de materiais (para consumo) por servidores;

-Cadastro de saídas de materiais;

-Cadastro de devoluções de materiais;

-Tela de solicitação de matériais de forma remota (não é necessário que o servidor compareça ao almoxarifado);

-Relatórios gerenciais: contábil (saldos de entrada e saída por subitem), empenhos, entradas, saídas, situação de fornecedores.

Instalação:
Basta importar o arquivo database.sql, colocar os arquivos do projeto em um diretório em seu servidor web e rodar o comando "composer install" dentro da pasta do projeto.

O banco importado contém dois usuários, um com permissão de Administrador e outro Solicitante:

email: administrador@teste.com senha: administrador1

email: solicitante@teste.com senha: solicitante1
