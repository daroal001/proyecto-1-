<?php
/**
 * Proyecto PHP: La Batalla de Aura
 * Archivo base para el alumnado.
 */

// Mapa original del Pabellón Skibidi
// "0" -> Terreno neutro (Pasillos comunes)
// "~" -> Zonas de Chill (Patios)
// "G" -> Zona habitada (Grupos de Gymbros / Sigmas)

$mapaOriginal = [
    ["~~~~~00G0G00G0~~~~~~~~~~"],
    ["~~~0000000000~~~~~~~~~~~"],
    ["~~~000000G0000G0~~~~~~~~"],
    ["~~~~~00000GG0~~~~~~~~~~~"],
    ["~~~~00000G00GGG0~~~~~~"],
    ["~~000G0GG00000000000G00~"],
    ["~~~~~~00G000G000000G000~"],
    ["~000000000000000~~~~~"],
    ["~~~~~~~~~~~00000000~~~~~"],
    ["~~~0000000000000000~~~~"],
    ["~~~0000000000000000~~~~~"],
    ["~00000000000000G00000G0~~~"],
    ["~~~~~~0000G00~~~~~~~~"],
    ["~~~~~~000GGG00G000~~~"],
    ["~~~0GG00G000G0000~~~~~~"],
    ["~~~~~~~000G00000G0G000~"],
    ["~~~~~~~~~0G000~~~~~~~~"],
    ["~~~0G00000000G000~~~~~~~"],
    ["~~~~~~~~~000G00G0~~~~~~~"],
    ["~~~~0000G0000G0~~~~~~~~~"],
    ["~00000000000000000~~~~~~"],
    ["~~~~~~~~~~000000000~~~~~"],
    ["~~~~~~~~~~~~~~~~~~~~~~~~"]
];

// Coordenadas de los impactos de cringe [fila, columna]
$impactos = [
    [2, 9], [3, 10], [5, 4], [11, 15], [14, 4], [17, 4], // Impactos que afectarán a los Gymbros
    [1, 5], [3, 8], [6, 12], [8, 14], [10, 3],           // Impactos en pasillos comunes
    [0, 2], [1, 20], [8, 2], [21, 5], [22, 10]           // Impactos en zonas de chill
];

$mapaOriginal = array_map(fn($fila) => str_split($fila[0]), $mapaOriginal); // transformar mapa

// 1 mostrar el mapa
function mostrarMapa($mapa) {
    foreach ($mapa as $fila) {
        echo implode("", $fila) . "<br>";
    }
}

// 2, 4 y 6 procesar mapa y daños
function procesarImpactos(&$mapa, $impactos) { // pasarlo por referencia es mas eficaz
    $totalChill = 0;
    foreach ($mapa as $fila) {
        $totalChill += substr_count(implode("", $fila), "~");
    }

    $afectadoChill = 0;

    // limitador de impactos 
    foreach ($impactos as [$r, $c]) {
        if (!isset($mapa[$r][$c])) {
            continue;
        }

        $valor = $mapa[$r][$c];

        if ($valor === 'G') {
            $mapa[$r][$c] = 'S';
        } elseif ($valor === '0') {
            $mapa[$r][$c] = 'X';
        } elseif ($valor === '~') {
            $mapa[$r][$c] = 'W';
            $afectadoChill++;
        }
    }

    return [$mapa, $totalChill, $afectadoChill];
}

// 3, 5 y 7 cálculos finales
function calculos($mapaDaños, $totalChill, $afectadoChill) {
    $s = 0;
    $x = 0;

    foreach ($mapaDaños as $fila) {
        $s += substr_count(implode("", $fila), "S");
        $x += substr_count(implode("", $fila), "X");
    }

    $personas = $s * 3000;
    $litros = ($personas * 10) / 1000;
    $costes = ($x * 75000) + ($s * 250000);
    $clips_virales = (((10000 * 60) * ($afectadoChill / $totalChill)) * 20);

    // imprimir resultados
    echo "personas afectadas: " . $personas . "<br>";
    echo "litros necesarios: " . number_format($litros, 2) . " L<br>";
    echo "coste de reparación: " . $costes . " €<br>";
    echo "chill total: $totalChill <br>"; 
    echo "chill afectado: $afectadoChill<br>";
    echo "coste final: " . number_format($costes - $clips_virales) . " €<br>";
}

echo "<h2>Mapa original</h2>";
mostrarMapa($mapaOriginal);

$mapa = $mapaOriginal;
[$mapaDaños, $totalChill, $afectadoChill] = procesarImpactos($mapa, $impactos);
$mapa = $mapaDaños;

echo "<h2>Mapa tras impactos</h2>";
mostrarMapa($mapaDaños);

echo "<h2>Resultados</h2>";
calculos($mapaDaños, $totalChill, $afectadoChill);

?>