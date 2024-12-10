
# Gerador de SQL e XML para Arquivos .nitro

## Sobre
Este script em PHP foi desenvolvido para processar arquivos `.nitro` em uma pasta específica, gerando automaticamente comandos SQL e estrutura XML com base nos dados extraídos. Ele é útil para quem trabalha com customizações ou integração de objetos virtuais.

---

## Funcionalidades
- Geração automática de arquivos SQL para integração com banco de dados.
- Criação de arquivos XML no formato esperado para sistemas compatíveis.
- Suporte para múltiplos arquivos `.nitro` em lote.

---

## Requisitos
- PHP 7.4 ou superior.

---

## Como Usar
1. **Prepare o Ambiente**: Certifique-se de que os arquivos `.nitro` estejam em uma pasta chamada `mob/` no mesmo diretório do script.
2. **Execute o Script**: Use o comando abaixo no terminal:
   ```bash
   php script.php
   ```
3. **Arquivos Gerados**: Após a execução, dois arquivos serão criados no mesmo diretório:
   - `sql.sql`: Contém os comandos SQL gerados.
   - `furnidata.xml`: Contém os dados no formato XML.

---

## Estrutura dos Arquivos
### SQL
O arquivo `sql.sql` inclui dois tipos principais de comandos:
- Inserções na tabela `catalog_items`.
- Inserções na tabela `items_base`.

### XML
O arquivo `furnidata.xml` segue a estrutura:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<furnidata>
    <furnitype id="ID_UNICO" classname="NOME_DO_ARQUIVO">
        <revision>1</revision>
        <defaultdir>0</defaultdir>
        <xdim>1</xdim>
        <ydim>1</ydim>
        <name>NOME_DO_ARQUIVO</name>
        <description>NOME_DO_ARQUIVO</description>
        <!-- Outros campos -->
    </furnitype>
</furnidata>
```

---

## Personalização
Você pode ajustar as funções `generate_sql` e `generate_xml` para atender a diferentes estruturas de banco de dados ou formatos XML.

---

## Mensagens de Log
Durante a execução, o script exibirá mensagens como:
- **Arquivos SQL e XML gerados com sucesso!**: Indica que o processo foi concluído.
- Erros específicos serão exibidos para ajudar na depuração.

---

## Licença
Este projeto é open source. Sinta-se à vontade para modificar e redistribuir com os devidos créditos.

---

Aproveite o script e facilite o gerenciamento de seus arquivos `.nitro`!
