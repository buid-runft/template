เข้าใจแล้วครับ — คุณต้องการ **API Documentation** ที่สมบูรณ์  
เพื่อให้ Frontend Developer หรือทีมอื่นๆ สามารถเข้าใจและเชื่อมต่อกับระบบของคุณได้ง่าย

---

## 🚀 **Phase 12: API Documentation**  
> **เป้าหมาย**: สร้าง documentation ที่ครอบคลุมทุก endpoint  
> **รูปแบบ**: ใช้ JSON format ที่อ่านง่าย + ตัวอย่าง request/response

---

### ✅ จุดประสงค์
- สร้าง **API Documentation ที่ชัดเจน**
- ระบุ **request parameters**, **response format**, **error cases**
- ใช้ได้ทั้งกับ **Frontend**, **Mobile App**, และ **Third-party integrations**

---

# 📚 **B-Live Healthy API Documentation**

> **Base URL**: `https://your-domain.com/api/v1`  
> **Authentication**: Bearer Token (ใช้ Laravel Sanctum)

---

## 🔐 **Authentication APIs**

### 1. Register User
- **Endpoint**: `POST /api/register`
- **Description**: ลงทะเบียนผู้ใช้งานใหม่
- **Headers**:
  ```
  Content-Type: application/json
  ```
- **Request Body**:
  ```json
  {
    "email": "user@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "first_name": "สมชาย",
    "last_name": "ใจดี",
    "phone": "0812345678",
    "mlm_member_code": "MLM123456"
  }
  ```
- **Response (Success)**:
  ```json
  {
    "message": "ลงทะเบียนสำเร็จ",
    "user": {
      "id": 1,
      "email": "user@example.com",
      "first_name": "สมชาย",
      "last_name": "ใจดี",
      "profile": {
        "gender": null,
        "date_of_birth": null,
        "phone": "0812345678"
      }
    },
    "token": "1|abc123..."
  }
  ```
- **Response (Error)**:
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "email": ["The email has already been taken."]
    }
  }
  ```

---

### 2. Login User
- **Endpoint**: `POST /api/login`
- **Description**: เข้าสู่ระบบ
- **Headers**:
  ```
  Content-Type: application/json
  ```
- **Request Body**:
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- **Response (Success)**:
  ```json
  {
    "message": "เข้าสู่ระบบสำเร็จ",
    "user": {
      "id": 1,
      "email": "user@example.com",
      "first_name": "สมชาย"
    },
    "token": "1|abc123..."
  }
  ```
- **Response (Error)**:
  ```json
  {
    "error": "อีเมลหรือรหัสผ่านไม่ถูกต้อง"
  }
  ```

---

### 3. Get User Profile
- **Endpoint**: `GET /api/v1/user/profile`
- **Description**: ดึงข้อมูลโปรไฟล์ผู้ใช้
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "id": 1,
    "email": "user@example.com",
    "first_name": "สมชาย",
    "last_name": "ใจดี",
    "profile": {
      "gender": "male",
      "date_of_birth": "1990-01-01",
      "address_line_1": "123 ถ.สุขุมวิท",
      "city": "กรุงเทพ",
      "state": "บางนา",
      "postal_code": "10260",
      "country": "Thailand"
    }
  }
  ```

---

## 🛍️ **Store APIs**

