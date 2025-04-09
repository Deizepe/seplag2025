
# Projeto Prático – Laravel 12 REST API com Docker, PostgreSQL e MinIO

API RESTful construída com Laravel 12, com autenticação via Sanctum (token expira em 5 minutos), persistência em PostgreSQL, upload e recuperação de imagens no Min.IO, e orquestração com Docker Compose.

---

## ✅ Dependências

- Docker + Docker Compose
- PHP 8.2+ (via container)
- Laravel 12.4
- PostgreSQL (via container)
- MinIO (via container)
- Laravel Sanctum

---

## 🚀 Como rodar o projeto

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/projetopratico.git
cd projetopratico
```

### 2. Configure o `.env`

Copie e ajuste conforme necessário:

```bash
cp .env.example .env
```

Certifique-se de que os dados do banco e do MinIO estejam assim:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=projetopratico
DB_USERNAME=laravel
DB_PASSWORD=secret

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=minioadmin
AWS_SECRET_ACCESS_KEY=minioadmin
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=local-bucket
AWS_ENDPOINT=http://minio:9002
AWS_USE_PATH_STYLE_ENDPOINT=true
```

### 3. Suba os containers

```bash
docker compose up -d
```

### 4. Instale as dependências dentro do container

```bash
docker compose exec app composer install
```

### 5. Gere a chave da aplicação e rode as migrations

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

---

## 🧪 Como testar os endpoints

### Testar se está funcionando

```bash
curl http://localhost:8001/api/ping
```

---

## 🔐 Autenticação

### Gerar token para um usuário (exemplo via tinker):

```bash
docker compose exec app php artisan tinker

>>> $user = \App\Models\User::factory()->create(['email' => 'admin@example.com', 'password' => bcrypt('password')]);
>>> $token = $user->createToken('api-token')->plainTextToken;
```

### Exemplo de requisição com token:

```bash
curl -H "Authorization: Bearer SEU_TOKEN_AQUI" http://localhost:8001/api/servidores
```

---

## 🔁 Renovar token

```http
POST /api/refresh-token
Authorization: Bearer SEU_TOKEN_ATUAL
```

Resposta:

```json
{
  "token": "NOVO_TOKEN"
}
```

---

## 📦 Upload para MinIO

- Acesse o console do MinIO: [http://localhost:9001](http://localhost:9001)  
  Login: `minioadmin` / Senha: `minioadmin`
- Crie um bucket chamado `local-bucket`
- Ao subir fotos via API, elas serão salvas nesse bucket

---

## 🌍 CORS

Somente requisições originadas de:

```text
http://localhost
```

são aceitas na API, conforme configurado no middleware de CORS.

---

## 👤 Usuário de exemplo

| Campo     | Valor                 |
|-----------|------------------------|
| E-mail    | `admin@example.com`    |
| Senha     | `password`             |
| Token     | (gerado via Tinker ou login) |

---

## 📚 Documentação de Endpoints

| Método | Endpoint                                | Descrição                                       |
|--------|-----------------------------------------|-------------------------------------------------|
| GET    | `/api/ping`                             | Teste de saúde da API                           |
| GET    | `/api/servidores`                       | Listagem de servidores efetivos                |
| POST   | `/api/refresh-token`                    | Gera novo token (válido por mais 5 minutos)     |
| POST   | `/api/servidores`                       | Cria um novo servidor efetivo (autenticado)     |
| PUT    | `/api/servidores/{id}`                  | Atualiza um servidor efetivo                   |
| ...    | (Outros endpoints conforme especificado)| CRUD completo de unidades, lotações etc.       |

---

## 📦 Scripts extras

```bash
docker compose down          # Para os containers
docker compose up -d        # Sobe tudo novamente
docker compose logs -f app  # Ver logs da aplicação
```

---

## 🧾 Licença

Este projeto é parte de um teste prático e deve ser utilizado apenas para fins de avaliação.
