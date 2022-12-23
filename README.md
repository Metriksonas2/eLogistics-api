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

## API Endpoints

### API Formats

You can choose to receive responses as standard **JSON** format or **LD+JSON** format.
### Authorization

To authorize, you need to make a POST request to ```/api/login_check``` API route with login credentials to receive a JWT access token. Then this token is used in every HTTP request ```Authorization``` header like this:
```http
Authorization: Bearer "token goes here"
```
### POST "/api/login_check"

Retrieves an access token if credentials are correct.

#### Request

- `email` (string): The email of the user.
- `password` (string): The password of the user

#### Response

The response body will contain a list of vehicle objects, each with the following properties:

- `token` (string): The unique JWT access token for the user identification.

## Vehicle

### GET "/api/vehicles"

Retrieves a list of vehicles.

#### Request

No request body is required for this route.

#### Response

The response body will contain a list of vehicle objects, each with the following properties:

- `id` (integer): The unique identifier for the vehicle.
- `fuelTankCapacity` (integer): The fuel tank capacity of the vehicle.
- `licensePlate` (string): The license plate of the vehicle.
- `fuelType` (string): The fuel type of the vehicle.
- `gearbox` (string): The gearbox type of the vehicle.
- `cargos` ("Cargo" entity collection): All cargos that should be delivered by this vehicle.

### POST "/api/vehicles"

Creates a new vehicle.

#### Request

The request body should contain a JSON object with the following properties:

- `fuelTankCapacity` (integer): The fuel tank capacity of the vehicle.
- `fuelType` (string): The fuel type of the vehicle.
- `gearbox` (integer): The gearbox type of the vehicle.
- `cargos(optional)` ("Cargo" entity collection): All cargos that should be delivered by this vehicle.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the vehicle.
- `fuelTankCapacity` (integer): The fuel tank capacity of the vehicle.
- `licensePlate` (string): The license plate of the vehicle.
- `fuelType` (string): The fuel type of the vehicle.
- `gearbox` (string): The gearbox type of the vehicle.
- `cargos` ("Cargo" entity collection): All cargos that should be delivered by this vehicle.

### GET "/api/vehicles/{id}"

Retrieves a specific vehicle by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the vehicle.
- `fuelTankCapacity` (integer): The fuel tank capacity of the vehicle.
- `licensePlate` (string): The license plate of the vehicle.
- `fuelType` (string): The fuel type of the vehicle.
- `gearbox` (string): The gearbox type of the vehicle.
- `cargos` ("Cargo" entity collection): All cargos that should be delivered by this vehicle.

### PUT "/api/vehicles/{id}"

Updates a specific vehicle by its `id`.

#### Request

The request body can contain a JSON object with the any of the following properties:

- `fuelTankCapacity` (integer): The fuel tank capacity of the vehicle.
- `fuelType` (string): The fuel type of the vehicle.
- `gearbox` (integer): The gearbox type of the vehicle.

#### Response

- `id` (integer): The unique identifier for the vehicle.
- `fuelTankCapacity` (integer): The fuel tank capacity of the vehicle.
- `licensePlate` (string): The license plate of the vehicle.
- `fuelType` (string): The fuel type of the vehicle.
- `gearbox` (string): The gearbox type of the vehicle.
- `cargos` ("Cargo" entity collection): All cargos that should be delivered by this vehicle.

### DELETE "/api/vehicles/{id}"

Deletes a specific vehicle by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will be empty with ``204 No Content`` response code.

## Cargo

### GET "/api/cargos"

Retrieves a list of cargos.

#### Request

No request body is required for this route.

#### Response

The response body will contain a list of cargo objects, each with the following properties:

- `id` (integer): The unique identifier for the cargo.
- `name` (string): The name of the cargo.
- `identifier` (string): The global standard identifier code of the cargo.
- `color` (string): The color of the cargo.
- `totalWeight` (integer): Total weight of the cargo.
- `vehicle` ("Vehicle" entity): Vehicle that will deliver this cargo.
- `items` ("Item" entity collection): All containing items in this cargo.

### POST "/api/cargos"

Creates a new cargo.

#### Request

The request body should contain a JSON object with the following properties:

- `name` (string): The name of the cargo.
- `identifier` (string): The global standard identifier code of the cargo.
- `color` (string): The color of the cargo.
- `totalWeight` (integer): Total weight of the cargo.
- `vehicle(optional)` ("Vehicle" entity): Vehicle that will deliver this cargo.
- `items(optional)` ("Item" entity collection): All containing items in this cargo.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the cargo.
- `name` (string): The name of the cargo.
- `identifier` (string): The global standard identifier code of the cargo.
- `color` (string): The color of the cargo.
- `totalWeight` (integer): Total weight of the cargo.
- `vehicle` ("Vehicle" entity): Vehicle that will deliver this cargo.
- `items` ("Item" entity collection): All containing items in this cargo.

