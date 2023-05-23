# File and Path

![GitHub release (release name instead of tag name)](https://img.shields.io/github/v/release/joselio105/fileandpath?include_prereleases)
![GitHub](https://img.shields.io/github/license/joselio105/FileAndPath)
![PHP](https://img.shields.io/badge/PHP-7.4.33-blue)
![PHP Unit](https://img.shields.io/badge/depencencies-PHPUnit9.6-yellowgreen)

Criando um novo arquivo PHP com somente um comando

## Menu

-   [Instalação como Dependência](#instalação-como-dependência)
    -   [Diretamente pelo Composer](#diretamente-pelo-composer)
    -   [Alterando o arquivo composer.json](#alterando-o-arquivo-composerjson)
-   [Rodando os Testes](#rodando-os-testes)
-   [Funcionalidades](#funcionalidades)
    -   [Tipos de arquivo que podem ser criados](#tipos-de-arquivo-que-podem-ser-criados)

## Instalação como dependência

Instale File and Path usando o **Composer**

### Diretamente pelo Composer

```bash
  composer require plugse/phpfilemaker
```

### Alterando o arquivo composer.json

1. Crie ou altere o arquivo composer.json
2. Crie ou altere a propriedade **require**

```json
{
    "require": {
        "plugse/phpfilemaker": "^1"
    }
}
```

3. Atualize a biblioteca com o comando abaixo:

```bash
    composer update
```

## Rodando os testes

Para rodar os testes, rode o seguinte comando

```bash
  composer run-script post-install-cmd
```

## Funcionalidades

**Cria arquivos PHP** Digitar diretamente na linha de comando do terminal:

-   php maker << Tipo de Arquivo >> << Nome e caminho do arquivo a ser criado >>

```bash
php maker test ./tests/MakerTest.php
```

### Tipos de arquivo que podem ser criados

1. **class** - Arquivos de classe
1. **controller** - Arquivos de classe do tipo controller
1. **empty** - Arquivos php vazios
1. **interface** - Arquivos de interface
1. **test** - Arquivos de teste
1. **trait** - Arquivos de trait
