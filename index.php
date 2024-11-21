<?php

// Caminho da pasta onde os arquivos .nitro estão localizados
$mob_directory = 'mob/';

// Abrir a pasta e obter todos os arquivos .nitro
$files = glob($mob_directory . '*.nitro');

// Inicializa os dados para os arquivos finais
$sql_output = "";
$xml_output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<furnidata>\n";

// Função para gerar SQL
function generate_sql($generated_id, $name) {
    $catalog_sql = "INSERT INTO `catalog_items` (`id`, `item_ids`, `page_id`, `catalog_name`, `cost_credits`, `cost_points`, `points_type`, `amount`, `limited_stack`, `limited_sells`, `order_number`, `offer_id`, `song_id`, `extradata`, `have_offer`, `club_only`) VALUES (NULL, '{$generated_id}', 'PAGINA-ID', '{$name}', '".rand(1, 10000)."', '0', '0', '1', '0', '0', '1', '-1', '0', '', '1', '0');";
    
    $items_sql = "INSERT INTO `items_base` (`id`, `sprite_id`, `public_name`, `item_name`, `type`, `width`, `length`, `stack_height`, `allow_stack`, `allow_sit`, `allow_lay`, `allow_walk`, `allow_gift`, `allow_trade`, `allow_recycle`, `allow_marketplace_sell`, `allow_inventory_stack`, `interaction_type`, `interaction_modes_count`, `vending_ids`, `multiheight`, `customparams`, `effect_id_male`, `effect_id_female`, `clothing_on_walk`, `wired_data`) VALUES ('{$generated_id}', '{$generated_id}', '{$name}', '{$name}', 's', '1', '1', '0.00', '1', '0', '0', '0', '1', '1', '0', '0', '1', 'default', '4', '0', '0', '', '0', '0', '', '0');";
    
    return $catalog_sql . "\n" . $items_sql;
}

// Função para gerar XML
function generate_xml($generated_id, $name) {
    $xml_data = "
<furnitype id=\"{$generated_id}\" classname=\"{$name}\">
    <revision>1</revision>
    <defaultdir>0</defaultdir>
    <xdim>1</xdim>
    <ydim>1</ydim>
    <partcolors>
        <color>0</color>
        <color>0</color>
        <color>0</color>
    </partcolors>
    <name>{$name}</name>
    <description>{$name}</description>
    <adurl></adurl>
    <offerid>0</offerid>
    <buyout>0</buyout>
    <rentofferid>0</rentofferid>
    <rentbuyout>0</rentbuyout>
    <bc>0</bc>
    <excludeddynamic>0</excludeddynamic>
    <customparams></customparams>
    <specialtype>0</specialtype>
    <canstandon>1</canstandon>
    <cansiton>1</cansiton>
    <canlayon>1</canlayon>
</furnitype>";
    
    return $xml_data;
}

// Função para gerar um ID único para cada mob
function generate_unique_id($file_name, $counter) {
    // Gerar um valor único com CRC32
    $crc_id = crc32($file_name . $counter);
    
    // Garantir que o ID gerado esteja dentro do intervalo válido para INT
    $crc_id = abs($crc_id) % 2147483647; // Limitar o valor para o intervalo de 0 a 2.147.483.647
    
    // Escolher um valor aleatório entre -1000, -500 e -200
    $random_negative = [-1000, -500, -200][array_rand([-1000, -500, -200])];
    
    // Multiplicar o valor aleatório por 10
    $adjusted_value = $random_negative * 10;
    
    // Ajustar o valor para estar dentro do intervalo
    $generated_id = $crc_id + $adjusted_value;
    
    // Garantir que o ID não ultrapasse o limite do tipo de dado INT
    if ($generated_id > 2147483647) {
        $generated_id = 2147483647; // Ajuste para o valor máximo permitido
    } elseif ($generated_id < -2147483648) {
        $generated_id = -2147483648; // Ajuste para o valor mínimo permitido
    }
    
    return $generated_id; // Retorna o ID ajustado
}

// Loop pelos arquivos .nitro
$counter = 1;  // Contador para gerar IDs diferentes
foreach ($files as $file) {
    // Pega o nome do arquivo sem a extensão .nitro
    $file_name = basename($file, '.nitro');
    
    // Gerar ID único para o arquivo (usando o nome do arquivo e o contador)
    $generated_id = generate_unique_id($file_name, $counter);
    
    // Gerar SQL e XML
    $sql_data = generate_sql($generated_id, $file_name);
    $xml_data = generate_xml($generated_id, $file_name);
    
    // Adiciona os dados ao output final
    $sql_output .= $sql_data . "\n";
    $xml_output .= $xml_data . "\n";
    
    // Incrementa o contador para o próximo ID
    $counter++;
}

// Fecha o XML com a tag de fechamento
$xml_output .= "</furnidata>";

// Salva os arquivos gerados
file_put_contents('sql.sql', $sql_output);
file_put_contents('furnidata.xml', $xml_output);

echo "Arquivos SQL e XML gerados com sucesso!\n";

?>
