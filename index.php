<?php
# Projeto N1 code academy PHP puro, sem frameworks
# Sistema de gerenciamento Via terminal 28/05/2026
require 'functions.php';

$livros = [
    ['ID' => 1, 'titulo' => 'Um Estudo em Vermelho', 'autor' => 'Árthur Conan Doyle', 'paginas' => 192, 'lido' => true],
    ['ID' => 2, 'titulo' => 'O Fantasma da Ópera', 'autor' => 'Gaston Leroux', 'paginas' => 320, 'lido' => false],
    ['ID' => 3, 'titulo' => 'O Ladrão de Raios', 'autor' => 'Rick Riordan', 'paginas' => 384, 'lido' => false],
    ['ID' => 4, 'titulo' => 'Signo dos Quatro', 'autor' => 'Árthur Conan Doyle', 'paginas' => 144, 'lido' => true]
];

$historico = [];

while (true) {

    echo separador();
    // Mostar opçõess
    echo "Escolha uma opção: \n";
    echo "| 1 - Cadastrar livro | 2 - Listar livros | 3 - Buscar | 4 - Editar | \n| 5 - Remover | 6 - Estatísticas | 7 - Histórico | 0 - Sair |\n";

    $opcao = trim(readline("Opção: "));
    switch ($opcao) {
        case '1':
            cadastrarLivro($livros, $historico);
            break;
        case '2':
            listarLivros($livros);
            break;
        case '3':
            buscarLivro($livros);
            break;
        case '4':
            editarLivro($livros, $historico);
            break;
        case '5':
            removerLivro($livros, $historico);
            break;
        case '6':
            estatisticas($livros);
            break;
        case '7':
            exibirHistorico($historico);
            break;
        case '0':
            echo "Saindo do sistema...\n";
            exit(0);
        default:
            echo "Opção inválida. Tente novamente.\n";
    }
}