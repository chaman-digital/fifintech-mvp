// api.js - Centralized API calls for ValoraPay MVP

// ==========================================
// CONFIGURACIÓN GLOBAL DE ENTORNO (API)
// ==========================================
// Reemplaza esta variable con la ruta real de tu backend PHP en cPanel
const API_BASE_URL = 'https://tudominio.com/api';

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
    getToken: () => localStorage.getItem('valorapay_token') || 'demo_token',

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
        const endpoint = userId ? `/balance.php?userId=${userId}` : '/balance.php';
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

    // --- Mock Data Generators based on api-endpoints.md ---
    getMockData(endpoint) {
        if (endpoint.includes('/balance.php')) {
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

        return mockResponse({ message: "Success (Mock)" });
    }
};
