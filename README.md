# ItemBalancer

ItemBalancer é uma biblioteca flexível que permite distribuir itens entre categorias pré-definidas com base em proporções especificadas. Com um mecanismo respaldado por cache, ele garante cálculos em tempo real eficientes para atribuições equilibradas de itens.

**Justificativa**: Movido por uma explicação inicial de um amigo de trabalho sobre distribuição probabilística, resolvi criar esta implementação simplista. Ela tem como objetivo resolver o desafio de distribuir itens em categorias com diferentes probabilidades, garantindo uma distribuição justa e proporcional.


## Instalação

Use o gerenciador de pacotes [Composer](https://getcomposer.org/) para instalar a ItemBalancer.

```bash
composer require ananiaslitz/item-balancer
```

## Uso

```php 
require 'vendor/autoload.php';

use Ananiaslitz\ItemBalancer\RedisCache;
use Ananiaslitz\ItemBalancer\Distributor;

$categories = ['A', 'B'];
$percentages = [70, 30];
$cache = new RedisCache();
$distributor = new Distributor($cache, $categories, $percentages);

$result = $distributor->distribute('ItemX');
print_r($result);
```

Neste exemplo, estamos distribuindo o ItemX entre as categorias A e B com uma proporção de 70% para A e 30% para B. O resultado mostrará a categoria para a qual ItemX foi distribuído.

## Configuração usando Docker

Para facilitar o desenvolvimento e os testes, fornecemos um arquivo `docker-compose.yaml` que permite que você rode uma instância do Redis em um container Docker.

### Pré-requisitos
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Variáveis de ambiente
```bash
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### Instruções
1. Clone o repositório.
2. No diretório raiz do projeto, execute: `docker-compose up -d`
3. O serviço Redis estará rodando na porta 6379.

Quando estiver usando a biblioteca em seu projeto, lembre-se de configurar o host do Redis para `redis` se estiver usando Docker.
