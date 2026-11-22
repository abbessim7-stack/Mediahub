# MediaHub API Documentation

Base URL: `http://127.0.0.1:8000/api`

## Authentication

Most write endpoints require a Bearer token. To get one, use the login endpoint below and include the token in your headers as: `Authorization: Bearer <your_token_here>`

---

## Endpoints

| Method | Endpoint | Authentication | Description |
| :--- | :--- | :--- | :--- |
| **POST** | `/connexion` | None | Obtain an API token. |
| **GET** | `/publications` | None | List all publications (paginated). |
| **GET** | `/publications/{id}` | None | Get details of a specific publication. |
| **POST** | `/publications` | **Required** | Create a new publication. |
| **PUT/PATCH** | `/publications/{id}` | **Required** | Update a publication you own. |
| **DELETE** | `/publications/{id}` | **Required** | Delete a publication you own. |

---

## Examples

### 1. Login (Get Token)
**Request:**
```http
POST /api/connexion
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password123"
}
