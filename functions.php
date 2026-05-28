<?php

function gerarID(array $a)
{
    if (empty($a)) {
        return 1;
    } else {
        return max(array_column($a, 'ID')) + 1;
    }
}

function listarLivros(array $a)
{

    echo str_repeat("-", 150) . "\n";
    foreach ($a as $vs => $v) {
        foreach ($v as $k => $l) {
            if (is_bool($l)) {
                echo " " . ucfirst($k) . ": " . $l = $l ? "Sim" : "Não" . " - ";
            } else {
                echo " " . ucfirst($k) . ": " . $l . " - ";
            }
        }
        echo "\n";
    }
    echo str_repeat("-", 150) . "\n";
}

function cadastrarLivro(array &$a)
{
    echo str_repeat("-", 70) . "\n";

    if (trim(readline("Tem certeza que deseja cadastrar um novo livro? (s/n): ")) === 's') {

        echo "Insira os dados do novo livro: \n";

        $titulo = trim(readline("Título: "));
        $autor = trim(readline("Autor: "));
        $paginas = trim(readline("Número de páginas: "));
        $lido = trim(readline("Lido? (s/n): "));
        $lido = strtolower($lido) === 's' ? true : false;

        $novoLivro = [
            'ID' => gerarID($a),
            'titulo' => $titulo,
            'autor' => $autor,
            'paginas' => (int) $paginas,
            'lido' => $lido
        ];
        array_push($a, $novoLivro);

        echo "Livro cadastrado com sucesso! \n";
    } else {
        echo "Cadastro cancelado. \n";
    }
    echo str_repeat("-", 150) . "\n";
}

function removerLivro(array &$a)
{
    echo str_repeat("-", 150) . "\n";

    $id = trim(readline("Digite o ID do livro a ser removido: "));
    $encontrado = false;

    foreach ($a as $index => $livro) {
        if ($livro['ID'] == $id) {
            $encontrado = true;

            $confirma = trim(readline("Remover \"{$livro['titulo']}\"? (s/n): "));

            if ($confirma === 's') {
                array_splice($a, $index, 1);
                echo "Livro removido com sucesso!\n";
            } else {
                echo "Remoção cancelada.\n";
            }
            break;
        }
    }

    if (!$encontrado) {
        echo "Livro com ID $id não encontrado.\n";
    }


    echo str_repeat("-", 150) . "\n";
}

function buscarLivro(array $a)
{

    $termo = trim(readline("Digite o título ou autor para buscar: "));
    $resultados = [];
    foreach ($a as $livro) {
        if (stripos($livro['titulo'], $termo) == true || stripos($livro['autor'], $termo) == true) {
            array_push($resultados, $livro);
        }
    }

    if (empty($resultados)) {
        echo str_repeat("-", 150) . "\n";
        echo "Nenhum livro encontrado.\n";
        return;
        echo str_repeat("-", 150) . "\n";
    }

    listarLivros($resultados);
}