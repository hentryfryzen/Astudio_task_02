Basic Setup Instructions

    Clone the Repository:
    bash
    Copy

    git clone https://github.com/your-repo/order-approval-system.git
    cd order-approval-system

    Install Dependencies:
    bash
    Copy

    composer install

    Set Up Environment:

        Copy .env.example to .env:
        bash
        Copy

        cp .env.example .env

        Update .env with your database credentials:
        env
        Copy

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=order_approval
        DB_USERNAME=root
        DB_PASSWORD=

    Generate Application Key:
    bash
    Copy

    php artisan key:generate

    Run Migrations:
    bash
    Copy

    php artisan migrate

    Start the Development Server:
    bash
    Copy

    php artisan serve

    Access the Application:

        The API will be available at http://localhost:8000.

API Documentation
# Laravel API for Order Management

This is a simple Laravel application that handles order management with a basic approval workflow. All API routes are prefixed with `/api`.

## API Endpoints

### 1. **Create an Order (POST /api/orders)**

Creates a new order with multiple items.

**Request:**
```sh
curl -X POST http://localhost:8000/api/orders \
     -H "Content-Type: application/json" \
     -d '{
           "items": [
               {"product_name": "Laptop", "quantity": 1, "price": 1200},
               {"product_name": "Mouse", "quantity": 2, "price": 50}
           ]
         }'

Response:

    201 Created: Order created successfully
    400 Bad Request: Invalid input

2. Get All Orders (GET /api/orders)

Fetches a list of all orders.

Request:

curl -X GET http://localhost:8000/api/orders

Response:

    200 OK: Returns an array of all orders

3. Get a Single Order by ID (GET /api/orders/{id})

Fetches an order by its ID.

Request:

curl -X GET http://localhost:8000/api/orders/1

Response:

    200 OK: Returns the details of the order with the given ID
    404 Not Found: Order with the given ID does not exist

4. Approve an Order (PUT /api/orders/{id}/approval)

Approves an order. Orders above $1000 require approval.

Request:

curl -X PUT http://localhost:8000/api/orders/1/approval \
     -H "Content-Type: application/json" \
     -d '{
           "approved": true
         }'

Response:

    200 OK: Order approved successfully
    400 Bad Request: Invalid approval status or other validation issues
    404 Not Found: Order with the given ID does not exist

5. Delete an Order (DELETE /api/orders/{id})

Deletes an order by its ID.

Request:

curl -X DELETE http://localhost:8000/api/orders/1

Response:

    200 OK: Order deleted successfully
    404 Not Found: Order with the given ID does not exist

6. Get Order History (GET /api/orders/{id}/history)

Fetches the history of an order (e.g., status changes, approval).

Request:

curl -X GET http://localhost:8000/api/orders/1/history

Response:

    200 OK: Returns the history of the order with the given ID
    404 Not Found: Order with the given ID does not exist

Testing API with Postman

You can test these endpoints using Postman:

    Open Postman and select the desired HTTP method (POST, GET, PUT, DELETE).
    Enter the full API URL (e.g., http://localhost:8000/api/orders).
    Under Headers, add Content-Type: application/json.
    Under Body (for POST and PUT), select raw and choose JSON.
    Click Send to make the request.

Notes

    All API routes are prefixed with /api.
    The API requires a running Laravel instance on http://localhost:8000.
    Ensure that your application is running and migrations are applied before using these routes.
