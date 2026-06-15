# 📝 ToDo List – API
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![API](https://img.shields.io/badge/API-REST-blue)
![Architecture](https://img.shields.io/badge/architecture-layered-brightgreen)
![Repository](https://img.shields.io/badge/pattern-Repository-orange)
![Service Layer](https://img.shields.io/badge/pattern-Service--Layer-blueviolet)
![Database](https://img.shields.io/badge/database-PostgreSQL-blue)
![Tests](https://img.shields.io/badge/tests-PHPUnit-green)
![PSR-4](https://img.shields.io/badge/PSR--4-autoload-success)

## 📄 Sobre o Projeto

API REST para gerenciamento de tarefas desenvolvida em PHP, com arquitetura em camadas, uso de enums, validação via exceptions e testes automatizados com PHPUnit. Com o objetivo de consolidar os conceitos aprendidos de Php.

---

## 🛠️ Tecnologias Utilizadas

- PHP 8+
- Composer (autoload PSR-4)
- PDO
- PostgreSQL
- vlucas/phpdotenv
- PhpUnit e SQLite para testes

---

## 📁 Organização de pastas

```text
ToDoAPI/
├── src/
│   ├── config/
│   │   ├── create_table.sql
│   │   └── Database.php
│   ├── Models/
│   │   └── Tarefa.php
│   ├── Repository/
│   │   └── TarefaRepository.php
│   ├── Service/
│   │   └── TarefaService.php
│   ├── Http/
│   │   └── Router.php
│   ├── Exception/
│   │   ├── ValidationException.php
│   │   └── NotFoundException.php
│   ├── Enum/
│   │   ├── Prioridade.php
│   │   └── StatusTarefa.php
├── public/
│   └── index.php
├── tests/
│   ├── Repository/
│   │   └── TarefaRepositoryTest.sql
│   ├── Service/
│   │   └── TarefaServiceTest.php
├── vendor/
├── .env.example
├── composer.json
└── README.md
```

---

## ⚙️ Como Rodar o Projeto

### 1️⃣ Clonar o repositório
```bash
git clone <url-do-repositorio>
cd ToDoAPI
```
### 2️⃣ Instalar composer
```bash
composer install
```
### 3️⃣ Criar o arquivo .env

Configure o .env com os dados do seu banco;
Arquivo .env.example:
```bash
DB_HOST=localhost
DB_PORT=5432
DB_NAME= ...
DB_USER= ...
DB_PASS= ...
```
### 4️⃣ Rodar o servidor
```bash
php -S localhost:8000 -t public
```
### 5️⃣ Rodar os testes
```
./vendor/bin/phpunit 
```
## 📚 Endpoints

### 📇 

| Método | Endpoint             | Descrição                          |
| ------ | -------------------- | ---------------------------------- |
| POST   | `/api/tarefas`      | Cria um nova tarefa               |
| GET    | `/api/tarefas`      | Lista todas as tarefas  |
| GET    | `/api/tarefas/{id}` | Busca uma tarefa pelo ID           |          |
| PUT    | `/api/tarefas/{id}` | Atualiza uma tarefa existente      |
| DELETE | `/api/tarefas/{id}` | Remove uma tarefa                |

#### Exemplo de Body (POST/PUT)
```text
{
  "titulo": "Estudar PHP",
	"descricao": "Estudar PDO e Enums",
	"prioridade": "Baixa",
	"status": "Concluida"
}
```

