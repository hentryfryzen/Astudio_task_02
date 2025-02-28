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
Base URL
Copy

http://localhost:8000/api

1. Create an Order

    Endpoint: POST /orders

    Description: Creates a new order with items and calculates the total amount.

    Request Body:
    json
    Copy

    {
        "items": [
            {
                "product_name": "Product A",
                "quantity": 2,
                "price": 100
            },
            {
                "product_name": "Product B",
                "quantity": 1,
                "price": 200
            }
        ]
    }

    Response:
    json
    Copy

    {
        "id": 1,
        "order_number": "ORD-000001",
        "total_amount": 400,
        "status": "pending",
        "created_at": "2023-10-10T12:00:00.000000Z",
        "updated_at": "2023-10-10T12:00:00.000000Z",
        "items": [
            {
                "id": 1,
                "order_id": 1,
                "product_name": "Product A",
                "quantity": 2,
                "price": 100,
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            },
            {
                "id": 2,
                "order_id": 1,
                "product_name": "Product B",
                "quantity": 1,
                "price": 200,
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            }
        ]
    }

2. View an Order

    Endpoint: GET /orders/{order_id}

    Description: Retrieves details of a specific order, including items and history.

    Response:
    json
    Copy

    {
        "id": 1,
        "order_number": "ORD-000001",
        "total_amount": 400,
        "status": "pending",
        "created_at": "2023-10-10T12:00:00.000000Z",
        "updated_at": "2023-10-10T12:00:00.000000Z",
        "items": [
            {
                "id": 1,
                "order_id": 1,
                "product_name": "Product A",
                "quantity": 2,
                "price": 100,
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            },
            {
                "id": 2,
                "order_id": 1,
                "product_name": "Product B",
                "quantity": 1,
                "price": 200,
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            }
        ],
        "history": [
            {
                "id": 1,
                "order_id": 1,
                "status": "pending",
                "changed_by": "system",
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            }
        ]
    }

3. Approve an Order

    Endpoint: POST /orders/{order_id}/approve

    Description: Approves a pending order.

    Request Body:
    json
    Copy

    {
        "changed_by": "admin"
    }

    Response:
    json
    Copy

    {
        "id": 1,
        "order_number": "ORD-000001",
        "total_amount": 400,
        "status": "approved",
        "created_at": "2023-10-10T12:00:00.000000Z",
        "updated_at": "2023-10-10T12:00:00.000000Z",
        "items": [
            {
                "id": 1,
                "order_id": 1,
                "product_name": "Product A",
                "quantity": 2,
                "price": 100,
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            },
            {
                "id": 2,
                "order_id": 1,
                "product_name": "Product B",
                "quantity": 1,
                "price": 200,
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            }
        ],
        "history": [
            {
                "id": 1,
                "order_id": 1,
                "status": "pending",
                "changed_by": "system",
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            },
            {
                "id": 2,
                "order_id": 1,
                "status": "approved",
                "changed_by": "admin",
                "created_at": "2023-10-10T12:00:00.000000Z",
                "updated_at": "2023-10-10T12:00:00.000000Z"
            }
        ]
    }

4. Error Responses

    Validation Errors:
    json
    Copy

    {
        "message": "The items field is required.",
        "errors": {
            "items": [
                "The items field is required."
            ]
        }
    }

    Order Already Approved:
    json
    Copy

    {
        "message": "Order cannot be approved."
    }

Testing

    Run unit tests:
    bash
    Copy

    php artisan test

    Use Postman or cURL to test the API endpoints.

This setup and documentation should help you get started with the order approval workflow system. Let me know if you need further assistance!
