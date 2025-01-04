# Endpoints

---

- [Routes Overview](#section-1)
- [Registration](#section-2)
- [Authentication](#section-3)
- [Order](#section-4)
- [Wallet](#section-5)

<a name="section-1"></a>
## Routes Overview
The routes for each specification from registration, authentication, order and wallet related 
actions have been fully documented with the expected responses <a href="/api/documentation">here</a>.

<a name="section-2"></a>
## Registration
- **POST** `/api/register`: User Registration

<a name="section-3"></a>
## Authentication
- **POST** `/api/validate`: Token Validation
- **POST** `/api/login`: Login User
- **POST** `/api/login`: Token Refresh

<a name="section-4"></a>
## Order
- **POST** `/api/order/initiate`: Start an Order if balance permits.
- **GET** `/api/order/status`: Retrieve Order Status.

<a name="section-5"></a>
## Wallet
- **GET** `/api/wallet/balance`: Fetch user balance
- **POST** `/api/wallet/transfer`: Simulate wallet transfer