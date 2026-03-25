// app.js - UI Interactions and Logic

document.addEventListener('DOMContentLoaded', () => {
    initImpersonationMode();
    checkAuth();
    initUI();
    initLogin();
    loadDashboardData();
    setupAdminSearch();
    updateSidebarUserInfo();
});

// --- AUTH & SECURITY ---
function checkAuth() {
    const path = window.location.pathname;
    const isIndexPage = path.endsWith('index.html') || path.endsWith('/') || path.endsWith('fifintech-mvp-main/') || path === '';

    const token = ApiService.getToken();

    if (!token && !isIndexPage) {
        window.location.replace('index.html');
    } else if (token && isIndexPage) {
        try {
            const userStr = localStorage.getItem('fintech_user');
            if (userStr) {
                const user = JSON.parse(userStr);
                window.location.replace((user.role === 'superadmin' || user.role === 'subadmin') ? 'Admin.html' : 'Profile.html');
            }
        } catch (e) {
            console.error('Error parseando user session', e);
        }
    }
}

window.logout = function () {
    localStorage.removeItem('fintech_token');
    localStorage.removeItem('fintech_user');
    window.location.replace('index.html');
};

function initLogin() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;
        const submitBtn = document.getElementById('loginSubmitBtn');

        let errorDiv = document.getElementById('loginError');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = 'loginError';
            errorDiv.className = 'text-sm text-red-600 bg-red-50 p-3 rounded-lg mt-2 hidden text-center font-medium';
            loginForm.insertBefore(errorDiv, submitBtn);
        }

        try {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-pulse">Ingresando...</span>';
            errorDiv.classList.add('hidden');

            const data = await ApiService.login(email, password);

            if (data.user && (data.user.role === 'superadmin' || data.user.role === 'subadmin')) {
                window.location.href = 'Admin.html';
            } else {
                window.location.href = 'Profile.html';
            }
        } catch (error) {
            errorDiv.innerText = error.message || 'Credenciales incorrectas';
            errorDiv.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.innerText = 'Ingresar';
        }
    });
}

// --- UI INIT ---
function initUI() {
    const investTabs = document.getElementById('investTabs');
    if (investTabs) {
        const buttons = investTabs.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => {
                    b.classList.remove('border-fintech-primary', 'text-fintech-primary');
                    b.classList.add('border-transparent', 'text-gray-500');
                });

                document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));

                btn.classList.remove('border-transparent', 'text-gray-500');
                btn.classList.add('border-fintech-primary', 'text-fintech-primary');
                document.getElementById(btn.dataset.target).classList.remove('hidden');
                document.getElementById(btn.dataset.target).classList.add('block');
            });
        });
    }

    window.toggleMisTarjetas = () => {
        const menuBtn = document.getElementById('menuMisTarjetas');
        const cardsPanel = document.getElementById('cardsPanel');
        if (menuBtn) menuBtn.classList.remove('hidden');
        if (cardsPanel) cardsPanel.classList.remove('hidden');
    };

    // --- ADMIN SPA NAVIGATION LÓGICA ---
    const navAdminDash = document.getElementById('navAdminDash');
    const navAdminUsers = document.getElementById('navAdminUsers');
    const navAdminSettings = document.getElementById('navAdminSettings');
    
    if (navAdminDash && navAdminUsers && navAdminSettings) {
        const adminDashView = document.getElementById('adminDashView');
        const adminUsersView = document.getElementById('adminUsersView');
        const adminSettingsView = document.getElementById('adminSettingsView');

        const setActiveNav = (activeEl) => {
            [navAdminDash, navAdminUsers, navAdminSettings].forEach(el => {
                el.classList.remove('bg-black', 'text-white');
                el.classList.add('text-fintech-textSec', 'hover:bg-gray-100');
            });
            activeEl.classList.remove('text-fintech-textSec', 'hover:bg-gray-100');
            activeEl.classList.add('bg-black', 'text-white');
        };

        const setActiveView = (activeView) => {
            [adminDashView, adminUsersView, adminSettingsView].forEach(el => el.classList.add('hidden'));
            activeView.classList.remove('hidden');

            // Inicialización forzada del Dashboard al entrar a la vista
            if (activeView === adminDashView) {
                if (typeof window.initAdminChart === 'function') window.initAdminChart();
                if (typeof window.loadRecentTransactions === 'function') window.loadRecentTransactions();
            }
        };

        navAdminDash.addEventListener('click', (e) => { e.preventDefault(); setActiveNav(navAdminDash); setActiveView(adminDashView); });
        navAdminUsers.addEventListener('click', (e) => { e.preventDefault(); setActiveNav(navAdminUsers); setActiveView(adminUsersView); });
        navAdminSettings.addEventListener('click', (e) => { e.preventDefault(); setActiveNav(navAdminSettings); setActiveView(adminSettingsView); });

        if (window.location.hash === '#users') {
            setActiveNav(navAdminUsers);
            setActiveView(adminUsersView);
        } else {
            // Render default Dashboard components (forces the chart initially)
            setActiveView(adminDashView);
        }
    }
}

