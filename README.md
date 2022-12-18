# eLogistics-api documentation

## About project

Technologies used for the project:

* Front end - **React** (``/eLogistics-client`` repository)
* Back end - **PHP** (Symfony)

---

## Project goal

To create a system called "eLogistics", where clients would be able to sign up, create cargos from listed items, buy listed orders from orders list.

## What is this application?

This is a simple CRUD type logistics app for creating or accepting cargos. You can also create your own cargos from listed items, that will be included in your created orders.

## How to prepare application?

To build Docker Containers for an API:

* ```shell
    cd ./api
    docker-compose up -d
  ```

After building Docker containers:

* ```shell
    composer install
  ```

Make sure to run all the migrations:

* ```shell
    php bin/console doctrine:migrations:migrate
  ```

Uncomment database configuration line in .env file based on which server you are using (Symfony or Docker Apache).

---

## Entities

Currently, there are 4 main entities:

* **User**
* **Vehicle**
* **Cargo**
* **Item**
* **Order** (not added yet)

## API Endpoints

### Vehicle

#### Collection operations:

```shell
  GET: '/api/vehicles'
  POST: '/api/vehicles'
```

#### Item operations:

```shell
  GET: '/api/vehicles/{id}'
  PUT: '/api/vehicles/{id}'
  DELETE: '/api/vehicles/{id}'
```

### Cargo

#### Collection operations:

```shell
  GET: '/api/cargos'
  POST: '/api/cargos'
```

#### Item operations:

```shell
  GET: '/api/cargos/{id}'
  PUT: '/api/cargos/{id}'
  DELETE: '/api/cargos/{id}'
```

### Item

#### Collection operations:

```shell
  GET: '/api/items'
  POST: '/api/items'
```

#### Item operations:

```shell
  GET: '/api/items/{id}'
  PUT: '/api/items/{id}'
  DELETE: '/api/items/{id}'
```

### User

#### Collection operations:

```shell
  GET: '/api/users'
  POST: '/api/users'
```

#### Item operations:

```shell
  GET: '/api/users/{id}'
  PUT: '/api/users/{id}'
  DELETE: '/api/users/{id}'
```

### Subresources:

#### Collection operations:

```shell
  GET: '/api/vehicles/{vehicleId}/cargos'
  GET: '/api/users/{userId}/cargos'
  GET: '/api/cargos/{cargoId}/items'
  GET: '/api/vehicles/{vehicleId}/cargos/{cargoId}/items'
```

#### Item operations:

```shell
  GET: '/api/vehicles/{vehicleId}/cargos/{cargoId}'
  GET: '/api/users/{userId}/cargos/{cargoId}'
  GET: '/api/cargos/{cargoId}/items/{itemId}'
  GET: '/api/vehicles/{vehicleId}/cargos/{cargoId}/items/{itemId}'
```

## Access control

### User

* Only admin can view, edit or delete users
  
### Vehicle

* Currently, no restrictions

### Cargo

* Everyone can view and add cargos
* Only admin or **cargo owner** can edit and delete cargo
* Only cargo owners can see their owned cargos via `/users/{userId}/cargos` or `/users/{userId}/cargos/{cargoId}` routes

### Item

* Everyone can view all items
* Only admin can edit, add and delete items