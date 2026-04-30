// api.js - Centralized API calls for Latticework MVP

// ==========================================
// CONFIGURACIÓN GLOBAL DE ENTORNO (API)
// ==========================================
// Reemplaza esta variable con la ruta real de tu backend PHP en cPanel
const API_BASE_URL = 'https://latticework.mx/api';

// Cambia a FALSE para desactivar el Mock y consumir el backend PHP real
const DEMO_MODE = false;
// ==========================================

/**
 * Mocks a promise response for demonstration purposes without a real backend.
 */
function mockResponse(data, delay = 800) {
    return new Promise((resolve) => {
        setTimeout(() => resolve({
            ok: true,
            json: () => Promise.resolve(data)
        }), delay);
    });
}

/**
 * Service to handle API requests securely
 */
const ApiService = {
    // Helper para obtener token (placeholder para manejo real de JWT)
    getToken: () => localStorage.getItem('fintech_token'),

    // 0. Autenticación (Login)
    async login(email, password) {
        if (DEMO_MODE) {
            console.log(`[Mock API] POST /login.php`, { email, password });
            const mockData = await this.getMockData('/login.php', { email, password });
            localStorage.setItem('fintech_token', mockData.token);
            localStorage.setItem('fintech_user', JSON.stringify(mockData.user));
            return mockData;
        }

        try {
            const response = await fetch(`${API_BASE_URL}/login.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Error en el login');
            }
            localStorage.setItem('fintech_token', data.token);
            localStorage.setItem('fintech_user', JSON.stringify(data.user));
            return data;
        } catch (error) {
            console.error('API Login failed:', error);
            throw error;
        }
    },

    // Generic Fetch Wrapper
    async request(endpoint, method = 'GET', body = null) {
        if (DEMO_MODE) {
            console.log(`[Mock API] ${method} ${endpoint}`, body || '');
            return this.getMockData(endpoint);
        }

        const headers = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.getToken()}`
        };

        const config = {
            method,
            headers,
        };

        if (body) {
            config.body = JSON.stringify(body);
        }

        try {
            const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
            if (!response.ok) {
                const errData = await response.json();
                throw new Error(errData.message || 'Error en la petición API');
            }
            return await response.json();
        } catch (error) {
            console.error('API Request failed:', error);
            throw error;
        }
    },

    // 1. Consulta de Balance
    async getBalance(userId = null) {
        if (!userId) {
            const impId = localStorage.getItem('impersonatingId');
            const userStr = localStorage.getItem('fintech_user');
            if (impId && userStr) {
                try {
                    const u = JSON.parse(userStr);
                    if (u.role === 'superadmin' || u.role === 'subadmin') userId = impId;
                } catch(e){}
            }
        }
        const endpoint = userId ? `/user/balance.php?userId=${userId}` : '/user/balance.php';
        return this.request(endpoint);
    },

    // 2. Buscador Predictivo (Admin)
    async searchUsers(query) {
        if (!query || query.length < 2) return { users: [] };
        return this.request(`/admin/search_users.php?q=${encodeURIComponent(query)}`);
    },

    // 3. Creación de Usuario (Admin)
    async createUser(userData) {
        return this.request('/admin/create_user.php', 'POST', userData);
    },

    // 4. Registrar Transacción (Admin)
    async registerTransaction(transactionData) {
        return this.request('/admin/register_transaction.php', 'POST', transactionData);
    },

    // 5. Admin Stats
    async getAdminStats() {
        return this.request('/admin/stats.php');
    },

    // 6. Lista de Usuarios (Admin)
    async getAdminUsers() {
        return this.request('/admin/list_users.php');
    },

    // 7. Lista de Transacciones de Perfil (Usuario)
    async getUserTransactions(userId = null) {
        if (!userId) {
            const impId = localStorage.getItem('impersonatingId');
            const userStr = localStorage.getItem('fintech_user');
            if (impId && userStr) {
                try {
                    const u = JSON.parse(userStr);
                    if (u.role === 'superadmin' || u.role === 'subadmin') userId = impId;
                } catch(e){}
            }
        }
        const endpoint = userId ? `/user/transactions.php?userId=${userId}` : '/user/transactions.php';
        return this.request(endpoint);
    },

    // 8. Actualizar Perfil Financiero desde Dashboard (Admin)
    async updateAdminUser(userData) {
        return this.request('/admin/update_financial_profile.php', 'PUT', userData);
    },

    // 9. Historial Transacciones (Admin)
    async getAdminTransactions() {
        return this.request('/admin/list_transactions.php');
    },

    // 10. Crear Usuario (Admin)
    async createUser(userData) {
        return this.request('/admin/create_user.php', 'POST', userData);
    },

    // 11. Actualizar Perfil (Configuración)
    async updateProfile(formData) {
        // Al enviar FormData, no debemos setear el Content-Type para que el browser haga el multipart boundary
        const token = localStorage.getItem('fintech_token');
        const options = {
            method: 'POST',
            body: formData
        };

        if (token) {
            options.headers = { 'Authorization': 'Bearer ' + token };
        }

        const url = API_BASE_URL + '/user/update_profile.php';
        if (DEMO_MODE) {
            return this.getMockData(url, formData);
        }

        const response = await fetch(url, options);
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Error al actualizar el perfil');
        return data;
    },

    // --- Mock Data Generators based on api-endpoints.md ---
    getMockData(endpoint, body = null) {
        if (endpoint.includes('/login.php')) {
            // Simulamos respuesta exitosa dependiendo del body si se desea, 
            // pero para DEMO devolvemos un token y admin para que sirva de demo.
            return mockResponse({
                message: "Login successful.",
                token: "eyJ0eXAiOiJKV1QiDemoToken123",
                user: {
                    id: 1,
                    email: body ? body.email : "demo@ejemplo.com",
                    role: body && body.email.includes("user") ? "user" : "admin"
                }
            });
        }

        if (endpoint.includes('/balance.php')) {
            const urlParams = new URLSearchParams(endpoint.split('?')[1] || "");
            const reqUserId = urlParams.get('userId');

            if (reqUserId) {
                return mockResponse({
                    message: "Balance retrieved (Impersonated View).",
                    userId: reqUserId,
                    balance: {
                        totalDeposits: 850000.00,
                        totalWithdrawals: 10000.00,
                        netDeposits: 840000.00,
                        annualReturnRate: 15.5,
                        annualReturn: 130200.00,
                        totalBalance: 970200.00,
                        riskProfile: "High"
                    }
                });
            }

            return mockResponse({
                message: "Balance retrieved successfully.",
                userId: 2,
                balance: {
                    totalDeposits: 15000.00,
                    totalWithdrawals: 2000.00,
                    netDeposits: 13000.00,
                    annualReturnRate: 10.5,
                    annualReturn: 1365.00,
                    totalBalance: 14365.00,
                    riskProfile: "Moderate"
                }
            });
        }

        if (endpoint.includes('/admin/search_users.php')) {
            return mockResponse({
                message: "Search results.",
                count: 3,
                users: [
                    { id: 1, firstName: "Juan", lastName: "Pérez", email: "juan.perez@ejemplo.com", phone: "5512345678", publicUrl: "/PublicProfile?userId=1" },
                    { id: 2, firstName: "Julio", lastName: "García", email: "julio@empresa.com", phone: "5587654321", publicUrl: "/PublicProfile?userId=2" },
                    { id: 3, firstName: "Juana", lastName: "Martínez", email: "juana.m@startup.io", phone: "5599887766", publicUrl: "/PublicProfile?userId=3" }
                ]
            });
        }

        if (endpoint.includes('/admin/stats.php')) {
            return mockResponse({
                totalAUM: 1250500.00,
                totalTransactions: 1432,
                totalYields: 85200.00,
                activeUsers: 850
            });
        }

        if (endpoint.includes('/admin/list_users.php')) {
            return mockResponse({
                users: [
                    { id: 1, firstName: "Juan", lastName: "Pérez", email: "juan.perez@ejemplo.com", annualReturnRate: 12.5, totalBalance: 150000.00, riskProfile: "Moderate" },
                    { id: 2, firstName: "Julio", lastName: "García", email: "julio@empresa.com", annualReturnRate: 10.0, totalBalance: 85000.00, riskProfile: "Low" },
                    { id: 3, firstName: "Juana", lastName: "Martínez", email: "juana.m@startup.io", annualReturnRate: 15.2, totalBalance: 320500.00, riskProfile: "High" }
                ]
            });
        }

        if (endpoint.includes('/user/transactions.php')) {
            const urlParams = new URLSearchParams(endpoint.split('?')[1] || "");
            const reqUserId = urlParams.get('userId');

            if (reqUserId) {
                return mockResponse({
                    transactions: [
                        { id: 201, date: "2026-03-24T10:00:00", description: "Depósito VIP Impersonated", type: "deposit", amount: 800000.00, status: "completed" },
                        { id: 202, date: "2026-03-20T12:00:00", description: "Cargo Administrativo", type: "withdrawal", amount: 10000.00, status: "completed" }
                    ]
                });
            }

            return mockResponse({
                transactions: [
                    { id: 101, date: "2026-03-15T10:30:00", description: "Depósito Inicial STP", type: "deposit", amount: 15000.00, status: "completed" },
                    { id: 102, date: "2026-03-10T14:15:00", description: "Rendimiento Mensual Acumulado", type: "yield", amount: 250.00, status: "completed" },
                    { id: 103, date: "2026-02-28T09:00:00", description: "Retiro a Cuenta 1234", type: "withdrawal", amount: 2000.00, status: "pending" }
                ]
            });
        }

        if (endpoint.includes('/user/update_profile.php')) {
            return mockResponse({ status: "success", message: "Perfil actualizado correctamente." });
        }

        return mockResponse({ message: "Success (Mock)" });
    }
};