### GET "/api/cargos/{id}"

Retrieves a specific cargo by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the cargo.
- `name` (string): The name of the cargo.
- `identifier` (string): The global standard identifier code of the cargo.
- `color` (string): The color of the cargo.
- `totalWeight` (integer): Total weight of the cargo.
- `vehicle` ("Vehicle" entity): Vehicle that will deliver this cargo.
- `items` ("Item" entity collection): All containing items in this cargo.

### PUT "/api/cargos/{id}"

Updates a specific cargo by its `id`.

#### Request

The request body can contain a JSON object with the any of the following properties:

- `name` (string): The name of the cargo.
- `identifier` (string): The global standard identifier code of the cargo.
- `color` (string): The color of the cargo.
- `totalWeight` (integer): Total weight of the cargo.
- `vehicle` ("Vehicle" entity): Vehicle that will deliver this cargo.

#### Response

- `id` (integer): The unique identifier for the cargo.
- `name` (string): The name of the cargo.
- `identifier` (string): The global standard identifier code of the cargo.
- `color` (string): The color of the cargo.
- `totalWeight` (integer): Total weight of the cargo.
- `vehicle` ("Vehicle" entity): Vehicle that will deliver this cargo.
- `items` ("Item" entity collection): All containing items in this cargo.

### DELETE "/api/cargos/{id}"

Deletes a specific cargo by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will be empty with ``204 No Content`` response code.

## Item

### GET "/api/items"

Retrieves a list of items.

#### Request

No request body is required for this route.

#### Response

The response body will contain a list of item objects, each with the following properties:

- `id` (integer): The unique identifier for the item.
- `name` (string): The name of the item.
- `weight` (integer): Total weight of the item.
- `cargos` ("Cargo" entity collection): All cargos where this item contains.

### POST "/api/items"

Creates a new item.

#### Request

The request body should contain a JSON object with the following properties:

- `name` (string): The name of the item.
- `weight` (integer): Total weight of the item.
- `cargos(optional)` ("Cargo" entity collection): All cargos where this item contains.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the item.
- `name` (string): The name of the item.
- `weight` (integer): Total weight of the item.
- `cargos` ("Cargo" entity collection): All cargos where this item contains.

### GET "/api/items/{id}"

Retrieves a specific item by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the item.
- `name` (string): The name of the item.
- `weight` (integer): Total weight of the item.
- `cargos` ("Cargo" entity collection): All cargos where this item contains.

### PUT "/api/items/{id}"

Updates a specific item by its `id`.

#### Request

The request body can contain a JSON object with the any of the following properties:

- `name` (string): The name of the item.
- `weight` (integer): Total weight of the item.

#### Response

- `id` (integer): The unique identifier for the item.
- `name` (string): The name of the item.
- `weight` (integer): Total weight of the item.
- `cargos` ("Cargo" entity collection): All cargos where this item contains.

### DELETE "/api/items/{id}"

Deletes a specific item by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will be empty with ``204 No Content`` response code.

## User

### GET "/api/users"

Retrieves a list of users (``Only admin can access``).

#### Request

No request body is required for this route.

#### Response

The response body will contain a list of user objects, each with the following properties:

- `id` (integer): The unique identifier for the user.
- `email` (string): The email of the user.
- `roles` (string collection): All the roles of this user.

### POST "/api/users"

Creates a new user.

#### Request

The request body should contain a JSON object with the following properties:

- `email` (string): The email of the user.
- `password` (string): The password of the user.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the user.
- `email` (string): The email of the user.
- `roles` (string collection): All the roles of this user.

### GET "/api/users/{id}"

Retrieves a specific user by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will contain a JSON object with the following properties:

- `id` (integer): The unique identifier for the user.
- `email` (string): The email of the user.
- `roles` (string collection): All the roles of this user.

### PUT "/api/users/{id}"

Updates a specific user by its `id`.

#### Request

The request body can contain a JSON object with the any of the following properties:

- `email` (string): The email of the user.
- `roles` (string collection): All the roles of this user.

#### Response

- `id` (integer): The unique identifier for the user.
- `email` (string): The email of the user.
- `roles` (string collection): All the roles of this user.

### DELETE "/api/users/{id}"

Deletes a specific user by its `id`.

#### Request

No request body is required for this route.

#### Response

The response body will be empty with ``204 No Content`` response code.

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