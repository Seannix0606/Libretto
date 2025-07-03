<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Libretto - Laravel Book Management System with Sanctum API

A comprehensive book management system built with Laravel, featuring both web interface and REST API with token-based authentication using Laravel Sanctum.

## Features

### Web Interface
- User authentication (login/register)
- Book management (CRUD operations)
- Author management
- Genre management
- Book-author-genre relationships
- Dashboard with statistics

### API Features
- Token-based authentication with Sanctum
- 24-hour token expiration
- Automatic token regeneration on login if expired
- Full CRUD operations for books, authors, and genres
- RESTful API endpoints
- JSON responses

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan serve`

## API Documentation

### Authentication Endpoints

#### Register
```
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login
```
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

Response includes:
- `token`: Bearer token for authentication
- `expires_at`: Token expiration date (24 hours)
- `token_regenerated`: Boolean indicating if a new token was created

#### Logout
```
POST /api/logout
Authorization: Bearer {token}
```

#### Refresh Token
```
POST /api/refresh-token
Authorization: Bearer {token}
```

### Resource Endpoints

All resource endpoints require authentication:
```
Authorization: Bearer {your-token}
```

#### Books
- `GET /api/books` - List all books (paginated)
- `POST /api/books` - Create a new book
- `GET /api/books/{id}` - Get specific book
- `PUT /api/books/{id}` - Update book
- `DELETE /api/books/{id}` - Delete book
- `GET /api/relationships` - Get book relationships data

#### Authors
- `GET /api/authors` - List all authors (paginated)
- `POST /api/authors` - Create a new author
- `GET /api/authors/{id}` - Get specific author
- `PUT /api/authors/{id}` - Update author
- `DELETE /api/authors/{id}` - Delete author

#### Genres
- `GET /api/genres` - List all genres (paginated)
- `POST /api/genres` - Create a new genre
- `GET /api/genres/{id}` - Get specific genre
- `PUT /api/genres/{id}` - Update genre
- `DELETE /api/genres/{id}` - Delete genre

### Example API Usage

#### Create a Book
```
POST /api/books
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "The Great Gatsby",
    "author_id": 1,
    "genres": [1, 2]
}
```

#### Get Books with Pagination
```
GET /api/books?per_page=5&page=1
Authorization: Bearer {token}
```

## Token Management

- Tokens expire after 24 hours
- When logging in, the system checks if the current token is still valid
- If valid, returns the existing token
- If expired, automatically generates a new token
- Only one token per user is active at a time
- Use `/api/refresh-token` to check token status and refresh if needed

## Response Format

All API responses follow this format:

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {...}
}
```

Error responses:
```json
{
    "success": false,
    "message": "Error description",
    "errors": {...}
}
```