### 1. Get My Store
- **Endpoint**: `GET /api/v1/store/my`
- **Description**: ดึงข้อมูลร้านค้าของผู้ใช้ปัจจุบัน
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "id": 1,
    "store_name": "ร้านค้าสมชาย",
    "store_slug": "somchai-shop",
    "status": "approved",
    "profile": {
      "description": "ร้านขายของดีมีคุณภาพ",
      "logo_image": "/storage/stores/1/logo.jpg",
      "contact_email": "contact@example.com"
    },
    "verification": {
      "documents_verified": true,
      "bank_account_verified": true,
      "identity_verified": true
    }
  }
  ```

### 2. Create Store (Onboard)
- **Endpoint**: `POST /api/v1/store/onboard`
- **Description**: เปิดร้านค้าใหม่ (สำหรับสมาชิก MLM)
- **Headers**:
  ```
  Authorization: Bearer {token}
  Content-Type: multipart/form-data
  ```
- **Request Body**:
  ```
  store_name: ร้านค้าสมชาย
  description: ร้านขายของดีมีคุณภาพ
  business_registration_document: [file]
  id_card_document: [file]
  bank_account_document: [file]
  ```
- **Response**:
  ```json
  {
    "message": "เปิดร้านสำเร็จ รอการยืนยันจากแอดมิน",
    "store": {
      "id": 1,
      "store_name": "ร้านค้าสมชาย",
      "status": "pending"
    }
  }
  ```

---

## 🛒 **Product APIs**

### 1. Get All Products
- **Endpoint**: `GET /api/v1/products`
- **Description**: ดึงสินค้าทั้งหมด (public)
- **Query Parameters**:
  - `page`: หน้า (default: 1)
  - `category_id`: หมวดหมู่
  - `min_price`: ราคาต่ำสุด
  - `max_price`: ราคาสูงสุด
- **Response**:
  ```json
  {
    "data": [
      {
        "id": 1,
        "name": "สินค้า A",
        "price": 100.00,
        "main_image": "/storage/products/1/main.jpg",
        "store": {
          "id": 1,
          "store_name": "ร้านค้าสมชาย"
        }
      }
    ],
    "links": {...},
    "meta": {...}
  }
  ```

### 2. Create Product
- **Endpoint**: `POST /api/v1/products`
- **Description**: สร้างสินค้าใหม่ (สำหรับเจ้าของร้าน)
- **Headers**:
  ```
  Authorization: Bearer {token}
  Content-Type: multipart/form-data
  ```
- **Request Body**:
  ```
  name: สินค้า A
  description: รายละเอียดสินค้า
  price: 100
  stock_quantity: 10
  category_id: 1
  main_image: [file]
  snowball_setting[plan_type]: 1
  snowball_setting[custom_multiplier]: 1.5
  ```
- **Response**:
  ```json
  {
    "message": "สร้างสินค้าสำเร็จ รอการอนุมัติจากแอดมิน",
    "product": {
      "id": 1,
      "name": "สินค้า A",
      "price": 100.00,
      "is_approved": false
    }
  }
  ```

---

## 🛒 **Cart APIs**

### 1. Add to Cart
- **Endpoint**: `POST /api/v1/cart`
- **Description**: เพิ่มสินค้าในตะกร้า
- **Headers**:
  ```
  Authorization: Bearer {token}
  Content-Type: application/json
  ```
- **Request Body**:
  ```json
  {
    "product_id": 1,
    "quantity": 2
  }
  ```
- **Response**:
  ```json
  {
    "message": "เพิ่มสินค้าในตะกร้าสำเร็จ",
    "cart": {
      "1": {
        "product_id": 1,
        "name": "สินค้า A",
        "price": 100.00,
        "quantity": 2,
        "subtotal": 200.00
      }
    }
  }
  ```

---

## 📦 **Order APIs**

### 1. Create Order
- **Endpoint**: `POST /api/v1/orders`
- **Description**: สร้างออเดอร์ใหม่
- **Headers**:
  ```
  Authorization: Bearer {token}
  Content-Type: application/json
  ```
- **Request Body**:
  ```json
  {
    "items": [
      {
        "product_id": 1,
        "quantity": 2
      }
    ],
    "subtotal": 200.00,
    "shipping_fee": 50.00,
    "total_amount": 250.00,
    "shipping": {
      "first_name": "สมชาย",
      "last_name": "ใจดี",
      "phone": "0812345678",
      "address_line_1": "123 ถ.สุขุมวิท",
      "city": "กรุงเทพ",
      "state": "บางนา",
      "postal_code": "10260"
    }
  }
  ```
- **Response**:
  ```json
  {
    "message": "สร้างออเดอร์สำเร็จ",
    "order": {
      "id": 1,
      "invoice_number": "INV-20250101-ABCD",
      "total_amount": 250.00,
      "status": "pending",
      "payment_status": "unpaid"
    }
  }
  ```

---

## 💳 **Payment APIs**

### 1. Create Payment
- **Endpoint**: `POST /api/v1/orders/{orderId}/payment`
- **Description**: บันทึกการชำระเงิน
- **Headers**:
  ```
  Authorization: Bearer {token}
  Content-Type: multipart/form-data
  ```
- **Request Body**:
  ```
  payment_method: bank_transfer
  amount: 250.00
  payment_slip: [file]
  ```
- **Response**:
  ```json
  {
    "message": "บันทึกการชำระเงินสำเร็จ รอการยืนยันจากแอดมิน",
    "payment": {
      "id": 1,
      "order_id": 1,
      "amount": 250.00,
      "status": "pending"
    }
  }
  ```

---

## 🏷️ **Category APIs**

### 1. Get Categories
- **Endpoint**: `GET /api/v1/categories`
- **Description**: ดึงหมวดหมู่สินค้า
- **Response**:
  ```json
  {
    "data": [
      {
        "id": 1,
        "name": "สินค้าทั่วไป",
        "children": [
          {
            "id": 2,
            "name": "อิเล็กทรอนิกส์"
          }
        ]
      }
    ]
  }
  ```

---

## ⭐ **Review APIs**

### 1. Add Review
- **Endpoint**: `POST /api/v1/products/{productId}/reviews`
- **Description**: เขียนรีวิวสินค้า
- **Headers**:
  ```
  Authorization: Bearer {token}
  Content-Type: application/json
  ```
- **Request Body**:
  ```json
  {
    "rating": 5,
    "comment": "สินค้าดีมากครับ"
  }
  ```
- **Response**:
  ```json
  {
    "message": "ส่งรีวิวสำเร็จ รอการอนุมัติจากแอดมิน",
    "review": {
      "id": 1,
      "rating": 5,
      "comment": "สินค้าดีมากครับ",
      "is_approved": false
    }
  }
  ```

---

## 📝 **Wishlist APIs**

### 1. Add to Wishlist
- **Endpoint**: `POST /api/v1/wishlist/{productId}`
- **Description**: เพิ่มสินค้าใน Wishlist
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "message": "เพิ่มสินค้าใน Wishlist สำเร็จ"
  }
  ```