// --- DATA LOADING (API CONSUMPTION) ---
async function loadDashboardData() {
    const formatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });

    // Perfil Usuario
    const totalBalanceEl = document.getElementById('uiTotalBalance');
    if (totalBalanceEl) {
        try {
            const data = await ApiService.getBalance();
            const balance = data.balance;

            totalBalanceEl.innerText = formatter.format(balance.totalBalance);
            document.getElementById('uiAnnualReturn').innerHTML = `${formatter.format(balance.annualReturn)} <span class="text-fintech-success text-sm ml-2 font-medium" id="uiReturnRate">${balance.annualReturnRate}%</span>`;
            document.getElementById('uiNetDeposits').innerText = formatter.format(balance.netDeposits);

            const riskEl = document.getElementById('uiRiskProfile');
            riskEl.innerText = balance.riskProfile === 'Moderate' ? 'Moderado' : balance.riskProfile;

            if (balance.riskProfile === 'High') riskEl.className = 'text-xl font-bold text-fintech-danger';
            else if (balance.riskProfile === 'Low') riskEl.className = 'text-xl font-bold text-fintech-success';
            else riskEl.className = 'text-xl font-bold text-orange-500';

            renderProjectionChart(balance.totalBalance, balance.annualReturnRate);

            if (typeof window.checkInvestmentAlert === 'function') {
                window.checkInvestmentAlert(balance.nextInvestmentDate);
            }

            try {
                const txData = await ApiService.getUserTransactions();
                const tbody = document.getElementById('transactionsTableBody');

                if (tbody && txData.transactions) {
                    tbody.innerHTML = '';
                    if (txData.transactions.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Aún no tienes movimientos</td></tr>';
                    } else {
                        txData.transactions.forEach(tx => {
                            const date = new Date(tx.date).toLocaleDateString('es-MX', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                            let sign = '', amountColor = 'text-black', typeStr = '';

                            if (tx.type === 'deposit' || tx.type === 'yield') {
                                sign = '+'; amountColor = 'text-fintech-success'; typeStr = 'Abono';
                            } else {
                                sign = '-'; amountColor = 'text-fintech-textMain'; typeStr = 'Cargo';
                            }

                            let statusBadge = '';
                            if (tx.status === 'completed') statusBadge = '<span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">Completado</span>';
                            else if (tx.status === 'pending') statusBadge = '<span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-semibold">Pendiente</span>';
                            else statusBadge = '<span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-semibold">Cancelado</span>';

                            const tr = document.createElement('tr');
                            tr.className = 'hover:bg-gray-50 transition';
                            tr.innerHTML = `
                                <td class="px-6 py-4 text-gray-500">${date}</td>
                                <td class="px-6 py-4 font-medium text-black">${tx.description}</td>
                                <td class="px-6 py-4 text-gray-500">${typeStr}</td>
                                <td class="px-6 py-4 font-bold ${amountColor}">${sign}${formatter.format(tx.amount)}</td>
                                <td class="px-6 py-4">${statusBadge}</td>
                            `;
                            tbody.appendChild(tr);

                            const allTbody = document.getElementById('allTransactionsTableBody');
                            if (allTbody && allTbody.children.length === 1 && allTbody.children[0].firstElementChild.colSpan === 5) {
                                allTbody.innerHTML = '';
                            }
                            if (allTbody) allTbody.appendChild(tr.cloneNode(true));
                        });
                    }
                }
            } catch (txErr) {
                console.warn("Fallo al cargar historial de transacciones:", txErr);
            }

        } catch (error) {
            showToast('Error cargando balance del servidor', 'danger');
            console.error(error);
        }
    }

    // Perfil Administrador
    const adminAUMEl = document.getElementById('adminTotalAUM');
    if (adminAUMEl) {
        try {
            const statsData = await ApiService.getAdminStats();

            if (adminAUMEl) adminAUMEl.innerText = formatter.format(statsData.totalAUM);

            const txEl = document.getElementById('adminTotalTransactions');
            if (txEl) txEl.innerText = statsData.totalTransactions.toLocaleString();

            const yieldsEl = document.getElementById('adminTotalYields');
            if (yieldsEl) yieldsEl.innerText = formatter.format(statsData.totalYields);

            const usersEl = document.getElementById('adminActiveUsers');
            if (usersEl) usersEl.innerText = statsData.activeUsers.toLocaleString();

            // Lógica final de Admin Stats
            const tableBody = document.getElementById('adminUsersTableBody');

            if (tableBody) {
                const usersData = await ApiService.getAdminUsers();
                tableBody.innerHTML = '';
                
                window.adminUsersDataMap = {}; // Global cache for direct actions

                if (!usersData || !usersData.users || usersData.users.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados</td></tr>';
                } else {
                    usersData.users.forEach(user => {
                        window.adminUsersDataMap[user.id] = user;
                        
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-blue-50/50 transition group'; // Removido cursor-pointer y onclick global

                        const initials = (user.firstName.charAt(0) + user.lastName.charAt(0)).toUpperCase();
                        const returnClass = user.annualReturnRate > 0 ? 'text-fintech-success' : 'text-gray-500';
                        const riskStr = user.riskProfile === 'Moderate' ? 'Moderado' : (user.riskProfile === 'High' ? 'Agresivo' : 'Conservador');

                        tr.innerHTML = `
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold mr-3">${initials}</div>
                                    <div>
                                        <p class="font-medium text-black transition">
                                            <span class="cursor-pointer text-blue-600 hover:text-blue-800 hover:underline font-bold transition-colors" onclick="triggerImpersonation(event, ${user.id}, '${user.firstName} ${user.lastName}')">${user.firstName} ${user.lastName}</span>
                                        </p>
                                        <p class="text-xs text-gray-500">${user.email}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium ${returnClass}">${user.annualReturnRate}%</td>
                            <td class="px-6 py-4 font-bold text-fintech-textMain">${formatter.format(user.totalBalance)}</td>
                            <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded text-xs">${riskStr}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2 transition-opacity">
                                    <button onclick="triggerImpersonation(event, ${user.id}, '${user.firstName} ${user.lastName}')" title="Ver Dashboard de Cliente" class="text-fintech-primary p-2 bg-gray-50 hover:bg-fintech-primary hover:text-white rounded border border-transparent hover:border-fintech-primary transition">
                                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button onclick="handleUserPanelClick(event, ${user.id}, 'profile')" title="Modificar Perfil Financiero" class="text-fintech-textSec p-2 bg-gray-50 hover:bg-gray-200 hover:text-black rounded border border-transparent transition">
                                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </button>
                                    <button onclick="handleUserPanelClick(event, ${user.id}, 'transaction')" title="Registrar Transacción" class="text-fintech-success p-2 bg-gray-50 hover:bg-green-600 hover:text-white rounded border border-transparent transition">
                                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(tr);
                    });
                }
            }

            // Inyectar y Renderizar Data Mock para Dashboard V3 (Chart y Recent)
            setTimeout(() => {
                if(typeof window.initAdminChart === 'function') window.initAdminChart();
                if(typeof window.loadRecentTransactions === 'function') window.loadRecentTransactions();
            }, 100);

        } catch (error) {
            console.error('Error al cargar métricas de administrador:', error);
            showToast('Error cargando datos del administrador', 'danger');
        }
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
        hiddenUserIdInput.value = '';
        if (query.length < 2) {
            resultsContainer.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(async () => {
            try {
                const data = await ApiService.searchUsers(query);
                resultsList.innerHTML = '';

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
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.classList.add('hidden');
        }
    });

    const registerForm = document.getElementById('formRegisterPayment');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = hiddenUserIdInput.value;
            if (!id) {
                showToast('Por favor selecciona un usuario del buscador predictivo', 'danger');
                return;
            }

            const type = document.getElementById('paymentType')?.value;
            const amount = document.getElementById('paymentAmount')?.value;
            const description = document.getElementById('paymentDescription')?.value;
            const submitBtn = registerForm.querySelector('button[type="submit"]');

            try {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="animate-pulse">Procesando...</span>';
                }

                await ApiService.registerTransaction({
                    userId: id,
                    type: type,
                    amount: parseFloat(amount),
                    description: description
                });

                showToast('Pago registrado exitosamente. El saldo fue recalculado.', 'success');
                document.getElementById('modalRegisterPayment').classList.add('hidden');
                registerForm.reset();
                hiddenUserIdInput.value = '';
                searchInput.value = '';

                loadDashboardData();
            } catch (error) {
                showToast(error.message || 'Error al registrar el pago', 'danger');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Aplicar Transacción';
                }
            }
        });
    }
}

// --- ADMIN SLIDE-OVER PANEL ---
window.openUserPanel = function(user) {
    document.getElementById('panelUserName').innerText = `${user.firstName} ${user.lastName}`;
    document.getElementById('panelUserEmail').innerText = user.email || 'Sin correo asociado';
    document.getElementById('panelUserId').value = user.id;
    
    const riskMap = { 'Low': 'Conservador', 'Moderate': 'Moderado', 'High': 'Agresivo' };
    document.getElementById('panelRiskProfile').value = riskMap[user.riskProfile] || 'Moderado';
    
    document.getElementById('panelAnnualReturnRate').value = user.annualReturnRate || 0;
    
    const transForm = document.getElementById('formDirectTransaction');
    if (transForm) transForm.reset();

    const slideOver = document.getElementById('userPanelSlideOver');
    const overlay = document.getElementById('userPanelOverlay');
    const content = document.getElementById('userPanelContent');
    
    if (slideOver) {
        slideOver.classList.remove('hidden');
        requestAnimationFrame(() => {
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
            content.classList.remove('translate-x-full');
            content.classList.add('translate-x-0');
        });
    }
};

window.handleUserPanelClick = function(event, userId, actionType) {
    if(event) event.stopPropagation();
    const user = window.adminUsersDataMap[userId];
    if (!user) return;
    openUserPanel(user);
    
    // Configuración RBAC para botón eliminar en Panel
    const userStr = localStorage.getItem('fintech_user');
    const roleInfo = userStr ? JSON.parse(userStr).role : null;
    const btnDeleteUser = document.getElementById('btnDeleteUser');
    if (btnDeleteUser) {
        if(roleInfo === 'subadmin') btnDeleteUser.style.display = 'none';
        else btnDeleteUser.style.display = 'block';
    }

    setTimeout(() => {
        const formProfile = document.getElementById('formUserProfile');
        const formTx = document.getElementById('formDirectTransaction');
        
        if (actionType === 'profile') {
            if (formTx && formTx.parentElement) formTx.parentElement.classList.add('hidden');
            if (formProfile && formProfile.parentElement) formProfile.parentElement.classList.remove('hidden');
        } else if (actionType === 'transaction') {
            if (formProfile && formProfile.parentElement) formProfile.parentElement.classList.add('hidden');
            if (formTx && formTx.parentElement) formTx.parentElement.classList.remove('hidden');
        }
    }, 50);
};

window.triggerImpersonation = function(event, userId, userName) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    localStorage.setItem('impersonatingId', userId);
    localStorage.setItem('impersonatingName', userName);
    window.location.href = 'Profile.html';
};

window.closeUserPanel = function() {
    const slideOver = document.getElementById('userPanelSlideOver');
    const overlay = document.getElementById('userPanelOverlay');
    const content = document.getElementById('userPanelContent');
    
    if (overlay && content) {
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        content.classList.remove('translate-x-0');
        content.classList.add('translate-x-full');
        
        setTimeout(() => {
            if (slideOver) slideOver.classList.add('hidden');
        }, 300);
    }
};

window.updateUserProfile = async function(event) {
    if (event) event.preventDefault();

    const form = document.getElementById('formUserProfile') || (event && event.target ? event.target.closest('form') : null);
    let submitBtn = null;
    let originalText = '';
    if (form) {
        submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button.bg-black');
        if (submitBtn) {
            originalText = submitBtn.innerText;
            submitBtn.innerText = 'Procesando...';
            submitBtn.classList.add('opacity-50', 'pointer-events-none');
        }
    }

    const userId = document.getElementById('panelUserId').value;
    const riskProfile = document.getElementById('panelRiskProfile').value;
    const annualRate = document.getElementById('panelAnnualReturnRate').value;
    const nextDateEl = document.getElementById('panelNextInvestmentDate'); // si no existe, regresa null
    const periodEl = document.getElementById('panelInvestmentPeriod');
    
    const payload = {
        userId,
        riskProfile,
        annualReturnRate: parseFloat(annualRate),
        nextInvestmentDate: nextDateEl ? nextDateEl.value : null,
        investmentPeriod: periodEl ? periodEl.value : null
    };

    try {
        await ApiService.updateAdminUser(payload);
        showToast('Guardado correctamente', 'success');
        closeUserPanel();
        loadDashboardData();
        if (typeof window.loadAdminUsers === 'function') {
            window.loadAdminUsers();
        }
    } catch(err) {
        console.error("Error en updateUserProfile:", err);
        showToast(err.message || 'Error al actualizar perfil de cliente.', 'danger');
    } finally {
        if (submitBtn) {
            submitBtn.innerText = originalText;
            submitBtn.classList.remove('opacity-50', 'pointer-events-none');
        }
    }
};
window.saveUserProfile = window.updateUserProfile; // Alias compatibility

window.registerUserTransaction = async function(event) {
    if (event) event.preventDefault();

    const form = document.getElementById('formDirectTransaction') || (event && event.target ? event.target.closest('form') : null);
    let submitBtn = null;
    let originalText = '';
    if (form) {
        submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button.bg-black');
        if (submitBtn) {
            originalText = submitBtn.innerText;
            submitBtn.innerText = 'Procesando...';
            submitBtn.classList.add('opacity-50', 'pointer-events-none');
        }
    }

    const userId = document.getElementById('panelUserId').value;
    const type = document.getElementById('transType').value;
    const amount = document.getElementById('transAmount').value;
    const authNum = document.getElementById('transAuthNumber').value;
    const customDateEl = document.getElementById('transCustomDate');

    if (!amount || amount <= 0) {
        showToast('Debes ingresar un monto válido', 'danger');
        if (submitBtn) {
            submitBtn.innerText = originalText;
            submitBtn.classList.remove('opacity-50', 'pointer-events-none');
        }
        return;
    }

    const payload = {
        userId,
        type,
        amount: parseFloat(amount),
        authNumber: authNum,
        customDate: customDateEl ? customDateEl.value : null,
        description: authNum ? `Ref: ${authNum}` : 'Transacción Directa de Panel'
    };

    try {
        await ApiService.registerTransaction(payload);
        showToast('Guardado correctamente', 'success');
        if(form) form.reset();
        closeUserPanel();
        
        loadDashboardData();
        if (typeof window.loadAdminUsers === 'function') {
            window.loadAdminUsers();
        }
        
        const allTxView = document.getElementById('adminAllTransactionsView');
        if (allTxView && !allTxView.classList.contains('hidden')) {
            loadGlobalTransactions();
        }
    } catch(err) {
        console.error("🔥 Error Crítico en registerUserTransaction:", err);
        showToast(err.message || 'Error al procesar la transacción.', 'danger');
    } finally {
        if (submitBtn) {
            submitBtn.innerText = originalText;
            submitBtn.classList.remove('opacity-50', 'pointer-events-none');
        }
    }
};
window.registerDirectTransaction = window.registerUserTransaction; // Alias compatibility

window.deleteSelectedUser = function() {
    document.getElementById('modalDeleteUser').classList.remove('hidden');
};

window.confirmDeleteUser = async function() {
    const userId = document.getElementById('panelUserId').value;
    if (!userId) return;

    // Aquí iría el Fetch DELETE cuando esté listo en PHP
    console.log("-> Eliminando usuario", userId);
    
    document.getElementById('modalDeleteUser').classList.add('hidden');
    closeUserPanel();
    
    showToast('Usuario eliminado con éxito', 'success');
    loadDashboardData();
};

window.loginAsUser = function() {
    const userId = document.getElementById('panelUserId').value;
    const userName = document.getElementById('panelUserName').innerText;
    
    if (userId) {
        localStorage.setItem('impersonatingId', userId);
        localStorage.setItem('impersonatingName', userName);
        showToast('Iniciando sesión segura en entorno cliente...', 'success');
        
        setTimeout(() => {
            window.location.href = 'Profile.html';
        }, 600);
    } else {
        showToast('Error identificando usuario.', 'danger');
    }
};

window.exitImpersonationMode = function() {
    localStorage.removeItem('impersonatingId');
    localStorage.removeItem('impersonatingName');
    document.body.style.paddingTop = '0'; // Clean layout padding
    window.location.href = 'Admin.html#users';
};

// --- INVESTMENT ALERTS ---
window.dismissInvestmentAlert = function(dateString) {
    sessionStorage.setItem('alertDismissedDate', dateString);
    const container = document.getElementById('investmentAlertContainer');
    if (container) container.classList.add('hidden');
};

window.checkInvestmentAlert = function(nextDateString) {
    const container = document.getElementById('investmentAlertContainer');
    if (!container || !nextDateString) return;
    
    const dismissedDate = sessionStorage.getItem('alertDismissedDate');
    if (dismissedDate === nextDateString) {
        return; // Ya se descartó en esta sesión
    }

    const nextDate = new Date(nextDateString);
    // Ajustar a medianoche local
    nextDate.setDate(nextDate.getDate() + 1); // Fix timezone parsing if assuming UTC string originally without time
    nextDate.setHours(0,0,0,0);
    
    const today = new Date();
    today.setHours(0,0,0,0);

    const diffTime = nextDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    let bgColor = '';
    let icon = '';
    let title = '';
    let message = '';

    if (diffDays < 0) {
        // Vencida (Rojo Oscuro)
        bgColor = 'bg-red-900 text-white';
        title = 'Fecha de Inversión Vencida';
        message = 'Tu fecha programada para inversión ha pasado. Por favor regulariza tu operación.';
        icon = `<svg class="w-6 h-6 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
    } else if (diffDays === 0) {
        // Hoy (Rojo)
        bgColor = 'bg-red-600 text-white';
        title = 'Inversión Programada para Hoy';
        message = 'Es el día de tu corte de inversión. Realiza tu operación programada.';
        icon = `<svg class="w-6 h-6 text-red-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
    } else if (diffDays > 0 && diffDays <= 7) {
        // 1-7 días (Naranja)
        bgColor = 'bg-orange-500 text-white';
        title = 'Próxima Inversión Cercana';
        message = `Tu fecha de inversión es en ${diffDays} día${diffDays > 1 ? 's' : ''}. Ve preparando tus fondos.`;
        icon = `<svg class="w-6 h-6 text-orange-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
    } else {
        // Más de 7 días, no mostramos nada
        container.innerHTML = '';
        return;
    }

    container.innerHTML = `
        <div class="${bgColor} rounded-xl p-4 flex items-start gap-4 shadow-sm relative pr-10">
            <div class="absolute top-2 right-2 cursor-pointer opacity-70 hover:opacity-100 transition-opacity" onclick="dismissInvestmentAlert('${nextDateString}')">
                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div class="shrink-0 mt-0.5">${icon}</div>
            <div>
                <h4 class="font-bold text-base mb-0.5">${title}</h4>
                <p class="text-sm opacity-90">${message}</p>
                <button onclick="dismissInvestmentAlert('${nextDateString}')" class="mt-3 px-4 py-1.5 bg-black/20 hover:bg-black/30 rounded text-sm font-bold transition-colors">Entendido</button>
            </div>
        </div>
    `;
    container.classList.remove('hidden');
};

// --- USER CREATION ---
window.registerNewUser = async function(event) {
    if (event) event.preventDefault();
    
    const form = document.getElementById('formCreateUser');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerText;
    
    submitBtn.innerText = 'Creando...';
    submitBtn.classList.add('opacity-50', 'pointer-events-none');

    const payload = {
        firstName: document.getElementById('createFirstName').value.trim(),
        lastName: document.getElementById('createLastName').value.trim(),
        email: document.getElementById('createEmail').value.trim(),
        phone: document.getElementById('createPhone').value.trim(),
        password: document.getElementById('createPassword').value,
        role: document.getElementById('createRole').value
    };

    try {
        const result = await ApiService.createUser(payload);
        showToast('Usuario creado con éxito', 'success');
        
        form.reset();
        document.getElementById('modalCreateUser').classList.add('hidden');
        
        // Recargar el framework principal y la tabla de usuarios
        loadDashboardData();
    } catch(error) {
        showToast(error.message || 'Error al crear el usuario', 'danger');
    } finally {
        submitBtn.innerText = originalText;
        submitBtn.classList.remove('opacity-50', 'pointer-events-none');
    }
};

// --- UTILS (Toasts) ---
window.showToast = (message, type = 'success') => {
    const isSuccess = type === 'success';
    const bgColor = isSuccess ? 'bg-green-600' : 'bg-red-600';
    const icon = isSuccess 
        ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`
        : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;

    const toastArea = document.createElement('div');
    toastArea.className = `fixed bottom-5 right-5 px-6 py-3 rounded-lg shadow-2xl font-bold text-white z-[9999] flex items-center gap-2 transform transition-all duration-300 translate-y-10 opacity-0 ${bgColor}`;
    toastArea.innerHTML = `${icon} <span>${message}</span>`;
    
    document.body.appendChild(toastArea);

    setTimeout(() => {
        toastArea.classList.remove('translate-y-10', 'opacity-0');
        toastArea.classList.add('translate-y-0', 'opacity-100');
    }, 10);

    setTimeout(() => {
        toastArea.classList.remove('translate-y-0', 'opacity-100');
        toastArea.classList.add('translate-y-10', 'opacity-0');
        setTimeout(() => {
            if (document.body.contains(toastArea)) {
                document.body.removeChild(toastArea);
            }
        }, 300);
    }, 3500);
};

// --- GAMIFICACIÓN: GRÁFICO DE PROYECCIÓN COMPUESTA ---
let projectionChartInstance = null;
window.renderProjectionChart = function (currentBalance, annualRate) {
    const canvas = document.getElementById('projectionChart');
    if (!canvas) return;

    if (typeof Chart === 'undefined') {
        console.warn("Chart.js no está definido. Asegúrate de incluirlo en Profile.html.");
        return;
    }

    const ctx = canvas.getContext('2d');
    const labels = [];
    const dataPoints = [];
    let accumulated = parseFloat(currentBalance) || 0;

    const effectiveRate = parseFloat(annualRate) > 0 ? parseFloat(annualRate) : 10.5;
    const monthlyRate = (effectiveRate / 100) / 12;

    const formatter = new Intl.DateTimeFormat('es-MX', { month: 'short' });
    const today = new Date();

    for (let i = 0; i < 12; i++) {
        const d = new Date(today.getFullYear(), today.getMonth() + i, 1);
        labels.push(formatter.format(d).toUpperCase());
        dataPoints.push(parseFloat(accumulated.toFixed(2)));
        accumulated += (accumulated * monthlyRate);
    }

    if (projectionChartInstance) {
        projectionChartInstance.destroy();
    }

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(130, 10, 209, 0.4)');
    gradient.addColorStop(1, 'rgba(130, 10, 209, 0.0)');

    projectionChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Proyección (MXN)',
                data: dataPoints,
                borderColor: '#820AD1',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#820AD1',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1A1A1A',
                    titleFont: { family: 'Inter', size: 13 },
                    bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function (context) {
                            return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: { display: false, beginAtZero: false },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { font: { family: 'Inter', size: 11 }, color: '#6B7280' }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
};

// --- UPDATE SIDEBAR USER INFO ---
function updateSidebarUserInfo() {
    const token = localStorage.getItem('fintech_token');
    const userStr = localStorage.getItem('fintech_user');
    const impersonatingName = localStorage.getItem('impersonatingName');

    if (userStr && token) {
        try {
            const user = JSON.parse(userStr);

            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            const jwtData = JSON.parse(jsonPayload);
            // Prioridad: 1. Modo Suplantación, 2. JWT Name, 3. Default
            const fullName = impersonatingName || jwtData.name || 'Inversionista';

            const nameEl = document.getElementById('sidebarUserName');
            const emailEl = document.getElementById('sidebarUserEmail');
            const initialsEl = document.getElementById('sidebarUserInitials');
            const greetingEl = document.getElementById('userGreeting'); // Por si existe un saludo

            if (nameEl) nameEl.innerText = fullName;
            if (greetingEl) greetingEl.innerText = `Hola, ${fullName}`;
            if (emailEl) emailEl.innerText = user.email || 'correo@oculto.com';

            if (initialsEl) {
                const nameParts = fullName.split(' ');
                const firstInitial = nameParts[0] ? nameParts[0].charAt(0).toUpperCase() : '';
                const lastInitial = nameParts.length > 1 ? nameParts[nameParts.length - 1].charAt(0).toUpperCase() : '';
                initialsEl.innerText = (firstInitial + lastInitial) || 'UX';
            }

            // Llenar el formulario de Settings
            const setFirstName = document.getElementById('settingFirstName');
            const setLastName = document.getElementById('settingLastName');
            const setEmail = document.getElementById('settingEmail');
            const setPhone = document.getElementById('settingPhone');
            const formSettings = document.getElementById('formSettings');
            const submitSettingsBtn = formSettings ? formSettings.querySelector('button[type="submit"]') : null;

            const impersonatingId = localStorage.getItem('impersonatingId');
            
            if (impersonatingId && typeof ApiService !== 'undefined') {
                // SUPLANTACIÓN: Pedir datos del cliente desde API y bloquear edición
                ApiService.request(`/admin/get_user.php?userId=${impersonatingId}`).then(res => {
                    if (res && res.data) {
                        
                        // FIX: Ocultar correo del admin y blindar el del cliente interceptado
                        const sidebarEmailEl = document.getElementById('sidebarUserEmail');
                        if (sidebarEmailEl) sidebarEmailEl.innerText = res.data.email || 'correo@oculto.com';

                        if (setFirstName) { setFirstName.value = res.data.firstName || ''; setFirstName.readOnly = true; setFirstName.classList.add('bg-gray-50', 'text-gray-500'); }
                        if (setLastName) { setLastName.value = res.data.lastName || ''; setLastName.readOnly = true; setLastName.classList.add('bg-gray-50', 'text-gray-500'); }
                        if (setEmail) { setEmail.value = res.data.email || ''; setEmail.readOnly = true; setEmail.classList.add('bg-gray-50', 'text-gray-500'); }
                        if (setPhone) { setPhone.value = res.data.phone || ''; setPhone.readOnly = true; setPhone.classList.add('bg-gray-50', 'text-gray-500'); }
                        
                        if (submitSettingsBtn) {
                            submitSettingsBtn.classList.add('hidden', 'opacity-0', 'pointer-events-none');
                        }
                    }
                }).catch(err => console.error("🔥 Error obteniendo perfil de cliente suplantado:", err));
            } else {
                // NORMAL: Cargar datos locales de localStorage
                if (setPhone && user.phone) setPhone.value = user.phone;
                const nameParts = fullName.split(' ');
                if (setFirstName) setFirstName.value = nameParts[0] || '';
                if (setLastName) setLastName.value = nameParts.slice(1).join(' ') || '';
                if (setEmail) setEmail.value = user.email || jwtData.email || '';
            }

            // --- LÓGICA RBAC (Ocultar funciones superadmin) ---
            if (user.role === 'subadmin') {
                document.querySelectorAll('.admin-only-feature').forEach(el => {
                    el.classList.add('hidden');
                });
            }
        } catch (e) {
            console.error('Error al decodificar el JWT o cargar datos', e);
        }
    }
}

// --- SPA NAVIGATION ---
window.switchView = function (viewName) {
    const dashboardView = document.getElementById('dashboardView');
    const allTxView = document.getElementById('allTransactionsView');
    const settingsView = document.getElementById('settingsView');
    const refundsView = document.getElementById('refundsView'); // <-- NUEVO

    const navDash = document.getElementById('navDashboard');
    const navTx = document.getElementById('navTransactions');
    const navSet = document.getElementById('navSettings');
    const navRefunds = document.getElementById('navRefunds'); // <-- NUEVO

    const activeClass = ['bg-purple-50', 'text-fintech-primary', 'font-bold'];
    const inactiveClass = ['text-fintech-textSec', 'hover:bg-gray-100', 'font-medium'];

    // Ocultar todos
    [dashboardView, allTxView, settingsView, refundsView].forEach(el => {
        if (el) el.classList.add('hidden');
    });

    // Desactivar todos los links
    [navDash, navTx, navSet, navRefunds].forEach(el => {
        if (el) {
            el.classList.remove(...activeClass);
            el.classList.add(...inactiveClass);
        }
    });

    // Activar el requerido
    if (viewName === 'dashboard') {
        if (dashboardView) dashboardView.classList.remove('hidden');
        if (navDash) { navDash.classList.remove(...inactiveClass); navDash.classList.add(...activeClass); }
    } else if (viewName === 'transactions') {
        if (allTxView) allTxView.classList.remove('hidden');
        if (navTx) { navTx.classList.remove(...inactiveClass); navTx.classList.add(...activeClass); }
    } else if (viewName === 'settings') {
        if (settingsView) settingsView.classList.remove('hidden');
        if (navSet) { navSet.classList.remove(...inactiveClass); navSet.classList.add(...activeClass); }
    } else if (viewName === 'refunds') {
        if (refundsView) refundsView.classList.remove('hidden');
        if (navRefunds) { navRefunds.classList.remove(...inactiveClass); navRefunds.classList.add(...activeClass); }
    }
};

// --- PROFILE UPDATE ACTIONS ---
window.handleProfileUpdate = async function (event) {
    event.preventDefault();
    const form = event.target;
    const btnSubmit = form.querySelector('button[type="submit"]');
    const originalText = btnSubmit.innerText;

    try {
        btnSubmit.disabled = true;
        btnSubmit.innerText = 'Guardando...';

        const formData = new FormData(form);

        const phoneVal = formData.get('phone');
        if (phoneVal) {
            const cleanPhone = phoneVal.replace(/\s+/g, '');
            if (!/^\+?[0-9]{10,12}$/.test(cleanPhone)) {
                throw new Error("El teléfono debe contener entre 10 y 12 números.");
            }
        }

        await ApiService.updateProfile(formData);
        showToast('Perfil actualizado con éxito', 'success');

        if (phoneVal) {
            const userStr = localStorage.getItem('fintech_user');
            if (userStr) {
                const userObj = JSON.parse(userStr);
                userObj.phone = phoneVal;
                localStorage.setItem('fintech_user', JSON.stringify(userObj));
            }
        }
    } catch (error) {
        showToast(error.message, 'danger');
    } finally {
        btnSubmit.disabled = false;
        btnSubmit.innerText = originalText;
    }
};

// --- WITHDRAWAL ACTIONS (3 ACTOS) ---
window.handleWithdrawalSubmit = function (event) {
    event.preventDefault();
    const form = event.target;
    const clabe = form.withdrawalClabe.value;

    const stateForm = document.getElementById('withdrawalStateForm');
    const stateProcessing = document.getElementById('withdrawalStateProcessing');
    const stateResult = document.getElementById('withdrawalStateResult');
    const processingText = document.getElementById('processingText');
    const closeBtn = document.getElementById('closeWithdrawalBtn');

    stateForm.classList.add('hidden');
    stateForm.classList.remove('block');
    stateProcessing.classList.remove('hidden');
    stateProcessing.classList.add('block');
    closeBtn.classList.add('hidden');

    processingText.innerText = `Cifrando conexión para CLABE terminada en ${clabe.slice(-4)}...`;

    const errorMessages = [
        "Error de conexión con el banco receptor (Timeout). Tu saldo está intacto. Por favor, reintenta más tarde.",
        "El sistema interbancario SPEI se encuentra en ventana de mantenimiento. Intenta de nuevo en un par de horas.",
        "Por normatividad, los retiros hacia cuentas CLABE de reciente registro requieren validación manual. Contacta a soporte.",
        "Horario fuera de operación. Los retiros interbancarios se procesan exclusivamente en días hábiles de 9:00 AM a 5:00 PM."
    ];

    const delay = Math.floor(Math.random() * (4500 - 3500 + 1)) + 3500;

    setTimeout(() => {
        stateProcessing.classList.add('hidden');
        stateProcessing.classList.remove('block');

        const randomError = errorMessages[Math.floor(Math.random() * errorMessages.length)];
        document.getElementById('resultText').innerText = randomError;

        stateResult.classList.remove('hidden');
        stateResult.classList.add('block');

        form.reset();
    }, delay);
};

window.closeWithdrawalModal = function () {
    const modal = document.getElementById('modalWithdrawal');

    if (document.getElementById('withdrawalStateProcessing').classList.contains('block')) {
        return;
    }


    modal.classList.add('hidden');

    setTimeout(() => {
        document.getElementById('withdrawalStateForm').classList.remove('hidden');
        document.getElementById('withdrawalStateForm').classList.add('block');

        document.getElementById('withdrawalStateProcessing').classList.add('hidden');
        document.getElementById('withdrawalStateProcessing').classList.remove('block');

        document.getElementById('withdrawalStateResult').classList.add('hidden');
        document.getElementById('withdrawalStateResult').classList.remove('block');

        document.getElementById('closeWithdrawalBtn').classList.remove('hidden');
    }, 300);
};

// --- FUNCIONALIDADES ASALTO 3 ---

function initImpersonationMode() {
    const impersonatingId = localStorage.getItem('impersonatingId');
    const impersonatingName = localStorage.getItem('impersonatingName') || 'Cliente';
    const userStr = localStorage.getItem('fintech_user');
    
    if (impersonatingId && userStr) {
        try {
            const user = JSON.parse(userStr);
            if (user.role === 'superadmin' || user.role === 'subadmin') {
                
                // Remover banner estático si existiera
                const oldBanner = document.getElementById('impersonationBannerProfile');
                if (oldBanner) oldBanner.remove();

                // Inyección Dinámica del Banner Solicitado
                const bannerHtml = `
                    <div id="dynamicImpersonationBanner" class="fixed top-0 left-0 w-full bg-red-600 text-white z-[9999] p-3 flex justify-between items-center shadow-lg h-14">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center h-2.5 w-2.5 rounded-full bg-white animate-pulse"></span>
                            <span class="font-bold text-sm md:text-base">MODO VISTA DE USUARIO: Estás viendo el panel de ${impersonatingName}</span>
                        </div>
                        <button onclick="exitImpersonationMode()" class="bg-white text-red-600 px-4 py-1.5 rounded font-bold hover:bg-gray-100 transition shadow border border-red-200 text-sm">
                            Cerrar Vista y Volver a Admin
                        </button>
                    </div>
                `;
                document.body.insertAdjacentHTML('afterbegin', bannerHtml);
                document.body.style.paddingTop = '3.5rem'; // Fix overlap
                
                const sidebarNameEl = document.getElementById('sidebarUserName');
                const greetingEl = document.getElementById('userGreeting');
                
                if (sidebarNameEl) sidebarNameEl.innerText = impersonatingName;
                if (greetingEl) greetingEl.innerText = `Hola, ${impersonatingName}`;
                
                showToast('Modo Suplantación Activo', 'success');
            }
        } catch(e) {
            console.error("Error validando impersonation:", e);
        }
    }
}

let adminMainChartInstance = null;
window.initAdminChart = async function() {
    console.log("🔥 INICIANDO RENDERIZADO DE GRÁFICA");
    const canvas = document.getElementById('adminMainChart');
    if (!canvas) return;

    if (typeof Chart === 'undefined') {
        setTimeout(window.initAdminChart, 500);
        return;
    }

    const ctx = canvas.getContext('2d');
    
    try {
        // Fetch Real API Data
        const txResp = await ApiService.getAdminTransactions();
        console.log('DATA API DASH:', txResp);
        
        const allTxs = txResp.transactions || [];
        
        if (allTxs.length === 0) {
            // Mostrar Empty State Chart
            const parent = canvas.parentElement;
            if (parent) {
                const emptyHTML = `<div class="absolute inset-0 flex items-center justify-center text-gray-400 font-medium text-sm">No hay datos suficientes para graficar</div>`;
                parent.insertAdjacentHTML('afterbegin', emptyHTML);
            }
        }
        
        // Agrupar AUM histórico + Conteo (últimos 6 meses)
        const labels = [];
        const aumData = [];
        const txCounts = [];
        const monthsMap = {};
        
        for (let i = 5; i >= 0; i--) {
            const d = new Date();
            d.setMonth(d.getMonth() - i);
            const key = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0');
            const shortName = d.toLocaleDateString('es-MX', { month: 'short' });
            monthsMap[key] = { label: shortName.toUpperCase(), aum: 0, count: 0 };
        }
        
        let runningAUM = 0;
        const sixMonthsAgo = new Date();
        sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 5);
        sixMonthsAgo.setDate(1);
        
        [...allTxs].reverse().forEach(tx => {
            const txDate = new Date(tx.date);
            let val = parseFloat(tx.amount) || 0;
            if (tx.type === 'withdrawal') val = -val;
            
            if (tx.status === 'completed') {
                if (txDate < sixMonthsAgo) {
                    runningAUM += val;
                } else {
                    const key = txDate.getFullYear() + '-' + String(txDate.getMonth() + 1).padStart(2, '0');
                    if (monthsMap[key]) {
                        monthsMap[key].aum += val;
                        monthsMap[key].count += 1;
                    }
                }
            }
        });
        
        Object.keys(monthsMap).forEach(key => {
            runningAUM += monthsMap[key].aum;
            labels.push(monthsMap[key].label);
            aumData.push(runningAUM);
            txCounts.push(monthsMap[key].count);
        });

        if (adminMainChartInstance) {
            adminMainChartInstance.destroy();
        }

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(130, 10, 209, 0.5)');
        gradient.addColorStop(1, 'rgba(130, 10, 209, 0.0)');

        adminMainChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'AUM (MXN)',
                        data: aumData,
                        borderColor: '#820AD1',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Transacciones',
                        data: txCounts,
                        borderColor: '#10B981',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointBackgroundColor: '#10B981',
                        pointRadius: 4,
                        fill: false,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', labels: { font: { family: 'Inter', size: 12 } } },
                    tooltip: {
                        backgroundColor: '#1A1A1A',
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 14 },
                        callbacks: {
                            label: function(context) {
                                if(context.dataset.yAxisID === 'y') {
                                    return context.dataset.label + ': ' + new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(context.parsed.y);
                                }
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        type: 'linear', display: true, position: 'left',
                        grid: { color: '#f3f4f6' },
                        ticks: { callback: function(value) { return '$' + (value / 1000) + 'k'; } }
                    },
                    y1: { type: 'linear', display: true, position: 'right', grid: { drawOnChartArea: false } }
                }
            }
        });
    } catch (e) {
        console.warn("Fallo cargando Admin Chart en Real API", e);
    }
};

window.loadRecentTransactions = async function() {
    const tbody = document.getElementById('adminRecentTransactionsBody');
    if (!tbody) return;

    try {
        const txResp = await ApiService.getAdminTransactions();
        console.log('DATA API DASH (Recents):', txResp);
        
        const dummyTxs = (txResp.transactions || []).slice(0, 10);

        const formatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
        tbody.innerHTML = '';

        if(dummyTxs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-6 text-gray-500 font-medium bg-gray-50/50">No hay transacciones recientes</td></tr>';
            return;
        }

        dummyTxs.forEach(tx => {
            let typeStr = '', amountColor = '';
            if (tx.type === 'deposit') { typeStr = 'Depósito'; amountColor = 'text-green-600'; }
            else if (tx.type === 'withdrawal') { typeStr = 'Retiro'; amountColor = 'text-red-500'; }
            else { typeStr = 'Rendimiento'; amountColor = 'text-fintech-success'; }

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 transition border-b border-gray-100 last:border-0';
            const dateStr = new Date(tx.date).toLocaleDateString('es-MX', { month:'short', day:'numeric', hour:'2-digit', minute:'2-digit'});
            tr.innerHTML = `
                <td class="px-4 py-3 font-bold text-black">${tx.user || tx.userId}</td>
                <td class="px-4 py-3 text-gray-500">${dateStr}</td>
                <td class="px-4 py-3 text-gray-600">${typeStr}</td>
                <td class="px-4 py-3 font-bold text-right ${amountColor}">${formatter.format(tx.amount)}</td>
            `;
            tbody.appendChild(tr);
        });
    } catch(e) {
        console.error("Fallo iterador recientes", e);
    }
};

window.showAdminAllTransactions = function() {
    const dashView = document.getElementById('adminDashView');
    const allTxView = document.getElementById('adminAllTransactionsView');
    if (dashView && allTxView) {
        dashView.classList.add('hidden');
        allTxView.classList.remove('hidden');
        loadGlobalTransactions();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

window.showAdminDashboard = function() {
    const dashView = document.getElementById('adminDashView');
    const allTxView = document.getElementById('adminAllTransactionsView');
    if (dashView && allTxView) {
        allTxView.classList.add('hidden');
        dashView.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

window.loadGlobalTransactions = async function() {
    const tbody = document.getElementById('adminGlobalTransactionsBody');
    if (!tbody) return;

    try {
        const txResp = await ApiService.getAdminTransactions();
        const dummyGlobalTxs = txResp.transactions || [];

        const formatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
        tbody.innerHTML = '';

        if(dummyGlobalTxs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-6 text-gray-500">No hay historial de movimientos...</td></tr>';
            return;
        }

        dummyGlobalTxs.forEach(tx => {
            let typeStr = '', amountColor = '';
            if (tx.type === 'deposit') { typeStr = 'Depósito'; amountColor = 'text-green-600'; }
            else if (tx.type === 'withdrawal') { typeStr = 'Retiro'; amountColor = 'text-red-500'; }
            else { typeStr = 'Rendimiento'; amountColor = 'text-fintech-success'; }

            let statusBadge = '';
            if (tx.status === 'completed') statusBadge = '<span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">Completado</span>';
            else if (tx.status === 'pending') statusBadge = '<span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-semibold">Pendiente</span>';
            else statusBadge = '<span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-semibold">Cancelado</span>';

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-blue-50/50 transition border-b border-gray-100 last:border-0';
            const dateStr = new Date(tx.date).toLocaleDateString('es-MX', { month:'short', day:'numeric', year:'numeric', hour:'2-digit', minute:'2-digit'});
            tr.innerHTML = `
                <td class="px-6 py-4 text-gray-500 text-xs font-mono">${tx.id || 'N/A'}</td>
                <td class="px-6 py-4 font-bold text-black">${tx.user || tx.userId}</td>
                <td class="px-6 py-4 text-gray-500">${dateStr}</td>
                <td class="px-6 py-4 text-gray-600">${typeStr}</td>
                <td class="px-6 py-4 font-bold text-right ${amountColor}">${formatter.format(tx.amount)}</td>
                <td class="px-6 py-4 text-center">${statusBadge}</td>
            `;
            tbody.appendChild(tr);
        });
    } catch(err) {
        showToast('Error cargando historial de servidor', 'danger');
    }
};