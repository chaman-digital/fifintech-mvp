// app.js - UI Interactions and Logic

document.addEventListener('DOMContentLoaded', () => {
    initUI();
    loadDashboardData();
    setupAdminSearch();
});

// --- UI INIT ---
function initUI() {
    // 1. Invertir Tabs Switcher
    const investTabs = document.getElementById('investTabs');
    if (investTabs) {
        const buttons = investTabs.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Reset states
                buttons.forEach(b => {
                    b.classList.remove('border-fintech-primary', 'text-fintech-primary');
                    b.classList.add('border-transparent', 'text-gray-500');
                });

                document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));

                // Set active
                btn.classList.remove('border-transparent', 'text-gray-500');
                btn.classList.add('border-fintech-primary', 'text-fintech-primary');
                document.getElementById(btn.dataset.target).classList.remove('hidden');
                document.getElementById(btn.dataset.target).classList.add('block');
            });
        });
    }

    // 2. Secret 'Mis Tarjetas' Menu Trigger (Demostración de ocultamiento y apertura)
    // El requerimiento dice: "botón 'Mis Tarjetas'... añade la clase hidden al botón en el menú lateral."
    // Para demostrarlo, podemos invocarlo vía consola o un atajo secreto si hiciera falta. 
    // Por defecto está "hidden" en el HTML. Proporcionamos la función para abrirlo:
    window.toggleMisTarjetas = () => {
        const menuBtn = document.getElementById('menuMisTarjetas');
        const cardsPanel = document.getElementById('cardsPanel');
        if (menuBtn) menuBtn.classList.remove('hidden');
        if (cardsPanel) cardsPanel.classList.remove('hidden');
    };
}

// --- DATA LOADING (API CONSUMPTION) ---
async function loadDashboardData() {
    // Solo si estamos en Profile.html
    const totalBalanceEl = document.getElementById('uiTotalBalance');
    if (!totalBalanceEl) return;

    try {
        const data = await ApiService.getBalance();
        const balance = data.balance;

        // Formato Moneda
        const formatter = new Intl.NumberFormat('es-MX', {
            style: 'currency',
            currency: 'MXN',
        });

        // Actualizar UI
        totalBalanceEl.innerText = formatter.format(balance.totalBalance);
        document.getElementById('uiAnnualReturn').innerHTML = `${formatter.format(balance.annualReturn)} <span class="text-fintech-success text-sm ml-2 font-medium" id="uiReturnRate">${balance.annualReturnRate}%</span>`;
        document.getElementById('uiNetDeposits').innerText = formatter.format(balance.netDeposits);

        const riskEl = document.getElementById('uiRiskProfile');
        riskEl.innerText = balance.riskProfile === 'Moderate' ? 'Moderado' : balance.riskProfile;

        // Estilos dinámicos para riesgo
        if (balance.riskProfile === 'High') riskEl.className = 'text-xl font-bold text-fintech-danger';
        else if (balance.riskProfile === 'Low') riskEl.className = 'text-xl font-bold text-fintech-success';
        else riskEl.className = 'text-xl font-bold text-orange-500';

    } catch (error) {
        showToast('Error cargando balance del servidor', 'danger');
        console.error(error);
    }
}

