<?php

function separador() {
    return str_repeat("-", 150) . "\n";
}

function registrarHistorico(array &$h, $acao, $titulo){
    $h[] = [
        'acao'  => $acao,
        'livro' => $titulo,
        'hora'  => date('d/m/Y H:i:s')
    ];
}

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

    echo separador();
    
    usort($a, fn($x, $y) => strcasecmp($x['titulo'], $y['titulo']));
    foreach ($a as $vs => $v) {
        foreach ($v as $k => $l) {
            if (is_bool($l)) {
                echo " " . ucfirst($k) . ": " . $l = ($l ? "Sim" : "Não") . " - ";
            } else {
                echo " " . ucfirst($k) . ": " . $l . " - ";
            }
        }
        echo "\n";
    }
}

function cadastrarLivro(array &$a, array &$historico)
{
    echo separador();

        echo "Insira os dados do novo livro: \n";

        $titulo = trim(readline("Título: "));
        $autor = trim(readline("Autor: "));
        $paginas = trim(readline("Número de páginas: "));
        $lido = trim(readline("Lido? (s/n): "));
        $lido = strtolower($lido) === 's' ? true : false;

        if (empty($titulo) || empty($autor) || (int)$paginas <= 0) {
            echo "Dados inválidos. Cadastro cancelado.\n";
            return;
        }
    if (trim(readline("Tem certeza que deseja cadastrar um novo livro? (s/n): ")) === 's') {

        $novoLivro = [
            'ID' => gerarID($a),
            'titulo' => $titulo,
            'autor' => $autor,
            'paginas' => (int) $paginas,
            'lido' => $lido
        ];
        array_push($a, $novoLivro);

        echo "Livro cadastrado com sucesso! \n";
        registrarHistorico($historico, 'Cadastro', $titulo);
    } else {
        echo "Cadastro cancelado. \n";
    }

}

function removerLivro(array &$a, array &$historico)
{
    echo separador();

    $id = trim(readline("Digite o ID do livro a ser removido: "));
    $encontrado = false;

    foreach ($a as $index => $livro) {
        if ($livro['ID'] == $id) {
            $encontrado = true;

            $confirma = trim(readline("Remover \"{$livro['titulo']}\"? (s/n): "));

            if ($confirma === 's') {
                array_splice($a, $index, 1);
                echo "Livro removido com sucesso!\n";
                registrarHistorico($historico, 'Remover', $livro['titulo']);
            } else {
                echo "Remoção cancelada.\n";
            }
            break;
        }
    }

    if (!$encontrado) {
        echo "Livro com ID $id não encontrado.\n";
    }
}

function buscarLivro(array $a)
{

    $termo = trim(readline("Digite o título ou autor para buscar: "));
    $resultados = [];
    foreach ($a as $livro) {
        if (stripos($livro['titulo'], $termo) !== false || stripos($livro['autor'], $termo) !== false) {
            array_push($resultados, $livro);
        }
    }

    if (empty($resultados)) {
        echo separador();
        echo "Nenhum livro encontrado.\n";
        return;
    }

    listarLivros($resultados);
}

function editarLivro(array &$a, array &$historico)
{
    echo separador();
    $id = trim(readline("Digite o ID do livro a ser editado: "));

    foreach ($a as $index => $livro) {
        if ($livro['ID'] == $id) {
            echo "Editando o livro '{$livro['titulo']}': \n";
            
            do {
                $campo = trim(readline("Qual campo editar? (titulo, autor, paginas, lido): "));
                
                if (!in_array($campo, ['titulo', 'autor', 'paginas', 'lido'])) {
                    echo "Campo inválido.\n";
                    break;
                }
                
                $novoValor = trim(readline("Insira o novo {$campo} [{$a[$index][$campo]}]: "));

                if ($novoValor === '') {
                    echo "Valor mantido.\n";
                    continue;
                }
                if ($campo === 'paginas') $novoValor = (int) $novoValor;
                if ($campo === 'lido') $novoValor = strtolower($novoValor) === 's' ? true : false;
                $a[$index][$campo] = $novoValor;
                registrarHistorico($historico, 'Editar', $a[$index]['titulo']);

                $continuar = trim(readline("Editar outro campo? (s/n): "));

            } while ($continuar === 's');
        }
    }
    if ($livro['ID'] != $id) {
        echo "ID inválido!\n";
    }
}

function estatisticas($a) {
    echo separador();

    echo "ESTATÍSTCAS GERAIS\n";

    // Total de livros
    echo "O sistema tem um total de: " . count($a) . " livros cadastrados\n";

    // Livros lidos/nao lidos
    $lidos = [];
    $nlidos = [];

    foreach ($a as $index => $livro){
        if($livro['lido'] == true) {
            array_push($lidos, $livro);
        } else {
            array_push($nlidos, $livro);
        }
    }
    
    echo "Livros lidos: " . count($lidos) . "\nLivros não lidos: " . count($nlidos) . "\n";

    // Livro com mais páginas

    $maiorPaginas = max(array_column($a, 'paginas'));
    foreach ($a as $livro) {
    if ($livro['paginas'] === $maiorPaginas) {
        echo "Livro com mais páginas: {$livro['titulo']}({$maiorPaginas} páginas)\n";
        break;
    }
}
}

function exibirHistorico(array $h) {
    echo separador();
    if (empty($h)) {
        echo "Sem histórico recente\n";
        return;
    }

    foreach ($h as $entrada) {
         echo "[{$entrada['hora']}] [{$entrada['acao']}] [{$entrada['livro']}]\n";
    }
}