// Carrito (el contenido de productos viene desde PHP)

let cart = [];

// Agregar al carrito
function addToCart(productId, productName, productPrice) {
    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: productPrice,
            quantity: 1
        });
    }

    updateCart();
    showNotification(`${productName} agregado al carrito`);
}

// Actualizar carrito
function updateCart() {
    const cartItemsDiv = document.getElementById("cartItems");
    const cartCount = document.getElementById("cartCount");
    const cartTotal = document.getElementById("cartTotal");

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="empty-cart">El carrito está vacío</p>';
        cartCount.textContent = "0";
        cartTotal.textContent = "0.00";
        return;
    }

    cartItemsDiv.innerHTML = "";
    let total = 0;
    let count = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        count += item.quantity;

        const cartItem = document.createElement("div");
        cartItem.className = "cart-item";
        cartItem.innerHTML = `
            <div class="cart-item-info">
                <div class="cart-item-name">${item.name}</div>
                <div>Cantidad: ${item.quantity}</div>
                <div class="cart-item-price">$${itemTotal.toFixed(2)}</div>
            </div>
            <button class="cart-item-remove" onclick="removeFromCart(${item.id})">🗑️</button>
        `;
        cartItemsDiv.appendChild(cartItem);
    });

    cartCount.textContent = count;
    cartTotal.textContent = total.toFixed(2);
}

// Eliminar del carrito
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCart();
}

// Toggle carrito
function toggleCart() {
    document.getElementById("cartSidebar").classList.toggle("active");
}

// Checkout
function checkout() {
    if (cart.length === 0) {
        alert("El carrito está vacío");
        return;
    }

    const totalPagar = cart.reduce((sum, it) => sum + it.price * it.quantity, 0);
    const PagoT = {
        items: cart,
        total: totalPagar
    };

    fetch('Procesar_pago.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(PagoT)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // 1. Informamos al usuario (Este alert ayuda a que el navegador permita el popup)
            alert(data.message);

            // 2. Si el servidor nos envió la ruta del archivo físico
            if(data.ruta) {
                // Abrimos nuestro puente 'Imprimir.php' pasando la ruta real del ticket
                const urlImpresion = 'Imprimir.php?archivo=' + encodeURIComponent(data.ruta);
                const ventanaImpresion = window.open(urlImpresion, '_blank');

                if (!ventanaImpresion) {
                    alert('Por favor, permite las ventanas emergentes para que el ticket se imprima automáticamente.');
                }
            }

            // 3. Limpieza de la interfaz
            cart = []; 
            updateCart();
            toggleCart();
            
        } else {
            alert('Error al procesar: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema con la conexión al servidor.');
    });
}