// --- ADMIN PREDICTIVE SEARCH ---
function setupAdminSearch() {
    const searchInput = document.getElementById('predictiveSearchInput');
    const resultsContainer = document.getElementById('predictiveResults');
    const resultsList = document.getElementById('predictiveResultsList');
    const hiddenUserIdInput = document.getElementById('selectedUserId');

    if (!searchInput) return;

    let debounceTimer;

    searchInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        const query = e.target.value.trim();

        if (query.length < 2) {
            resultsContainer.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(async () => {
            try {
                // Consumo API Endpoint /admin/search_users.php
                const data = await ApiService.searchUsers(query);

                resultsList.innerHTML = ''; // Limpiar lista

                if (data.users.length === 0) {
                    resultsList.innerHTML = '<li class="px-4 py-3 text-gray-500">No se encontraron usuarios</li>';
                } else {
                    data.users.forEach(user => {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer flex justify-between items-center';
                        li.innerHTML = `
                            <div>
                                <p class="font-medium text-black">${user.firstName} ${user.lastName}</p>
                                <p class="text-xs text-gray-500">${user.email}</p>
                            </div>
                            <span class="text-xs text-fintech-primary bg-purple-50 px-2 py-1 rounded">ID: ${user.id}</span>
                        `;

                        li.addEventListener('click', () => {
                            searchInput.value = `${user.firstName} ${user.lastName}`;
                            hiddenUserIdInput.value = user.id;
                            resultsContainer.classList.add('hidden');
                        });

                        resultsList.appendChild(li);
                    });
                }

                resultsContainer.classList.remove('hidden');

            } catch (error) {
                console.error("Error buscando usuarios", error);
            }
        }, 300); // 300ms debounce
    });

    // Ocultar al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.classList.add('hidden');
        }
    });

    // Form Submission (Registrar Pago)
    const registerForm = document.getElementById('formRegisterPayment');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const id = hiddenUserIdInput.value;
            if (!id) {
                showToast('Por favor selecciona un usuario del buscador predictivo', 'danger');
                return;
            }
            // Aquí iría el envío real al backend
            showToast('Transacción registrada exitosamente. El saldo del usuario ha sido recalculado.', 'success');
            document.getElementById('modalRegisterPayment').classList.add('hidden');
            registerForm.reset();
        });
    }
}

// --- MODO SUPLANTACIÓN (IMPERSONATION) ---
window.simulateImpersonation = (userId, userName) => {
    const mainContent = document.getElementById('mainContent');
    const impBanner = document.getElementById('impersonationBanner');
    const impContainer = document.getElementById('impersonationContainer');
    const dashView = document.getElementById('dashboardView');
    const iframe = document.getElementById('impersonationFrame');

    if (!iframe) return;

    // 1. Update UI state for impersonation
    document.getElementById('impersonationUserName').innerText = `Suplantando a: ${userName} (ID: ${userId})`;
    impBanner.classList.remove('hidden');

    // Hide Admin Dashboard, Show Iframe Container
    dashView.classList.add('hidden');
    impContainer.classList.remove('hidden');

    // 2. Load the Profile.html inside the iframe 
    // (In a real app, you'd pass the userId via token or session, here we simulate by loading the pure HTML)
    iframe.src = "Profile.html";

    // "Deshabilita acciones financieras" -> El overlay (#impersonationShieldOverlay) físico del HTML bloquea los clicks dentro del iframe
    // para evitar que el admin haga transacciones. Es una solución frontend para "Read Only". Backend debe validar también.
    showToast(`Modo Vista de Usuario activado para ${userName}`, 'success');
};

window.exitImpersonation = () => {
    const impBanner = document.getElementById('impersonationBanner');
    const impContainer = document.getElementById('impersonationContainer');
    const dashView = document.getElementById('dashboardView');
    const iframe = document.getElementById('impersonationFrame');

    impBanner.classList.add('hidden');
    impContainer.classList.add('hidden');
    dashView.classList.remove('hidden');
    iframe.src = "";

    showToast('Modo Vista de Usuario cerrado.', 'success');
};


// --- UTILS (Toasts) ---
window.showToast = (message, type = 'success') => {
    // Si la función Retirar se invoca, el "Mantenimiento temporal" se lanza por aquí
    const container = document.getElementById('toastContainer');
    if (!container) return; // Add <div id="toastContainer" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div> to HTML

    const toast = document.createElement('div');

    // Tailwin classes base
    let classes = 'min-w-[250px] px-4 py-3 rounded-lg shadow-xl text-sm font-medium transition-all duration-300 transform translate-y-10 opacity-0 flex items-center justify-between gap-3 ';
    let icon = '';

    if (type === 'success') {
        classes += 'bg-green-100 text-green-800 border border-green-200';
        icon = `<svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
    } else if (type === 'danger') {
        classes += 'bg-red-100 text-red-800 border border-red-200';
        icon = `<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
    }

    toast.className = classes;
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            ${icon}
            <span>${message}</span>
        </div>
        <button class="text-gray-500 hover:text-black focus:outline-none" onclick="this.parentElement.remove()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;

    container.appendChild(toast);

    // Fade In
    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-10', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    });

    // Auto remove
    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-10', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
};