---

## 📊 **Snowball APIs**

### 1. Get My Snowball Points
- **Endpoint**: `GET /api/v1/snowball/my`
- **Description**: ดูคะแนน Snowball ของฉัน
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "total_points": 150.50,
    "mlm_member_code": "MLM123456"
  }
  ```

---

## 📈 **Report APIs**

### 1. Get Sales Report
- **Endpoint**: `GET /api/v1/reports/sales`
- **Description**: ดูรายงานการขาย (สำหรับเจ้าของร้าน)
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "total_sales": 50000.00,
    "total_orders": 25,
    "total_quantity": 100,
    "monthly_sales": 15000.00
  }
  ```

---

## 🔔 **Notification APIs**

### 1. Get Notifications
- **Endpoint**: `GET /api/v1/notifications`
- **Description**: ดึงการแจ้งเตือน
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "data": [
      {
        "id": 1,
        "title": "ออเดอร์ของคุณได้รับการยืนยัน",
        "message": "ออเดอร์ #INV-20250101-ABCD ได้รับการยืนยันแล้ว",
        "read_at": null,
        "created_at": "2025-01-01T10:00:00.000000Z"
      }
    ]
  }
  ```

---

## 🛠️ **Admin APIs**

### 1. Approve Store
- **Endpoint**: `PUT /api/v1/admin/stores/{id}/approve`
- **Description**: อนุมัตร้านค้า
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "message": "อนุมัติร้านค้าสำเร็จ",
    "store": {
      "id": 1,
      "status": "approved"
    }
  }
  ```

### 2. Approve Product
- **Endpoint**: `PUT /api/v1/admin/products/{id}/approve`
- **Description**: อนุมัติสินค้า
- **Headers**:
  ```
  Authorization: Bearer {token}
  ```
