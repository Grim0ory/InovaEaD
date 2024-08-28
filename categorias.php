<?php

function processarConfiguracao($configuracao) {
    $linhas = explode("\n", trim($configuracao));
    $ultima_linha = end($linhas);
    $ultima_linha = trim($ultima_linha);
    $categoriaAtual = '';

    foreach ($linhas as $linha) {
        $linha = trim($linha);

        // Se a linha define uma nova categoria
        if (strpos($linha, ':') !== false && trim(substr($linha, strpos($linha, ':') + 1)) === '') {
            $categoriaAtual = rtrim($linha, ':');
        } elseif (strpos($linha, ':') !== false) {
            list($codigo, $filtros) = explode(':', $linha);
            $codigo = trim($codigo);
            $filtros = trim($filtros);

            echo "Categoria virtual: $categoriaAtual\n";
            echo "Categoria do Moodle: $codigo\n";
            echo "Cursos adicionados: ";

            if ($filtros == '*') {
                echo "todos os cursos\n";
            }
            elseif (strpos($filtros, ',') !== false) {
                $cursos = explode(',', $filtros);
                $ultimo = end($cursos);
                $ultimo = trim($ultimo);
                $ultimo = trim($ultimo, '%');
                foreach ($cursos as $curso){
                    $curso = trim($curso);
                    if (strpos($curso, '%') !== false) {
                        if (strpos($curso, '%') === 0 && strrpos($curso, '%') === strlen($curso) - 1) {
                            $curso = trim($curso, '%');
                            if($curso === $ultimo){
                                echo "todos os cursos cujos nomes contenham {$curso}\n";
                            }else{
                                echo "todos os cursos cujos nomes contenham {$curso}, ";
                            }
                        } elseif (strpos($curso, '%') === 0) {
                            $curso = ltrim($curso, '%');
                            if($curso === $ultimo){
                                echo "todos os cursos cujos nomes comecem com {$curso}\n";
                            }else{
                                echo "todos os cursos cujos nomes comecem com {$curso}, ";
                            }
                        } elseif (strrpos($curso, '%') === strlen($curso) - 1) {
                            $curso = rtrim($curso, '%');
                            if($curso === $ultimo){
                                echo "todos os cursos cujos nomes terminem com {$curso}\n";
                            }else{
                                echo "todos os cursos cujos nomes terminem com {$curso}, ";
                            }
                        }
                    }
                    else{
                        if($curso === $ultimo){
                            echo "curso {$curso}\n";
                        }
                        else{
                            echo "curso {$curso}, ";
                        }
                    }
                }

            }
            else{
                if (strpos($filtros, '%') !== false) {
                    if (strpos($filtros, '%') === 0 && strrpos($filtros, '%') === strlen($filtros) - 1) {
                        $curso = trim($filtros, '%');
                        echo "todos os cursos cujos nomes contenham {$curso}\n";

                    } elseif (strpos($filtros, '%') === 0) {
                        $curso = ltrim($filtros, '%');
                        echo "todos os cursos cujos nomes comecem com {$curso}\n";
                        
                    } elseif (strrpos($filtros, '%') === strlen($filtros) - 1) {
                        $curso = rtrim($filtros, '%');
                        echo "todos os cursos cujos nomes terminem com {$curso}\n";
                    }
                }
                else{
                     echo "curso {$filtros}\n";
                }
            }
            
            if($linha != $ultima_linha){
                echo "--------------------------------\n";
            }
            else{
                echo "\n";
            }
        }
    }
}

// Exemplo de uso:

$config1 = "Ciência da Computação:\n1234: *\nSistemas de Informação:\n4321: %GSI, DAC%, %GCC%, GTI128";
processarConfiguracao($config1);

$config2 = "Ciência da Computação:\n1234: GCC%, GSI%";
processarConfiguracao($config2);

$config3 = "Ciência da Computação:\n1234: %GCC";
processarConfiguracao($config3);

$config4 = "Ciência da Computação:\n1234: %GCC%";
processarConfiguracao($config4);

$config5 = "Ciência da Computação:\n1234: GCC132, GCC135";
processarConfiguracao($config5);


?>