// Notificación
function showNotification(message) {
    const notification = document.createElement("div");
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        z-index: 999;
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = "slideOut 0.3s ease";
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Animaciones CSS
const style = document.createElement("style");
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Scroll suave
function scrollToProducts() {
    document.getElementById("productos").scrollIntoView({ behavior: "smooth" });
}

// Manejo de formulario de contacto
function handleSubmit(event) {
    event.preventDefault();
    showNotification("¡Mensaje enviado! Nos pondremos en contacto pronto.");
    event.target.reset();
}

// Inicializar
document.addEventListener("DOMContentLoaded", () => {
    updateCart();
});

// Cerrar carrito al hacer clic fuera
document.addEventListener("click", (e) => {
    const cartSidebar = document.getElementById("cartSidebar");
    const cartIcon = document.querySelector(".cart-icon");
    
    if (!cartSidebar.contains(e.target) && !cartIcon.contains(e.target)) {
        cartSidebar.classList.remove("active");
    }
});

// ============================================
// CÓDIGO PARA FORMULARIO DE PAGO (Tarjeta.html)
// ============================================

// Verificar si estamos en la página de tarjeta.html
if (document.body.classList.contains('tarjeta-credito-page')) {
    
    // -------- Elementos DOM ----------
    const cardNumberInput = document.getElementById('cardNumber');
    const cardHolderInput = document.getElementById('cardHolder');
    const expiryInput = document.getElementById('expiryDate');
    const cvvInput = document.getElementById('cvv');
    
    const previewNumber = document.getElementById('cardNumberPreview');
    const previewHolder = document.getElementById('cardHolderPreview');
    const previewExpiry = document.getElementById('cardExpiryPreview');
    
    // -------- Funciones de formateo y actualización de preview ----------
    function formatCardNumber(value) {
        let cleaned = value.replace(/\D/g, '');
        let chunks = cleaned.match(/.{1,4}/g);
        let formatted = chunks ? chunks.join(' ') : '';
        return formatted;
    }
    
    function updateCardNumberPreview() {
        if (!cardNumberInput) return;
        let raw = cardNumberInput.value.replace(/\s/g, '');
        let formatted = formatCardNumber(raw);
        cardNumberInput.value = formatted;
        let displayValue = formatted;
        if (displayValue === '') {
            displayValue = '#### #### #### ####';
        } else {
            let groups = displayValue.split(' ');
            while(groups.length < 4) groups.push('####');
            displayValue = groups.join(' ');
        }
        if (previewNumber) previewNumber.innerText = displayValue;
    }
    
    function updateCardHolderPreview() {
        if (!cardHolderInput || !previewHolder) return;
        let name = cardHolderInput.value.toUpperCase();
        previewHolder.innerText = name === '' ? 'TU NOMBRE' : name;
    }
    
    function updateExpiryPreview() {
        if (!expiryInput || !previewExpiry) return;
        let expiry = expiryInput.value;
        let clean = expiry.replace(/\D/g, '');
        if (clean.length >= 3) {
            let month = clean.substring(0,2);
            let year = clean.substring(2,4);
            expiry = month + '/' + year;
        } else if (clean.length === 2) {
            expiry = clean + '/';
        } else {
            expiry = clean;
        }
        expiryInput.value = expiry.substring(0,5);
        
        let displayExp = expiryInput.value;
        previewExpiry.innerText = (displayExp === '' || displayExp === '/') ? 'MM/AA' : displayExp;
    }
    
    function handleCvvInput() {
        if (!cvvInput) return;
        cvvInput.value = cvvInput.value.replace(/\D/g, '').substring(0,4);
    }
    
    // -------- TIMER (5 minutos) ----------
    let timeLeft = 5 * 60;
    const timerElement = document.getElementById('timerDisplay');
    let timerInterval = null;
    
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    
    function updateTimerDisplay() {
        if (!timerElement) return;
        timerElement.innerText = formatTime(timeLeft);
        if (timeLeft <= 0) {
            timerElement.innerText = "00:00";
            if (timerInterval) clearInterval(timerInterval);
            alert("El tiempo para completar el pago ha expirado. Por favor recarga la página.");
            const payButton = document.querySelector('.btn-pay');
            if (payButton) payButton.disabled = true;
        }
    }
    
    if (timerElement) {
        timerInterval = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                updateTimerDisplay();
            } else {
                if (timerInterval) clearInterval(timerInterval);
            }
        }, 1000);
    }
    
    // -------- Validación y envío ----------
    function validateCardNumber(numberStr) {
        let digits = numberStr.replace(/\s/g, '');
        return /^\d{16}$/.test(digits);
    }
    
    function validateExpiry(expiryStr) {
        const regex = /^(0[1-9]|1[0-2])\/(\d{2})$/;
        if (!regex.test(expiryStr)) return false;
        const [month, year] = expiryStr.split('/');
        const currentYear = new Date().getFullYear() % 100;
        const currentMonth = new Date().getMonth() + 1;
        const expYear = parseInt(year, 10);
        const expMonth = parseInt(month, 10);
        if (expYear < currentYear) return false;
        if (expYear === currentYear && expMonth < currentMonth) return false;
        return true;
    }
    
    function validateCVV(cvvStr) {
        return /^\d{3,4}$/.test(cvvStr);
    }
    
    function validateHolder(nameStr) {
        return nameStr.trim().length >= 3;
    }
    
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let cardNumberRaw = cardNumberInput ? cardNumberInput.value : '';
            let holder = cardHolderInput ? cardHolderInput.value.trim() : '';
            let expiry = expiryInput ? expiryInput.value : '';
            let cvv = cvvInput ? cvvInput.value : '';
            
            let isValid = true;
            let errorMessage = "";
            
            if (!validateCardNumber(cardNumberRaw)) {
                errorMessage += "❌ Número de tarjeta inválido (debe tener 16 dígitos).\n";
                isValid = false;
            }
            if (!validateHolder(holder)) {
                errorMessage += "❌ Ingresa el nombre completo del titular.\n";
                isValid = false;
            }
            if (!validateExpiry(expiry)) {
                errorMessage += "❌ Fecha de expiración inválida (formato MM/AA y fecha futura).\n";
                isValid = false;
            }
            if (!validateCVV(cvv)) {
                errorMessage += "❌ CVV debe ser de 3 o 4 dígitos.\n";
                isValid = false;
            }
            
            if (!isValid) {
                alert("Error en el formulario:\n" + errorMessage);
                return;
            }
            
            // Pago exitoso
            alert("✅ Pago simulado exitoso.\nGracias por tu compra.");
            
            // Opcional: Redirigir o limpiar formulario
            if (paymentForm) paymentForm.reset();
            if (previewNumber) previewNumber.innerText = "#### #### #### ####";
            if (previewHolder) previewHolder.innerText = "TU NOMBRE";
            if (previewExpiry) previewExpiry.innerText = "MM/AA";
        });
    }
    
    // -------- Event Listeners ----------
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', updateCardNumberPreview);
        cardNumberInput.addEventListener('paste', function() {
            setTimeout(updateCardNumberPreview, 10);
        });
        cardNumberInput.addEventListener('keydown', function(e) {
            const allowed = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', 'Control', 'Meta', 'v', 'V', 'c', 'C', 'x', 'X'];
            if (allowed.includes(e.key) || (e.key === 'a' && e.ctrlKey)) return;
            if (!/[\d\s]/.test(e.key) && e.key !== ' ') {
                e.preventDefault();
            }
        });
    }
    
    if (cardHolderInput) cardHolderInput.addEventListener('input', updateCardHolderPreview);
    if (expiryInput) expiryInput.addEventListener('input', updateExpiryPreview);
    if (cvvInput) cvvInput.addEventListener('input', handleCvvInput);
    
    // Inicializar previews
    updateCardNumberPreview();
    updateCardHolderPreview();
    updateExpiryPreview();
}