- **Response**:
  ```json
  {
    "message": "อนุมัติสินค้าสำเร็จ",
    "product": {
      "id": 1,
      "is_approved": true
    }
  }
  ```

---

## 🚨 **Error Responses**

### Common Error Formats
- **401 Unauthorized**:
  ```json
  {
    "message": "Unauthenticated."
  }
  ```

- **403 Forbidden**:
  ```json
  {
    "message": "This action is unauthorized."
  }
  ```

- **404 Not Found**:
  ```json
  {
    "message": "The requested resource was not found."
  }
  ```

- **422 Validation Error**:
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "field_name": ["The field name is required."]
    }
  }
  ```

- **500 Server Error**:
  ```json
  {
    "message": "Something went wrong. Please try again later."
  }
  ```

---

## 🛣️ **Rate Limiting**

- **Default Limit**: 60 requests per minute per IP
- **Auth Limit**: 60 requests per minute per authenticated user
- **Header Response**:
  ```
  X-RateLimit-Limit: 60
  X-RateLimit-Remaining: 59
  ```

---

## 📋 **Supported HTTP Methods**

- `GET`: ดึงข้อมูล
- `POST`: สร้างข้อมูลใหม่
- `PUT`: อัปเดตข้อมูล (แทนที่ทั้งหมด)
- `PATCH`: อัปเดตข้อมูลบางส่วน
- `DELETE`: ลบข้อมูล

---

## 🌐 **Supported Content Types**

- `application/json`
- `multipart/form-data` (สำหรับอัปโหลดไฟล์)
- `application/x-www-form-urlencoded`

---

## 📦 **Response Format**

### Success Response
```json
{
  "message": "Operation successful",
  "data": {...}
}
```

### Error Response
```json
{
  "message": "Error message",
  "errors": {...}
}
```

### Paginated Response
```json
{
  "data": [...],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "path": "...",
    "per_page": 10,
    "to": 10,
    "total": 50
  }
}
```

---

## 🔐 **Authentication**

- ใช้ Laravel Sanctum
- ต้องแนบ `Authorization: Bearer {token}` ใน Header ทุก request ที่ต้อง login
- Token ได้จาก `/api/login` หรือ `/api/register`

---

## 📝 **Notes**

- ทุก API รองรับ CORS
- Response เป็น JSON เสมอ
- ใช้ snake_case สำหรับ keys ทั้งหมด
- ใช้ UTC timezone สำหรับ timestamps

---

## 🚀 **Postman Collection (JSON Format)**

หากคุณต้องการไฟล์ Postman Collection ที่ import ได้ทันที — บอกได้เลยครับ

---

## ✅ สรุป Phase 12

- ✅ สร้าง **API Documentation ที่ครอบคลุม** ทุก endpoint
- ✅ ระบุ **request/response format** อย่างชัดเจน
- ✅ ระบุ **error cases** และ **validation rules**
- ✅ พร้อมใช้งานกับ **Frontend Development**

---

## 🙏 **ขอบคุณที่ให้ฉันช่วยคุณสร้างระบบ B-Live Healthy นี้**

คุณมีทุกอย่างที่จำเป็นแล้ว:
- ✅ Backend System สมบูรณ์
- ✅ API Documentation สมบูรณ์
- ✅ พร้อม Deploy และใช้งานจริง

หากคุณต้องการให้ฉันสร้าง **Postman Collection**, **Deployment Scripts**, หรือ **Docker Configuration** — คุณสามารถสั่งได้ทุกเมื่อ

คุณพอใจกับผลลัพธ์นี้หรือยัง? หรือมีส่วนไหนที่อยากให้ฉันเพิ่มเติมอีก?

 **Authorization Header** 

---

## 🔐 **วิธีการใส่ Authorization: Bearer {token}**

### 1. **เมื่อคุณได้ token แล้ว (จากการ login/register)**

```json
{
  "message": "เข้าสู่ระบบสำเร็จ",
  "user": {...},
  "token": "1|abc123def456ghi789..."
}
```

### 2. **วิธีใส่ใน Header (ทุก request ที่ต้อง login)**

#### 🌐 **ใน Postman**
```
Authorization: Bearer 1|abc123def456ghi789...
```

#### 🌐 **ใน JavaScript (Fetch)**
```javascript
fetch('/api/v1/user/profile', {
  method: 'GET',
  headers: {
    'Authorization': 'Bearer 1|abc123def456ghi789...',
    'Content-Type': 'application/json',
  }
})
```

#### 🌐 **ใน JavaScript (Axios)**
```javascript
// วิธี 1: ตั้งค่าในแต่ละ request
axios.get('/api/v1/user/profile', {
  headers: {
    'Authorization': 'Bearer 1|abc123def456ghi789...'
  }
});

