# API Contract (api-endpoints.md)

Este documento describe los endpoints disponibles en la API del MVP Fintech.

**URL Base (Ejemplo)**: `https://tudominio.com/api`
**Autenticación**: Los endpoints protegidos requieren un encabezado `Authorization` con un token JWT válido:
`Authorization: Bearer <TOKEN>`

---

## 1. Autenticación (Login)

Inicia sesión para obtener el token JWT necesario para acceder a los endpoints protegidos.

- **URL**: `/login.php`
- **Método**: `POST`
- **Protegido**: No

### Request Body (JSON)
```json
{
  "email": "elchamandigital@gmail.com",
  "password": "tu_password_aqui"
}
```

### Response (Exito - 200 OK)
```json
{
  "message": "Login successful.",
  "token": "eyJ0eXAiOiJKV1Qi...",
  "user": {
    "id": 1,
    "email": "elchamandigital@gmail.com",
    "role": "admin"
  }
}
```

---

## 2. Creación de Usuario (Admin)

Permite a un administrador registrar a un nuevo usuario, crear su perfil automáticamente y generar su código QR en formato Base64.

- **URL**: `/admin/create_user.php`
- **Método**: `POST`
- **Protegido**: Sí (Requiere Rol de `admin`)

### Request Body (JSON)
```json
{
  "firstName": "Juan",
  "lastName": "Pérez",
  "email": "juan.perez@ejemplo.com",
  "phone": "5512345678",
  "password": "passwordSeguro123",
  "annualReturnRate": 10.5,
  "riskProfile": "Moderate"
}
```
*Nota: El teléfono debe tener exactamente 10 dígitos. `annualReturnRate` y `riskProfile` son opcionales y se guardarán en el campo JSON dinámico `data` de UserProfile.*

### Response (Exito - 201 Created)
```json
{
  "message": "User created successfully.",
  "user": {
    "id": 2,
    "firstName": "Juan",
    "lastName": "Pérez",
    "email": "juan.perez@ejemplo.com",
    "phone": "5512345678",
    "publicUrl": "/PublicProfile?userId=2",
    "qrCodeBase64": "data:image/svg+xml;base64,PHN2Z..."
  }
}
```

---

## 3. Buscador Predictivo (Admin)

Busca usuarios por nombre parcial, apellido parcial, email parcial o nombre completo.

- **URL**: `/admin/search_users.php?q={termino_de_busqueda}`
- **Método**: `GET`
- **Protegido**: Sí (Requiere Rol de `admin`)

### Query Parameters
- `q` (string): El término de búsqueda parcial (ej. `juan` o `pe`).

### Request Body
*No requiere body*

### Response (Exito - 200 OK)
```json
{
  "message": "Search results.",
  "count": 1,
  "users": [
    {
      "id": 2,
      "firstName": "Juan",
      "lastName": "Pérez",
      "email": "juan.perez@ejemplo.com",
      "phone": "5512345678",
      "publicUrl": "/PublicProfile?userId=2"
    }
  ]
}
```

---

## 4. Consulta de Balance (Cálculo Dinámico)

Obtiene el balance actual de un usuario. Este endpoint recalcula matemáticamente al vuelo las sumas de los depósitos y retiros (`status = completed`) desde el historial de transacciones en la base de datos, garantizando que los datos sean frescos.

- **URL**: `/balance.php`
  *(Para consultar el balance de otro usuario, los admins pueden agregar `?userId=X` a la URL: `/balance.php?userId=2`)*
- **Método**: `GET`
- **Protegido**: Sí (Cualquier usuario autenticado para su propio balance, pero requiere `admin` para ver el balance de otros).

### Request Body
*No requiere body*

### Response (Exito - 200 OK)
```json
{
  "message": "Balance retrieved successfully.",
  "userId": 2,
  "balance": {
    "totalDeposits": 15000.00,
    "totalWithdrawals": 2000.00,
    "netDeposits": 13000.00,
    "annualReturnRate": 10.5,
    "annualReturn": 1365.00,
    "totalBalance": 14365.00,
    "riskProfile": "Moderate"
  }
}
```
*Las fórmulas ejecutadas estrictamente en el backend:*
* `netDeposits = totalDeposits - totalWithdrawals`
* `annualReturn = netDeposits * (annualReturnRate / 100)`
* `totalBalance = netDeposits + annualReturn`

## 5. Obtener Perfil de Usuario Específico (Admin)

Permite a los administradores visualizar todos los datos personales, configuraciones de inversión y estado KYC de un usuario específico. Esto evita enviar un JWT suplantado y se rige por permisos de lectura.

URL: /admin/get_user.php?userId={id}

Método: GET

Protegido: Sí (Requiere Rol de admin, subadmin o superadmin)

Query Parameters

userId (int): ID del usuario a consultar.

Request Body

No requiere body

Response (Exito - 200 OK)

{

"status": "success",

"data": {

"id": 2,

"firstName": "Juan",

"lastName": "Pérez",

"email": "juan.perez@ejemplo.com",

"phone": "5512345678",

"role": "user",

"annualReturnRate": 12.5,

"riskProfile": "Moderado",

"investmentPeriod": "Mensual",

"nextInvestmentDate": "2024-06-18",

"avatarUrl": "uploads/avatar_2_1600000.png",

"kycDocUrl": "uploads/kyc_2_1600000.pdf",

"kycStatus": "under_review",

"publicUrl": "/PublicProfile?userId=2",

"createdAt": "2024-05-18 10:30:00"

}

}

## 6. Actualización de Perfil Financiero (Admin)

Permite a un administrador actualizar exclusivamente las métricas financieras (riesgo, tasa de retorno y periodo) de un usuario en particular. Emplea sintaxis camelCase estricta para sincronizar con la base de datos de producción.

URL: /admin/update_financial_profile.php

Método: PUT

Protegido: Sí (Requiere Rol de admin, subadmin o superadmin)

Request Body (JSON)

{

"userId": 2,

"riskProfile": "Agresivo",

"annualReturnRate": 15.50,

"investmentPeriod": "Quincenal",

"nextInvestmentDate": "2024-07-01"

}

Todos los campos (a excepción de userId) son opcionales y solo se enviarán los que necesiten ser modificados.

Response (Exito - 200 OK)

{

"status": "success",

"message": "Perfil financiero actualizado correctamente.",

"updatedFields": [

":userId",

":riskProfile",

":annualReturnRate"

]

}