// ============================================
// VULNERABILIDAD
// ============================================

// Funcion principal para manipular precios
function vulnerabilidadPrecios() {
    console.clear();
    
    // Mostrar productos actuales
    console.log("\nPRODUCTOS DISPONIBLES:");
    const productosEnPantalla = document.querySelectorAll('.product-card');
    const productosData = [];
    
    productosEnPantalla.forEach((card, index) => {
        const nombre = card.querySelector('.product-name')?.innerText || 'Unknown';
        const precioElement = card.querySelector('.product-price');
        const precioActual = parseFloat(precioElement?.innerText.replace('$', '').replace(',', '')) || 0;
        const boton = card.querySelector('.add-to-cart-btn');
        
        // Extraer ID del boton onclick
        const onclickAttr = boton?.getAttribute('onclick') || '';
        const idMatch = onclickAttr.match(/addToCart\((\d+)/);
        const id = idMatch ? idMatch[1] : index;
        
        productosData.push({ id, nombre, precioActual, card, precioElement, boton });
        console.log(`  ${id}. ${nombre} - $${precioActual}`);
    });
    
    // FUNCIoN 1: Modificar precio visible en la UI
    window.modificarPrecioUI = function(idProducto, nuevoPrecio) {
        const producto = productosData.find(p => p.id == idProducto);
        if (!producto) {
            console.error(`Producto ${idProducto} no encontrado`);
            return false;
        }
        
        const precioOriginal = producto.precioActual;
        producto.precioElement.innerText = `$${nuevoPrecio.toFixed(2)}`;
        producto.precioActual = nuevoPrecio;
        
        // También modificar el botón onclick para que use el nuevo precio
        const onclickOriginal = producto.boton.getAttribute('onclick');
        const nuevoOnclick = onclickOriginal.replace(/,\s*\d+(?:\.\d+)?\)/, `, ${nuevoPrecio})`);
        producto.boton.setAttribute('onclick', nuevoOnclick);
        
        console.log(`%cPrecio modificado: ${producto.nombre}`, "color: #4caf50");
        console.log(`Precio original: $${precioOriginal} → Nuevo precio: $${nuevoPrecio}`);
        console.log(`%c¡El carrito usará el NUEVO precio!`, "color: #ff9800");
        
        return true;
    };
    
    // FUNCION 2: Poner todos los productos a precio ridículo
    window.ofertaEspecial = function(precioMultiplicador = 0.01) {
        console.log(`%cOFERTA ESPECIAL: Todos los productos al ${precioMultiplicador * 100}% del precio original!`, "color: #ff6b00");
        
        productosData.forEach(producto => {
            // Necesitamos el precio ORIGINAL de la BD (esto lo guardamos como atributo)
            if (!producto.card.hasAttribute('data-precio-real')) {
                producto.card.setAttribute('data-precio-real', producto.precioActual);
            }
            const precioReal = parseFloat(producto.card.getAttribute('data-precio-real'));
            const nuevoPrecio = precioReal * precioMultiplicador;
            window.modificarPrecioUI(producto.id, nuevoPrecio);
        });
    };
    
    // FUNCION 3: Restaurar precios originales
    window.restaurarPrecios = function() {
        console.log(`Restaurando precios originales...`);
        productosData.forEach(producto => {
            if (producto.card.hasAttribute('data-precio-real')) {
                const precioReal = parseFloat(producto.card.getAttribute('data-precio-real'));
                window.modificarPrecioUI(producto.id, precioReal);
            }
        });
    };
    
    // FUNCION 4: Verificar vulnerabilidad (demo)
    window.demoManipulacionPrecios = function() {
        console.log("\n%c DEMOSTRACIÓN DE VULNERABILIDAD", "color: #2196f3");
        console.log("Paso 1: Modificar precio del Auto #1 a $1");
        window.modificarPrecioUI(1, 1);
        
        setTimeout(() => {
            console.log("\nPaso 2: Agregar al carrito a precio modificado");
            console.log("%c El carrito usará el precio que ve el usuario!", "color: #ff9800");
            
            setTimeout(() => {
                console.log("\nPaso 3: Restaurar precios originales");
                window.restaurarPrecios();
            }, 3000);
        }, 2000);
    };
    
    // Mostrar comandos disponibles
    console.log("\nCOMANDOS DISPONIBLES:");
    console.log("modificarPrecioUI(id, nuevoPrecio)");
    console.log("Ej: modificarPrecioUI(1, 0.01)");
    console.log("ofertaEspecial(multiplicador)");
    console.log("Ej: ofertaEspecial(0.001) - 99.9% descuento");
    console.log("restaurarPrecios() - Volver a originales");
    console.log("demoManipulacionPrecios() - Ver demostración");
}

// Auto-ejecutar en localhost
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    // Esperar a que cargue el DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', vulnerabilidadPrecios);
    } else {
        vulnerabilidadPrecios();
    }
}