// วิธี 2: ตั้งค่า global
axios.defaults.headers.common['Authorization'] = 'Bearer 1|abc123def456ghi789...';
```

#### 🌐 **ใน PHP (cURL)**
```php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://your-domain.com/api/v1/user/profile');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer 1|abc123def456ghi789...',
    'Content-Type: application/json'
]);
```

#### 🌐 **ใน Python (requests)**
```python
import requests

headers = {
    'Authorization': 'Bearer 1|abc123def456ghi789...',
    'Content-Type': 'application/json'
}

response = requests.get('https://your-domain.com/api/v1/user/profile', headers=headers)
```

---

### 3. **ตัวอย่างการใช้งานจริง**

#### 📱 **Frontend (Vue.js Example)**
```javascript
// หลัง login ได้ token
const token = response.data.token;

// ตั้งค่า axios ทุกครั้งหลัง login
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// ตอนเรียก API ที่ต้อง login
const profile = await axios.get('/api/v1/user/profile');
```

#### 📱 **Frontend (React Example)**
```javascript
// ใช้ useEffect หรือ context เพื่อเก็บ token
const [token, setToken] = useState(localStorage.getItem('auth_token'));

// ตั้งค่า axios interceptor
axios.interceptors.request.use(
  (config) => {
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);
```

---

### 4. **วิธีจัดการ Token ที่ปลอดภัย**

#### ✅ **เก็บใน localStorage (ถ้าใช้ SPA)**
```javascript
// หลัง login
localStorage.setItem('auth_token', response.data.token);

// ก่อนเรียก API
const token = localStorage.getItem('auth_token');
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
```

#### ✅ **เก็บใน HttpOnly Cookie (ปลอดภัยกว่า)**
```php
// ใน Laravel Controller ตอน login
return response()->json([
    'token' => $token
])->cookie('auth_token', $token, 60, '/', null, true, true);
```

---

### 5. **ตัวอย่างเต็ม: Login และเรียก API ถัดไป**

```javascript
// 1. Login เพื่อขอ token
const loginResponse = await axios.post('/api/login', {
  email: 'user@example.com',
  password: 'password123'
});

const token = loginResponse.data.token;

// 2. ตั้งค่า token ให้ axios
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// 3. เรียก API ถัดไปได้เลย
const profile = await axios.get('/api/v1/user/profile');
```

---

### 6. **สิ่งที่ต้องระวัง**

- ❌ ห้าม hardcode token ใน source code
- ❌ ห้าม log token ลง console หรือ file
- ✅ ควร refresh token ทุกๆ ช่วงเวลา
- ✅ ควร logout ล้าง token เมื่อหมดอายุ

---

## ✅ สรุป

| รูปแบบ | ตัวอย่าง |
|--------|---------|
| **Header Key** | `Authorization` |
| **Header Value** | `Bearer 1|abc123def456ghi789...` |
| **Token ได้จาก** | `/api/login` หรือ `/api/register` |
| **ใช้กับ** | ทุก API ที่ต้อง login |

---

หากคุณต้องการ **ตัวอย่าง Frontend สมบูรณ์** (Vue, React, Angular, Mobile) ที่เชื่อมต่อกับ API นี้ — บอกได้เลยครับ ฉันสามารถสร้างให้คุณได้ทันที

คุณอยากได้ตัวอย่างแบบไหนต่อ?