# API Documentation - Libretto Book Management System

## Overview
This API provides access to the Libretto book management system with token-based authentication using Laravel Sanctum. All API controllers are organized in the `app/Http/Controllers/Api/` directory.

## Base URL
```
http://localhost:8000/api
```

## Token Configuration
- **Expiration**: 1 minute (configurable in `config/sanctum.php`)
- **Type**: Bearer Token
- **Storage**: `personal_access_tokens` table

## Authentication Endpoints

### 1. Register User
**Endpoint**: `POST /register`  
**Controller**: `App\Http\Controllers\Api\AuthController@register`  
**Access**: Public

**Request Body**:
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response**:
```json
{
    "success": true,
    "message": "Registration successful",
    "user": {...},
    "token": "your-bearer-token",
    "token_type": "Bearer",
    "expires_at": "2025-01-03T11:22:33.000000Z"
}
```

### 2. Login User
**Endpoint**: `POST /login`  
**Controller**: `App\Http\Controllers\Api\AuthController@login`  
**Access**: Public

**Request Body**:
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response**:
```json
{
    "success": true,
    "message": "Login successful - new token generated",
    "user": {...},
    "token": "your-bearer-token",
    "token_type": "Bearer",
    "expires_at": "2025-01-03T11:22:33.000000Z",
    "token_regenerated": true
}
```

### 3. Get User Info
**Endpoint**: `GET /user`  
**Controller**: `App\Http\Controllers\Api\AuthController@user`  
**Access**: Protected (Bearer Token Required)

**Headers**:
```
Authorization: Bearer your-token-here
Accept: application/json
```

**Response**:
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2025-01-03T10:22:33.000000Z",
        "updated_at": "2025-01-03T10:22:33.000000Z"
    },
    "message": "User retrieved successfully"
}
```

### 4. Refresh Token
**Endpoint**: `POST /refresh-token`  
**Controller**: `App\Http\Controllers\Api\AuthController@refreshToken`  
**Access**: Protected (Bearer Token Required)

### 5. Logout
**Endpoint**: `POST /logout`  
**Controller**: `App\Http\Controllers\Api\AuthController@logout`  
**Access**: Protected (Bearer Token Required)

## Resource Endpoints

All resource endpoints require authentication via Bearer token:
```
Authorization: Bearer your-token-here
Accept: application/json
```

### Books API
**Controller**: `App\Http\Controllers\Api\BookController`

- **GET /books** - List all books (paginated)
  - Query Parameters: `per_page` (default: 10), `page`
- **POST /books** - Create a new book
- **GET /books/{id}** - Get specific book
- **PUT /books/{id}** - Update book
- **DELETE /books/{id}** - Delete book

**Book Creation/Update Request**:
```json
{
    "title": "The Great Gatsby",
    "author_id": 1,
    "genres": [1, 2, 3]
}
```

### Authors API
**Controller**: `App\Http\Controllers\Api\AuthorController`

- **GET /authors** - List all authors (paginated)
- **POST /authors** - Create a new author
- **GET /authors/{id}** - Get specific author
- **PUT /authors/{id}** - Update author
- **DELETE /authors/{id}** - Delete author

**Author Creation/Update Request**:
```json
{
    "name": "F. Scott Fitzgerald"
}
```

### Genres API
**Controller**: `App\Http\Controllers\Api\GenreController`

- **GET /genres** - List all genres (paginated)
- **POST /genres** - Create a new genre
- **GET /genres/{id}** - Get specific genre
- **PUT /genres/{id}** - Update genre
- **DELETE /genres/{id}** - Delete genre

**Genre Creation/Update Request**:
```json
{
    "name": "Fiction"
}
```

### Relationships API
**Endpoint**: `GET /relationships`  
**Controller**: `App\Http\Controllers\Api\BookController@relationships`  
**Access**: Protected

Returns comprehensive relationship data including:
- Books with ratings
- Authors with book counts
- Genres with book counts
- Top-rated books

## API Response Format

### Success Response
```json
{
    "success": true,
    "data": {...},
    "message": "Operation completed successfully"
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error description",
    "errors": {...}
}
```

### Pagination Response
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [...],
        "first_page_url": "http://localhost:8000/api/books?page=1",
        "from": 1,
        "last_page": 3,
        "last_page_url": "http://localhost:8000/api/books?page=3",
        "links": [...],
        "next_page_url": "http://localhost:8000/api/books?page=2",
        "path": "http://localhost:8000/api/books",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 25
    },
    "message": "Data retrieved successfully"
}
```

## Error Codes

- **401 Unauthorized**: Token missing, invalid, or expired
- **422 Unprocessable Entity**: Validation errors
- **404 Not Found**: Resource not found
- **500 Internal Server Error**: Server error

## Example Usage with cURL

### Register and Login
```bash
# Register
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'

# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

### Using Protected Endpoints
```bash
# Get all books
curl -X GET http://localhost:8000/api/books \
  -H "Authorization: Bearer your-token-here" \
  -H "Accept: application/json"

# Create a book
curl -X POST http://localhost:8000/api/books \
  -H "Authorization: Bearer your-token-here" \
  -H "Content-Type: application/json" \
  -d '{"title":"1984","author_id":1,"genres":[1,2]}'
```

## Directory Structure

```
app/Http/Controllers/Api/
├── AuthController.php       # Authentication endpoints
├── BookController.php       # Book CRUD operations
├── AuthorController.php     # Author CRUD operations
└── GenreController.php      # Genre CRUD operations
```

## Token Management

### Viewing Tokens in Database
Tokens are stored in the `personal_access_tokens` table with the following structure:
- `id` - Token ID
- `tokenable_type` - Model type (App\Models\User)
- `tokenable_id` - User ID
- `name` - Token name (libretto-token)
- `token` - Hashed token value
- `abilities` - Token permissions
- `last_used_at` - Last usage timestamp
- `expires_at` - Token expiration
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

### Token Lifecycle
1. User logs in via `/api/login`
2. System checks for existing valid tokens
3. If valid token exists, returns existing token
4. If no valid token, creates new token (expires in 1 minute)
5. Old tokens are automatically deleted when new ones are created
6. Tokens can be manually revoked via `/api/logout`

## Notes

- All API controllers are now properly separated in the `Api` namespace
- Original web controllers are clean and only contain web-specific methods
- Token expiration is set to 1 minute for testing (configurable)
- One active token per user policy is enforced
- All responses follow consistent JSON format 